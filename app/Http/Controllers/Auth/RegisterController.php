<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'required'                  =>  'This field is required', 
            'name.max'                  =>  'Your name should not be longer than 255 characters',
            'email.email'               =>  'Please enter a valid email',
            'email.unique'              =>  'This email already exists in our database',
            'ic.unique'                 =>  'This IC number already exists in our database',
            'ic.numeric'                =>  'Please enter your IC number without dashes. eg.800514149687',
            'phone.unique'              =>  'This phone number already exists in our database',
            'payment_slip.required_if'  =>  'Payment slip is required to join as an investor',
            'ic_image.required_if'      =>  'You must upload the photocopy of your IC in order to join us as an marketing agent',
            'area_id.numeric'           =>  'Please select a valid area'
        ];
        return Validator::make($data, [
            'name'              =>  'required|max:255',
            'email'             =>  'required|email|max:255|unique:users',
            'terms'             =>  'accepted',
            'ic'                =>  'required|unique:users|numeric',
            'phone'             =>  'required|unique:users',
            'alt_contact_phone' =>  'required',
            'alt_contact_name'  =>  'required',
            'payment_slip'      =>  'required_if:type,==,investor|image',
            'ic_copy'           =>  'required_if:type,==,agent|image',
            'area_id'           =>  'required|numeric'
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
            'username'          =>  str_limit(md5(str_random() . $data['email']), 6, ''),
            'alt_contact_name'  =>  $data['alt_contact_name'],
            'alt_contact_phone' =>  $data['alt_contact_phone'],
            'area_id'           =>  $data['area_id'],
            'confirmation_token' => str_limit(md5($data['email'] . str_random()), 25, '')
        ]);

        $user->update_referrer($data['referrer_user']);

        if(array_has($data, 'payment_slip'))
        {
            $payment_slip = $data['payment_slip']->store('payments', 'public');
            $user->add_payment($payment_slip);
        }
        
        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        Mail::to($user)->send(new PleaseConfirmYourEmail($user));

        return redirect($this->redirectPath());
    } 
}
