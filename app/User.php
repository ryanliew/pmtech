<?php

namespace App;

use App\Setting;
use App\Transaction;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function units()
    {
        return $this->hasMany('App\Unit', 'investor_id');
    }

    /* Accessors */
    public function getReferralLinkAttribute()
    {
        return url("/register?as=investor&r=" . $this->username);
    }

    public function getMarketingReferralLinkAttribute()
    {
        return url("/register?as=marketing&r=" . $this->username);
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

    public function getIsInvestorAttribute()
    {
        return $this->payments()->where('is_verified', true)->count() > 0;
    }

    public function getIsMarketingAgentAttribute()
    {
        return !empty( $this->ic_image_path ) && $this->referees->filter(function($referee, $key){
                return $referee->is_investor;
        })->count() > 0;
    }

    public function getIsTeamLeaderAttribute()
    {
        return $this->descending_marketing_agent_count >= 5;   
    }

    public function getIsGroupManagerAttribute()
    {
        return  $this->descending_marketing_agent_count >= 50
                ||  $this->descending_team_leader_count >= 10;
    }

    public function getDescendingTeamLeaderCountAttribute()
    {
        return $this->referees->filter(function($referee, $key) {return $referee->is_team_leader; })->count();
    }

    public function getDescendingMarketingAgentCountAttribute()
    {
        return $this->referees->filter(function($referee, $key) {return $referee->is_marketing_agent; })->count();
    }

    public function getDescendingInvestorCountAttribute()
    {
        return $this->referees->filter(function($referee, $key) {return $referee->is_investor; })->count();
    }

    public function getNextRoleStringAttribute()
    {
        $string = "Marketing agent";

        if($this->is_marketing_agent) $string = "Team leader"; 
        if($this->is_team_leader) $string = "Group manager";

        return $string;
    }

    public function getRoleStringAttribute()
    {
        $role = [];

        if($this->is_investor) array_push($role, "Investor");

        if($this->is_group_manager) { array_push($role, "Group manager"); }
        elseif($this->is_team_leader) { array_push($role, "Team leader"); }
        elseif($this->is_marketing_agent) { array_push($role, "Marketing agent"); }

        return implode(", ", $role);
    }

    public function getNextRolePercentageAttribute()
    {
        $percentage = 0.0;

        if($this->is_marketing_agent)
        {
            $percentage = $this->descending_marketing_agent_count / 5 * 100;
        }

        if($this->is_team_leader)
        {
            $percentage = $this->descending_team_leader_count / 10 * 100;
        }

        return $percentage;
    }

    public function getNextRoleDescriptionAttribute()
    {
        $string = "Refer an investor to become a marketing agent";

        if($this->is_marketing_agent)
        {
            $string = "Refer " . ( 5 - $this->descending_marketing_agent_count ) . " more active marketing agent to become team leader";
        }

        if($this->is_team_leader)
        {
            $string = "Refer " . ( 10 - $this->descending_team_leader_count ). " more team leaders OR " . ( 50 - $this->descending_marketing_agent_count ) . " active marketing agent to become group manager";
        }

        if($this->is_group_manager)
        {
            $string = "Congratulations! You are at the top level!";
        }

        return $string;
    }

    public function getTotalNumberOfReferralAttribute()
    {
        return $this->referees->filter(function($referee){ return $referee->is_marketing_agent; })->count() + $this->referees->filter(function($referee){ return $referee->is_marketing_agent; })->sum(function($referee){ return $referee->total_number_of_referral; });
    }

    public function getTotalNumberOfActiveReferralAttribute()
    {
        return $this->referees()->where('is_active', true)->count() + $this->referees->sum(function($referee){ return $referee->total_number_of_active_referral; });
    }

    public function getActiveDescendentsPercentageAttribute()
    {
        return $this->total_number_of_referral > 0 ? $this->total_number_of_active_referral / $this->total_number_of_referral * 100 : 0;
    }

    public function getGroupManagerBonusPercentageAttribute()
    {
        $percentage = 0;
        $active_percentage = $this->active_descendents_percentage;
        if( $active_percentage >= 100 )
        {
            $percentage = 10;
        }
        else if( $active_percentage >= 80 )
        {
            $percentage = 8;
        }
        else if( $active_percentage >= 50 )
        {
            $percentage = 5;
        }

        return $percentage;
    }

    /* Mutators */
    public function setIsVerifiedAttribute($value)
    {
        $this->attributes['is_verified'] = $value;

        if( $value == 1 && $this->is_investor && null !== $this->referrer )
        {
            $this->referrer->add_referrer_bonus_transaction($this);
        }
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

    public function verify()
    {
        $this->update(['is_verified' => true]);

        if( $this->is_investor && !is_null($this->referrer) ) $this->referrer->update(['is_active' => true]);
    }

    public function add_payment($payment_slip_path)
    {
        $this->payments()->create([
            'payment_slip_path' => $payment_slip_path
        ]);
    }

    public function add_referrer_bonus_transaction(User $user)
    {
        $settings = Setting::all()->first();

        $amount = $settings->incentive_commission_per_referee;

        $description = "Successfully referred a new investor " . $user->name . ' at ' . $user->created_at->toDateString();

        $date = $user->created_at;

        $this->add_transaction("one-time-commision", $description, $amount, $date);

        $now = Carbon::now();

        
        // 5 referee per month bonus
        if($this->referees()->active()->whereMonth('created_at', $now->month)->count() == 4) {
            $description = "Gained bonus for referring 5 investor in " . $now->Format("F Y");
            $amount = $settings->incentive_bonus_per_referee_pack;
            $this->add_bonus_transaction($description, $amount, $date);
        }

        // Team leader commission
        if(isset($this->referrer) && $this->referrer->is_team_leader) {
            $description = "Gained team leader commission from " . $this->name;
            $amount = $settings->incentive_commission_per_referee * $settings->incentive_direct_downline_commission_percentage / 100; 
            $this->referrer->add_bonus_transaction($description, $amount, $date);
        }
    }

    public function add_bonus_transaction($description, $amount, $date)
    {
        $this->add_transaction("bonus", $description, $amount, $date);
    }

    public function add_profit_transaction(Unit $unit, Earning $earning)
    {
        $description = "Profit from unit " . $unit->id . " from machine " . $unit->machine->name . " for " . $earning->date->format('F Y');

        $amount = $unit->machine->latest_earning()->final_amount / 10; 

        $this->add_transaction("profit", $description, $amount, $earning->date);

        // Reset all users is_active flag
        App\User::where('is_active', true)
                ->update(['is_active' =>  false]);
    }

    public function add_transaction($type, $description, $amount, $date)
    {
        if( $this->transactions()->where('description', $description)->count() == 0 )
        {
            $this->transactions()->create([
                "type"  => $type,
                "date"  => $date,
                "description"   => $description,
                "amount"    => $amount
            ]);
        }
    }

    /* Scopes */
    public function scopeActive($query)
    {
        return $query->where('is_verified', true);
    }


}
