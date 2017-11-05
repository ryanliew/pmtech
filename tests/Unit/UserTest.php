<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    public function user_have_their_own_unique_referall_link()
    {
    	$user = create('App\User');

    	$this->assertEquals( url('register?r=' . $user->username), $user->referral_link );
    } 
}
