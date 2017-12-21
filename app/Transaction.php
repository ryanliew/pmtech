<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $guarded = [];

	protected $appends = ['type_name', 'bitcoin_earning'];
	
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function earning()
    {
        return $this->belongsTo('App\Earning');
    }

    public function getTypeNameAttribute()
    {
    	return trans( 'pmentech.' . $this->type );
    }

    public function getBitcoinEarningAttribute()
    {
        return $this->conversion_rate > 0 ? $this->amount / $this->conversion_rate : 0;
    }

    /* Scope */
    public function scopeProfits($query)
    {
        return $query->where('type', 'profit');
    }

    public function scopeCommision($query)
    {
        return $query->where('type', 'one-time-commision');
    }

    public function scopeCurrent($query)
    {
        return $query->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year);
    }

    public function scopeLatest($query)
    {   
        return $query->whereMonth('date', Carbon::now()->subMonth()->month)->whereYear('date', Carbon::now()->subMonth()->year);
    }

    public function scopeMonth($query, $month, $year)
    {
        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }
}
