<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        DB::table('states')->insert([
            ['name' => 'Johor', 'id' => 1, 'code' => 'JHR'],
            ['name' => 'Kedah', 'id' => 2, 'code' => 'KDH'],
            ['name' => 'Kelantan', 'id' => 3, 'code' => 'KLTN'],
            ['name' => 'Kuala Lumpur', 'id' => 4, 'code' => 'KL'],
            ['name' => 'Labuan', 'id' => 5, 'code' => 'LBN'],
            ['name' => 'Melaka', 'id' => 6, 'code' => 'MLK'],
            ['name' => 'Negeri Sembilan', 'id' => 7, 'code' => 'NSB'],
            ['name' => 'Pahang', 'id' => 8, 'code' => 'PHG'],
            ['name' => 'Penang', 'id' => 9, 'code' => 'PNG'],
            ['name' => 'Perak', 'id' => 10, 'code' => 'PRK'],
            ['name' => 'Perlis', 'id' => 11, 'code' => 'PRL'],
            ['name' => 'Sabah', 'id' => 13, 'code' => 'SBH'],
            ['name' => 'Sarawak', 'id' => 14, 'code' => 'SRK'],
            ['name' => 'Selangor', 'id' => 15, 'code' => 'SLGR'],
            ['name' => 'Terengganu', 'id' => 16, 'code' => 'TRG'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
