<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserReferralTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_user_has_referee()
    {
        $user = create('App\User');

        $referee = create('App\User', ['referrer_id' => $user->id], 10);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->referees);

        $this->assertEquals($user->referees_count, 10);
    } 
}
