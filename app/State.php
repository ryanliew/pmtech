<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function areas()
    {
    	return $this->hasMany('App\Area');
    }

    public function users()
    {
    	return $this->hasMany('App\User');
    }
}
