<?php

namespace App\Http\Controllers;

use App\Earning;
use App\Machine;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function store(Machine $machine)
    {
    	$data = request()->validate([
    		'month'		=> 	'required|numeric|min:1|max:12',
    		'amount'	=>	'required|numeric'
    	]);

    	$now = Carbon::now();

    	$date = Carbon::createFromDate( $now->year, $data['month'], $now->day);

    	// If it is december, move one year backwards
    	if($data['month'] == 12) $date->subYear();

    	$date = $date->lastOfMonth();

        if( $machine->earnings()->whereMonth('date', $date->month)->whereYear('date', $date->year)->count() >= 1 )
        {
            return back()->with('error', 'You have already added earning for ' . $date->format('F Y'));
        }	

        $machine->earnings()->create([
            'date'      => $date,
            'amount'    => $data['amount']
        ]);

        $this->sendGMBonus($date);

        return back()->with('success', "Added earning to " . $machine->name);
    }

    public function update(Earning $earning)
    {
        $data = request()->validate([
            'amount'    => 'required|numeric'
        ]);

        $earning->update([
            'amount'    => $data['amount']
        ]);

        return back()->with('success', "Edited earning for " . $earning->date->toDateString());
    }

    public function sendGMBonus($date)
    {
        $groupmanagers = User::all()->filter(function($user){ return $user->is_group_manager; });
        $totalpercentage = $groupmanagers->sum(function($user){ return $user->group_manager_bonus_percentage; });
        $totalcommision = $totalpercentage > 0 ? Transaction::month($date->month, $date->year)->commision()->sum('amount') * 10 / 100 / $totalpercentage : 0;

        if($totalcommision > 0)
        {
            foreach($groupmanagers as $groupmanager)
            {
                $percentage = $groupmanager->group_manager_bonus_percentage;
                $amount = $totalcommision * $percentage;
                $description = "Group manager bonus of " . $percentage . "%";
                $groupmanager->add_bonus_transaction($description, $amount, $date);
            }
        }
        
        // Reset all users is_active flag
        App\User::where('is_active', true)
                ->update(['is_active' =>  false]);
    }
}
