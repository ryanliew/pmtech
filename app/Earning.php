<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
	protected $dates = [
		'date'
	];

    protected $guarded = [];


    public function machine()
    {
    	return $this->belongsTo('App\Machine');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($earning) {
            $setting = Setting::first();

            $deduction = $setting->fee_rental_per_month 
                        + $setting->fee_internet_per_month 
                        + $setting->fee_electric_per_month
                        + $setting->fee_overhead_1
                        + $setting->fee_overhead_2
                        + $setting->fee_overhead_3;

            $final_amount = $earning->amount - $deduction;
            
            $admin_fee = $final_amount * ( $setting->fee_admin_percentage_per_month - 1 ) / 100;
            $marketing_agent_share = $final_amount * 1 / 100;

            $deduction += $admin_fee + $marketing_agent_share;

            $earning->update(['deduction' => $deduction]);

            $earning->distribute_profit();

            $earning->distribute_marketing_agent_profit($marketing_agent_share);
        });
    }

    /* Accessors */

    public function getIsCurrentAttribute()
    {
    	return $this->date->month = Carbon::now()->subMonth()->month;
    }

    public function getFinalAmountAttribute()
    {
        return $this->amount - $this->deduction;
    }

    /* Methods */

    public function distribute_profit()
    {
        foreach($this->machine->units()->where('investor_id', '<>', null)->get() as $unit)
        {
            $unit->investor->add_profit_transaction($unit, $this);
        }
    }

    public function distribute_marketing_agent_profit($amount)
    {
        $description = "Profit sharing from " . $this->machine->name . " earning for " . $this->date->toDateString();
        foreach(User::marketingAgent()->get() as $marketing_agent)
        {

            $marketing_agent->add_bonus_transaction($description, $amount, $this->date);
        }
    }

    /* Scope */

    public function scopeAfter($query, $date)
    {
        return $query->whereDate('date', '>=', $date);
    }
}
