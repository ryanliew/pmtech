<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* Relations */
    public function referrer()
    {
        return $this->belongsTo('App\User', 'referrer_id');
    }

    public function referees()
    {
        return $this->hasMany('App\User', 'referrer_id');
    }

    /* Mutators */
    public function getReferralLinkAttribute()
    {
        return url("/register?r=" . $this->username);
    }

    public function getRefereesCountAttribute()
    {
        return $this->referees->count();
    }

    public function getPaymentSlipPathAttribute($payment)
    {
        return asset( $payment ? 'storage/' . $payment : "" );
    }

    public function getIcImagePathAttribute($ic)
    {
        return asset( $ic ? 'storage/' . $ic : "" );
    }

    /* Methods */
    public function update_referrer($referrer_id)
    {
        $referrer = User::where('username', $referrer_id)->first();

        if( !is_null( $referrer ) )
        {
            $this->update(['referrer_id' => $referrer->id]);
        }  
    }


}
