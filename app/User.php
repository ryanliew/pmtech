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

    public function payments()
    {
        return $this->hasMany('App\Payment');
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
        return !empty($ic) ? asset( 'storage/' . $ic ) : "";
    }

    public function getStatusAttribute()
    {
        return $this->is_verified ? 'Active' : 'Pending verfification';
    }

    public function getIsMarketingAgentAttribute()
    {
        return !empty( $this->ic_image_path );
    }

    public function getIsInvestorAttribute()
    {
        return $this->payments->count() > 0;
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

    /* Scopes */
    public function scopeActive($query)
    {
        return $query->where('is_verified', true);
    }


}
