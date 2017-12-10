<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Machine extends Model
{
	protected $fillable = ['name'];
    
    protected static function boot()
    {
        parent::boot();

        static::created(function($machine) {
            factory('App\Unit', 10)->create([ "investor_id" => null, "machine_id" => $machine->id ]);
        });
    }	

    /* Relationships */
    public function units()
    {
    	return $this->hasMany('App\Unit');
    }

    public function earnings()
    {
    	return $this->hasMany('App\Earning');
    }

    public function latest_earning()
    {
        return $this->earnings()->latest()->first();
    }

    public function earningSum()
    {
        return $this->hasOne('App\Earning')
                    ->selectRaw('machine_id, sum(amount - deduction) as aggregate')
                    ->groupBy('machine_id');
    }

    public function earningSumAfterDate($updated_at)
    {
        $result = DB::table('earnings')
                    ->selectRaw('sum(amount - deduction) as aggregate')
                    ->whereDate('date', '>=', $updated_at)
                    ->where('machine_id', $this->id)
                    ->groupBy('machine_id')
                    ->first();

        return $result;
    }

    public function emptyUnitCount()
    {
        return $this->hasOne('App\Unit')
                    ->selectRaw('machine_id, count(id) as aggregate')
                    ->where('investor_id', null)
                    ->groupBy('machine_id');
    }

    /* Mutators */
    public function getTotalEarningAttribute()
    {
        if( !array_key_exists('earningSum', $this->relations))
            $this->load('earningSum');

        $related = $this->getRelation('earningSum');

        return ($related) ? $related->aggregate : 0;
    }

    public function getEmptyUnitCountAttribute()
    {
        if( !array_key_exists('emptyUnitCount', $this->relations))
            $this->load('emptyUnitCount');

        $related = $this->getRelation('emptyUnitCount');

        return ($related) ? $related->aggregate : 0;
    }


}
