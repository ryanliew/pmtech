<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('referrer_id')->nullable();
            $table->string('phone')->unique();
            $table->string('ic')->unique();
            $table->string('alt_contact_phone')->nullable();
            $table->string('alt_contact_name')->nullable();
            $table->string('ic_image_path')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_default_password')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();
            $table->unsignedInteger('area_id')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bitcoin_address')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
