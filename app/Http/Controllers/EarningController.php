<?php

namespace App\Http\Controllers;

use App\Earning;
use App\Machine;
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

        if( $machine->earnings()->whereMonth('date', $date->month)->whereYear('date', $date->year)->count() > 1 )
        {
            return back()->with('error', 'You have already added earning for ' . $date->format('F Y'));
        }	

        $machine->earnings()->create([
            'date'      => $date,
            'amount'    => $data['amount']
        ]);

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
}
