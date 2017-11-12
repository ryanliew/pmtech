<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
	protected $dates = [
		'date'
	];

    public function machine()
    {
    	return $this->belongsTo('App\Machine');
    }

    public function getIsCurrentAttribute()
    {
    	return $this->date->month = Carbon::now()->subMonth()->month;
    }
}
