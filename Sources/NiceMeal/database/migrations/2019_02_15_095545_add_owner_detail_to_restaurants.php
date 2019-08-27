<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerDetailToRestaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('owner_name', 50)->nullable();
            $table->string('owner_phone',20)->unique()->nullable();
            $table->string('owner_email', 50)->unique()->nullable();
            $table->string('link')->nullable();
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
            $table->dropColumn(['owner_name']);
            $table->dropColumn(['owner_phone']);
            $table->dropColumn(['owner_email']);
            $table->dropColumn(['link']);
        });
    }
}
