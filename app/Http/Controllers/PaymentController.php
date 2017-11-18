<?php

namespace App\Http\Controllers;

use App\Payment;
use App\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $validated = request()->validate([
            'payment_slip' => 'required|image'
        ]);

        $payment_slip = $validated['payment_slip']->store('payments', 'public');

        $user = auth()->user();

        if(array_has(request()->all(), "user_id"))
        {
            $user = User::findOrFail(request()->user_id);
        }

        $user->add_payment($payment_slip);

        return back()->with('success', 'Payment added');
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
