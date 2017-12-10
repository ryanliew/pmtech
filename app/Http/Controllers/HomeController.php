<?php

namespace App\Http\Controllers;

use App\Machine;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Transaction::profits()->sum('amount');
        return view('home', ['unverified_users' => User::inactive()->get(), 
                                'payments' => $payments,
                                'machines' => Machine::count(),
                                'commision' => Transaction::commision()->current()->sum('amount')
                            ]);
    }

    public function repeater()
    {
        $url = request()->url;

        $client = new \GuzzleHttp\Client();

        $request = $client->get($url);

        $response = $request->getBody();
        
        return($response);   
    }
}
