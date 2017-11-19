<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(User $user)
    {
    	$month = Carbon::now()->month;

    	if( isset(request()->month) ) $month = request()->month;

    	$transactions = $user->transactions()->whereMonth('created_at', $month)->paginate(20);

    	return view('transactions.index', ['user' => $user, 'transactions' => $transactions, '']);
    }
}
