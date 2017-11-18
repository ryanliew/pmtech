<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    /** @test */
    public function user_can_upload_their_payment_slip_during_registration()
    {
        $this->withExceptionHandling();

    	$user = make('App\User');

    	Storage::fake('public');

    	$this->post(route('register'), [
    		'name'              =>  $user->name,
            'email'             =>  $user->email,
            'phone'             =>  $user->phone,
            'ic'                =>  $user->ic,
            'username'          =>  $user->username,
            'alt_contact_name'  =>  $user->alt_contact_name,
            'alt_contact_phone' =>  $user->alt_contact_phone,
            'payment_slip'		=> 	$file = UploadedFile::fake()->image('something.jpg'),
            'terms'				=> 	true,
            'area_id'           =>  $user->area_id,
            'type'              =>  'investor',
            'referrer_user'		=> 	'123456'	
    	]);

        $payment = User::first()->payments()->first();

    	//dd(session()->all());
        $this->assertDatabaseHas('payments', [
            'payment_slip_path' => 'payments/' . $file->hashName(),
            'amount' => NULL,
            'is_verified' => 0
        ]);

    	//$this->assertEquals(asset('/storage/payments/' . $file->hashName()), auth()->user()->payment_slip_path);

    	Storage::disk('public')->assertExists('payments/' . $file->hashName());
    } 

    /** @test */
    public function user_can_upload_their_ic_copy_during_registration()
    {
    	$user = make('App\User');

    	Storage::fake('public');

    	$this->post(route('register'), [
    		'name'              =>  $user->name,
            'email'             =>  $user->email,
            'phone'             =>  $user->phone,
            'ic'                =>  $user->ic,
            'username'          =>  $user->username,
            'alt_contact_name'  =>  $user->alt_contact_name,
            'alt_contact_phone' =>  $user->alt_contact_phone,
            'ic_copy'			=> 	$file = UploadedFile::fake()->image('something.jpg'),
            'terms'				=> 	true,
            'area_id'           =>  $user->area_id,
            'type'              =>  'agent',
            'referrer_user'		=> 	'123456'	
    	]);

    	//dd(session()->all());

    	$this->assertEquals(asset('/storage/identifications/' . $file->hashName()), auth()->user()->ic_image_path);

    	Storage::disk('public')->assertExists('identifications/' . $file->hashName());	
    } 
}
