<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    //
    //
    public function index()
    {

    	$user = User::where('confirmation_token', request('token'))->first();

        if(! $user) {
            return redirect(route('home'))->with('flash', 'Unknown token');
        }
        
        $user->confirm();

    	return redirect(route('home'))
    			->with('flash', 'Your email is now confirmed!');
    }

    public function resend()
    {
        $user = auth()->user();
        Mail::to($user)->send(new PleaseConfirmYourEmail($user));
        return response(200);   
    }	
}
