<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionsTableAddUnitAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidunit_amount
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('unit_sold')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('unit_sold');
        });
    }
}
