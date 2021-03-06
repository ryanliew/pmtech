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

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'earning_id');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::created(function($earning) {
            
            $deduction = Earning::calculateDeduction($earning->amount);

            $earning->distribute_profit();

            $earning->distribute_marketing_agent_profit($deduction[1], $earning);
        });

        static::updated(function($earning){
    
            $earning->transactions()->delete();

            $deduction = Earning::calculateDeduction($earning->amount);

            $earning->distribute_profit();

            $earning->distribute_marketing_agent_profit($deduction[1], $earning);
        
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

    public function getConversionRateAttribute()
    {
        return $this->final_amount / $this->cryptocurrency_amount;
    }

    /* Methods */

    public function distribute_profit()
    {
        foreach($this->machine->units()->where('investor_id', '<>', null)->get() as $unit)
        {
            $unit->investor->add_profit_transaction($unit, $this);
        }
    }

    public function distribute_marketing_agent_profit($amount, $earning)
    {
        $description = "Profit sharing from " . $this->machine->name . " earning for " . $this->date->toDateString();

        $investors = \App\User::whereIn( 'id', $this->machine->units->unique('investor_id')->pluck('investor_id')->filter())->get();
        foreach( $investors as $investor)
        {
            $referrer = $investor->referrer;
            
            if($referrer !== null) 
            {
                $number_of_units = $this->machine->units()->where('investor_id', $investor->id)->count();
                $final_amount = $amount / 10 * $number_of_units;
                $referrer->add_bonus_transaction($description, $final_amount, $this->date, $earning);
            }
        }
    }

    public static function calculateDeduction($amount)
    {
        $setting = Setting::first();

        $deduction = $setting->fee_rental_per_month 
                    + $setting->fee_internet_per_month 
                    + $setting->fee_electric_per_month
                    + $setting->fee_overhead_1
                    + $setting->fee_overhead_2
                    + $setting->fee_overhead_3;

        $final_amount = $amount - $deduction;
        
        $admin_fee = $final_amount * ( $setting->fee_admin_percentage_per_month - 1 ) / 100;

        $marketing_agent_share = $final_amount / 100; // final amount * 1 / 100 (1%)

        $deduction = $deduction + $admin_fee + $marketing_agent_share;

        return [$deduction, $marketing_agent_share];
    }

    /* Scope */

    public function scopeAfter($query, $date)
    {
        return $query->whereDate('date', '>=', $date);
    }
}
