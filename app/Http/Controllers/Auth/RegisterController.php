<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'required'          =>  'This field is required', 
            'name.max'          =>  'Your name should not be longer than 255 characters',
            'email.email'       =>  'Please enter a valid email',
            'email.unique'      =>  'This email already exists in our database',
            'ic.unique'         =>  'This IC number already exists in our database',
            'ic.numeric'        =>  'Please enter your IC number without dashes. eg.800514149687',
            'phone.unique'      =>  'This phone number already exists in our database',
            'ic_image.required' =>  'You must upload the photocopy of your IC in order to join us as an marketing agent'
        ];

        return Validator::make($data, [
            'name'              =>  'required|max:255',
            'email'             =>  'required|email|max:255|unique:users',
            'terms'             =>  'accepted',
            'ic'                =>  'required|unique:users|numeric',
            'phone'             =>  'required|unique:users',
            'alt_contact_phone' =>  'required',
            'alt_contact_name'  =>  'required',
            'payment_slip'      =>  'sometimes|required|image',
            'ic_copy'          =>  'sometimes|required|image'
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
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
            'alt_contact_phone' =>  $data['alt_contact_phone']
        ]);

        $user->update_referrer($data['referrer_user']);

        if(array_has($data, 'payment_slip'))
        {
            $payment_slip = $data['payment_slip']->store('payments', 'public');
            $user->payments()->create([
                'payment_slip_path' => $payment_slip
            ]);
        }
        
        return $user;
    }
}
