<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentManagementTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admins_can_approve_payments()
    {
    	$this->signIn();

    	$payment = create('App\Payment');

    	$this->post(route('payment', $payment->id), [
    		"amount"	=> 1500.00	
    	]);

    	$this->assertDatabaseHas('payments', [
    		"id"			=> $payment->id,
    		"amount"		=> 1500.00,
    		"is_verified" 	=> 1
    	]);
    }

    /** @test */
    public function users_can_add_payments_with_default_values()
    {
     	$this->signIn();

     	Storage::fake('public');

     	$this->post(route('payments'), [
     		"payment_slip" => $file = UploadedFile::fake()->image('something.jpg')
     	]);

     	$this->assertDatabaseHas('payments', [
     		"amount"		=> null,
     		"is_verified" 	=> 0
     	]);

		$this->post(route('payments'), [
     		"payment_slip" => $file = UploadedFile::fake()->image('something.jpg')
     	]);

     	$this->assertCount(2, auth()->user()->payments);
    }  

    /** @test */
    public function admin_can_add_payments_for_user()
    {
    	$this->signIn();

    	$user = create('App\User');

    	Storage::fake('public');

    	$this->post(route('payments'), [
     		"payment_slip" 	=> $file = UploadedFile::fake()->image('something.jpg'),
     		"user_id"		=> $user->id
     	]);

     	$this->assertDatabaseHas('payments', [
     		"amount"	=> null,
     		"is_verified"	=> 0,
     		"user_id"		=> $user->id
     	]);
    } 
}