<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	protected $guarded = [];

	protected $with = ['investor'];

	/* Relationships */	
    public function machine()
    {
    	return $this->belongsTo('App\Machine');
    }

    public function investor()
    {
    	return $this->belongsTo('App\User', 'investor_id');
    }

    /* Mutators */
    public function getEarningThisMonthAttribute()
    {
    	return $this->machine()->earnings()->last()->final_amount / 10;
    }
}
