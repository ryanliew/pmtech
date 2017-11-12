<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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

    public function index()
    {
    	return view('users.index', ['users' => User::all()]);
    }

    public function create()
    {
    	return view('users.create');
    }

    public function store()
    {
    	$messages = [
            'required'          =>  'This field is required', 
            'name.max'          =>  'Name should not be longer than 255 characters',
            'email.email'       =>  'Please enter a valid email',
            'email.unique'      =>  'This email already exists in the database',
            'ic.unique'         =>  'This IC number already exists in the database',
            'ic.numeric'        =>  'Please enter your IC number without dashes. eg.800514149687',
            'phone.unique'      =>  'This phone number already exists in the database'
        ];

    	$data = request()->validate([
		            'name'              =>  'required|max:255',
		            'email'             =>  'required|email|max:255|unique:users',
		            'ic'                =>  'required|unique:users|numeric',
		            'phone'             =>  'required|unique:users',
		            'alt_contact_phone' =>  'required',
		            'alt_contact_name'  =>  'required',
		            'payment_slip'      =>  'image',
		            'ic_copy'          	=>  'image',
		        ], $messages);

    	$ic_copy = ""; 
        $payment_slip = "";

        if(array_has($data, 'ic_copy'))
        {
            $ic_copy = $data['ic_copy']->store('identifications', 'public');
        }

        $default_password =  substr($data['ic'], -6);

        $user = User::create([
            'name'              =>  $data['name'],
            'email'             =>  $data['email'],
            'password'          =>  bcrypt($default_password),
            'ic_image_path'     =>  $ic_copy,
            'phone'             =>  $data['phone'],
            'ic'                =>  $data['ic'],
            'username'          =>  str_random(6),
            'alt_contact_name'  =>  $data['alt_contact_name'],
            'alt_contact_phone' =>  $data['alt_contact_phone'],
            'is_verified'		=> 	true
        ]);

        if(array_has($data, 'payment_slip'))
        {
            $payment_slip = $data['payment_slip']->store('payments', 'public');
            $user->payments()->create([
                'payment_slip_path'     => $payment_slip,
                'is_verified'           => false
            ]);
        }

        return redirect(route('users'))->with('success', $user->name . ' has been added.');
    }

    public function show(User $user)
    {
    	return view('users.show', ['user' => $user]);
    }

    public function update(User $user)
    {
    	$user->update([
    		'is_verified'	=> true
    	]);

    	return redirect(route('users'))->with('success', $user->name . ' is now verified.');
    }

    public function destroy(User $user)
    {
    	$user->update([
    		'is_verified'	=> false
    	]);

    	return redirect(route('users'))->with('success', $user->name . ' has been deactivated.');
    }	
}
