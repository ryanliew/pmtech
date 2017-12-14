<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->float('fee_rental_per_month', 8, 4)->default(100);
            $table->float('fee_internet_per_month', 8, 4)->default(150);
            $table->float('fee_electric_per_month', 8, 4)->default(150);
            $table->unsignedInteger('fee_admin_percentage_per_month')->default(4);
            $table->float('fee_overhead_1', 8, 4)->default(0);
            $table->float('fee_overhead_2', 8, 4)->default(0);
            $table->float('fee_overhead_3', 8, 4)->default(0);
            $table->unsignedInteger('pagination_per_page')->default(20);
            $table->float('incentive_commission_per_referee', 8, 4)->default(300);
            $table->float('incentive_bonus_per_referee_pack', 8, 4)->default(250);
            $table->unsignedInteger('incentive_direct_downline_commission_percentage')->default(10);
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ["id" => 1]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
