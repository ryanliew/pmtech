<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
    	return view('users.index', ['users' => User::latest()->with('units')->paginate(20)]);
    }

    public function payments()
    {
        $date = Carbon::now()->subMonth();

        $users = DB::table('users')
                    ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
                    ->whereRAW('MONTH(date) = ? AND YEAR(date) = ?', [$date->month, $date->year])
                    ->select(DB::raw('sum(`transactions`.`amount`) as total, name, bank_name, bank_account_number, bitcoin_address'))
                    ->groupBy('users.id')
                    ->orderByDesc('total')
                    ->paginate(20);

        return view('users.payments', ['users' => $users, 'date' => $date->format('F Y')]);
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
            'phone.unique'      =>  'This phone number already exists in the database',
            'area_id.numeric'   =>  'Please select a valid area'
        ];

        $data = request()->validate([
            'name'              =>  'required|max:255',
            'email'             =>  'required|email|max:255|unique:users',
            'ic'                =>  'required|unique:users|numeric',
            'phone'             =>  'required|unique:users',
            'alt_contact_phone' =>  'required',
            'alt_contact_name'  =>  'required',
            'bank_name'         =>  'required',
            'bank_account_number'   =>  'required',
            'bitcoin_address'   =>  'required',
            'payment_slip'      =>  'image',
            'ic_copy'           =>  'image',
            'contract_upload'   =>  'max:5000',
            'area_id'           =>  'required|numeric'
        ], $messages);

    	$ic_copy = ""; 
        $payment_slip = "";
        $contract = "";

        if(array_has($data, 'ic_copy'))
        {
            $ic_copy = $data['ic_copy']->store('identifications', 'public');
        }

        if(array_has($data, 'contract_upload'))
        {
            $contract = $data['contract_upload']->store('contracts', 'public');
        }

        $default_password =  substr($data['ic'], -6);

        $user = User::create([
            'name'              =>  $data['name'],
            'email'             =>  $data['email'],
            'password'          =>  bcrypt($default_password),
            'ic_image_path'     =>  $ic_copy,
            'investor_agreement_path' => $contract,
            'phone'             =>  $data['phone'],
            'ic'                =>  $data['ic'],
            'username'          =>  str_random(6),
            'alt_contact_name'  =>  $data['alt_contact_name'],
            'alt_contact_phone' =>  $data['alt_contact_phone'],
            'area_id'           =>  $data['area_id'],
            'bitcoin_address'   =>  $data['bitcoin_address'],
            'bank_name'         =>  $data['bank_name'],
            'bank_account_number'   =>  $data['bank_account_number'],
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

    public function edit(User $user)
    {
        if (empty($user->id)) $user = auth()->user();

        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $messages = [
            'required'          =>  'This field is required', 
            'name.max'          =>  'Name should not be longer than 255 characters',
            'email.email'       =>  'Please enter a valid email',
            'email.unique'      =>  'This email already exists in the database',
            'ic.unique'         =>  'This IC number already exists in the database',
            'ic.numeric'        =>  'Please enter your IC number without dashes. eg.800514149687',
            'phone.unique'      =>  'This phone number already exists in the database',
            'area_id.numeric'   =>  'Please select a valid area',
            'terms.required_with' => 'You must read and accept the terms and conditions to become a marketing agent'
        ];

        if(empty($user->id)) $user = auth()->user();

        $data = request()->validate([
            'name'              =>  'sometimes|required|max:255',
            'email'             =>  ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'ic'                =>  ['sometimes', 'required', 'numeric', Rule::unique('users')->ignore($user->id)],
            'phone'             =>  ['sometimes', 'required', Rule::unique('users')->ignore($user->id)],
            'alt_contact_phone' =>  'required',
            'alt_contact_name'  =>  'required',
            'bank_name'         =>  'required', 
            'bank_account_number'   => 'required',
            'bitcoin_address'   =>  'required',
            'ic_image_path'     =>  'image|max:5000',
            'investor_agreement_path'   =>  'max:5000',
            'area_id'           =>  'required|numeric',
            'terms'             =>  'required_with:ic_image_path'
        ], $messages);

        

        if(array_has($data, 'ic_image_path'))
        {
            $data['ic_image_path'] = $data['ic_image_path']->store('identifications', 'public');
        }

        if(array_has($data, 'investor_agreement_path'))
        {
            $data['investor_agreement_path'] = $data['investor_agreement_path']->store('contracts', 'public');
        }

        $user->update($data);



        return back()->with('success', 'Profile has been updated');
    }

    public function updatePassword(User $user)
    {   
        //dd(request()->all());

        $data = request()->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if( ! Hash::check(request()->current_password, $user->password)) return back()->with('error', 'The current password is wrong');

        $user->update([
            "password" => bcrypt(request()->new_password),
            "is_default_password" => false
        ]);

        return back()->with('success', 'Your password has been updated');
    }

    public function verify(User $user)
    {
    	$user->verify();

    	return redirect(route('users'))->with('success', $user->name . ' is now verified.');
    }

    public function destroy(User $user)
    {
    	$user->update([
    		'is_verified'	=> false
    	]);

    	return redirect(route('users'))->with('success', $user->name . ' has been deactivated.');
    }

    public function verifyMarketing(User $user)
    {
        $user->verifyMarketing();

        return redirect(route('users'))->with('success', $user->name . ' is now verified as marketing agent.');
    }

    public function destroyMarketing(User $user)
    {
        $user->update([
            'is_verified_marketing_agent'   => false
        ]);

        return redirect(route('users'))->with('success', $user->name . ' has been revoked as a marketing agent.');
    }

    public function updateIdentity(User $user)
    {
        $data = request()->validate([
            'ic_image_path'     =>  'required|image',
        ]);

        $data['ic_image_path'] = $data['ic_image_path']->store('identifications', 'public');

        $user->update($data);

        return back()->with('success', "IC for " . $user->name . " has been added");
    }

    public function milestone()
    {
        $user = auth()->user();

        $result = [
            'string' => $user->next_role_string,
            'description' => $user->next_role_description,
            'percentage' => $user->next_role_percentage,
            'descendents' => $user->active_descendents_percentage
        ];

        return json_encode($result);
    }
}
