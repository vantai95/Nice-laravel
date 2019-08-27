<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntroToRestaurantsTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->text('intro')->nullable();
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
            $table->dropColumn(['intro']);
        });

    }
}
