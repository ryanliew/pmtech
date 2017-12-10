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

            $deduction = ($earning->amount * $setting->fee_admin_percentage_per_month / 100) 
                        + $setting->fee_rental_per_month 
                        + $setting->fee_internet_per_month 
                        + $setting->fee_electric_per_month;

            $earning->update(['deduction' => $deduction]);

            $earning->distribute_profit();
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

    /* Scope */

    public function scopeAfter($query, $date)
    {
        return $query->whereDate('date', '>=', $date);
    }
}
