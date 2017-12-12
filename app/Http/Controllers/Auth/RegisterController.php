<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
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
            'required'                      =>  'This field is required', 
            'name.max'                      =>  'Your name should not be longer than 255 characters',
            'email.email'                   =>  'Please enter a valid email',
            'email.unique'                  =>  'This email already exists in our database',
            'ic.unique'                     =>  'This IC number already exists in our database',
            'ic.numeric'                    =>  'Please enter your IC number without dashes. eg.800514149687',
            'phone.unique'                  =>  'This phone number already exists in our database',
            'payment_slip.required_if'      =>  'Payment slip is required to join as an investor',
            'contract_upload.required_if'   =>  'You must upload the signed agreenment to join as an investor',
            'ic_image.required_if'          =>  'You must upload the photocopy of your IC in order to join us as an marketing agent',
            'area_id.numeric'               =>  'Please select a valid area',
            'contract_upload.max'           =>  'The signed agreement must not be more than 5MB',
            'payment_slip.max'              =>  'The payment slip must not be more than 5MB',
            'ic_copy.max'                   =>  'The photocopy of your IC must not be more than 5MB',
        ];
        return Validator::make($data, [
            'name'                  =>  'required|max:255',
            'email'                 =>  'required|email|max:255|unique:users',
            'terms'                 =>  'required_if:type,==,agent',
            'ic'                    =>  'required|unique:users|numeric',
            'phone'                 =>  'required|unique:users',
            'alt_contact_phone'     =>  'required',
            'alt_contact_name'      =>  'required',
            'payment_slip'          =>  'required_if:type,==,investor|image|max:5000',
            'contract_upload'       =>  'required_if:type,==,investor|max:5000',
            'ic_copy'               =>  'required_if:type,==,agent|image|max:5000',
            'area_id'               =>  'required|numeric',
            'bitcoin_address'       =>  'required',
            'bank_account_number'   =>  'required',
            'bank_name'             =>  'required',
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
            'name'                  =>  $data['name'],
            'email'                 =>  $data['email'],
            'password'              =>  bcrypt($default_password),
            'ic_image_path'         =>  $ic_copy,
            'phone'                 =>  $data['phone'],
            'ic'                    =>  $data['ic'],
            'username'              =>  str_limit(md5(str_random() . $data['email']), 6, ''),
            'alt_contact_name'      =>  $data['alt_contact_name'],
            'alt_contact_phone'     =>  $data['alt_contact_phone'],
            'area_id'               =>  $data['area_id'],
            'confirmation_token'    =>  str_limit(md5($data['email'] . str_random()), 25, ''),
            'bitcoin_address'       =>  $data['bitcoin_address'],
            'bank_account_number'   =>  $data['bank_account_number'],
            'bank_name'             =>  $data['bank_name'],
        ]);

        $user->update_referrer($data['referrer_user']);

        if(array_has($data, 'payment_slip'))
        {
            $payment_slip = $data['payment_slip']->store('payments', 'public');
            $user->add_payment($payment_slip);
        }

        if(array_has($data, 'contract_upload'))
        {
            $contract = $data['contract_upload']->store('contracts', 'public');
            $user->update(['investor_agreement_path' => $contract]);
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
        if(App::environment('production')) {
            Mail::to($user)->send(new PleaseConfirmYourEmail($user));
        }
        return redirect($this->redirectPath());
    } 
}
