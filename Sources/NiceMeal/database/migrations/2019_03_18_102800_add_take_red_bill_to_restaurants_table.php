<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTakeRedBillToRestaurantsTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->boolean('take_red_bill')->defaut("false")->nullable()->comment("false: restaurant not support, true: support");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function ($table) {
            $table->dropColumn(['take_red_bill']);
        });

    }
}
