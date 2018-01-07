<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(User $user)
    {
        if($user == auth()->user() || auth()->user()->is_admin)
    	{
            $start = Carbon::now()->startOfMonth();
        	$end = $start->addMonth()->endOfMonth();
        	//if( isset(request()->month) ) $month = request()->month;

        	if( isset(request()->start) ) {
        		$start = Carbon::createFromFormat('m-Y', request()->start)->startOfMonth();
        		$end = Carbon::createFromFormat('m-Y', request()->end)->endOfMonth();
        	}

        	$transactions = $user->transactions()->whereDate('created_at', '>=', $start->toDateString())->whereDate('created_at', '<', $end->toDateString())->latest()->paginate(20);

        	if(request()->expectsJson()) {
        		return $transactions;
        	}

        	return view('transactions.index', ['user' => $user, 'transactions' => $transactions]);
        }
        else
        {
            return back()->with('error', 'You are unauthorized.');
        }
    }
}
