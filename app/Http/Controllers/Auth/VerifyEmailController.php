<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
}
