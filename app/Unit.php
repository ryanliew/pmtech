<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function machine()
    {
    	return $this->belongsTo('App\Machine');
    }

    public function investor()
    {
    	return $this->belongsTo('App\User', 'investor_id');
    }
}
