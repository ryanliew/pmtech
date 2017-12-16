<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }

    public function units()
    {
        return $this->belongsToMany('App\Unit')->withTimestamps();
    }
    
    public function getPaymentSlipPathAttribute($payment)
    {
        return asset( $payment ? 'storage/' . $payment : "" );
    }
}
