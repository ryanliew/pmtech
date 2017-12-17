<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
    	$setting = Setting::all()->first();

    	return view('settings', ['setting' => $setting]);
    }

    public function update()
    {
    	$data = request()->validate([
    		'fee_rental_per_month' 				=> "required|numeric",
    		'fee_electric_per_month'			=> "required|numeric",
    		'fee_admin_percentage_per_month' 	=> "required|min:0|max:100|numeric",
    		'fee_internet_per_month'			=> "required|numeric",
            'fee_overhead_1'                    => "required|numeric",
            'fee_overhead_2'                    => "required|numeric",
            'fee_overhead_3'                    => "required|numeric",
    		'incentive_commission_per_referee'	=> "required|numeric",
    		'incentive_bonus_per_referee_pack'	=> "required|numeric",
    		'incentive_direct_downline_commission_percentage'	=> "required|min:0|max:100|numeric",
            'hashing_power'  => "required|numeric",
    	]);

    	$setting = Setting::all()->first();

    	$setting->update($data);

    	return back()->with('success', "Settings updated");
    }

    public function calculateDeduction()
    {
        $setting = Setting::all()->first();

        $deduction = $setting->fee_rental_per_month 
                        + $setting->fee_internet_per_month 
                        + $setting->fee_electric_per_month
                        + $setting->fee_overhead_1
                        + $setting->fee_overhead_2
                        + $setting->fee_overhead_3;

        $final_amount = request()->amount - $deduction;
        
        $admin_fee = $final_amount * ( $setting->fee_admin_percentage_per_month - 1 ) / 100;
        $marketing_agent_share = $final_amount * 1 / 100;

        $deduction += $admin_fee + $marketing_agent_share;

        return $deduction;
    }
}
