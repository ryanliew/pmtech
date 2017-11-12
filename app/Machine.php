<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
	protected $fillable = ['name'];
	
    public function units()
    {
    	return $this->hasMany('App\Unit');
    }

    public function earnings()
    {
    	return $this->hasMany('App\Earning');
    }
}
