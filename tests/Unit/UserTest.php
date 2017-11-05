<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /** @test */
    public function user_have_their_own_unique_referall_link()
    {
    	$user = create('App\User');

    	$this->assertEquals( url('register?r=' . $user->user_id), $user->referral_link );
    } 
}
