<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MachinesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admins_can_create_machines()
    {
    	$this->signIn();

    	$machine = make('App\Machine');

    	$response = $this->post(route('machines'), $machine->toArray());

    	$this->get($response->headers->get('Location'))
    		->assertSee($machine->name);
    } 
}