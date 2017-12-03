<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $guarded = [];

	protected $appends = ['type_name'];
	
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function getTypeNameAttribute()
    {
    	return trans( 'pmentech.' . $this->type );
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
        return $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeMonth($query, $month, $year)
    {
        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }
}
