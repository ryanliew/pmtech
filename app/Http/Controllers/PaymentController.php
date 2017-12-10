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

    public function index(User $user)
    {
        return $user->payments()->paginate(100);
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

        $payment->user->update(['is_investor' => true]);

        if(request()->expectsJson()){
            return response(200);
        }

    	return back()->with('success', 'Payment#' . $payment->id . ' approved.');
    }

    public function assign(Payment $payment)
    {
        $validated = request()->validate([
            'id' => 'required',
        ]);

        $machine = \App\Machine::findOrFail($validated['id']);

        $unit = $machine->units()->whereNull('investor_id')->first();

        $payment->update([
            'unit_id' => $unit->id
        ]);

        $unit->update([
            'investor_id' => $payment->user_id
        ]);

        return response($unit, 200);
    }
}
