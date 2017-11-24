<?php

namespace App;

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
}
