<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Payment $payment)
    {
    	request()->validate([
    		'amount' => 'required'
    	]);

    	$payment->update([
    		'amount'		=> 	request()->amount,
    		'is_verified'	=>	true
    	]);

    	return back()->with('success', 'Payment#' . $payment->id . ' approved.');
    }
}
