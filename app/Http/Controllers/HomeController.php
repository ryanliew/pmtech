<?php

namespace App\Http\Controllers;

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
        return view('home', ['unverified_users' => User::inactive()->get()]);
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
