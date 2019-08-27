<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->integer('otp')->nullable()->change();
            $table->float('otp_value')->nullable()->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('otp')->nullable();
            $table->boolean('otp_verified')->nullable();
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
            $table->string('otp')->nullable()->change();
            $table->integer('otp_value')->nullable()->change();
        });
        Schema::table('orders', function ($table) {
            $table->dropColumn(['otp']);
            $table->dropColumn(['otp_verified']);
        });
    }
}
