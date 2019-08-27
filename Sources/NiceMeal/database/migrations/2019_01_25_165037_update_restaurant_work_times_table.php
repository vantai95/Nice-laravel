<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UpdateRestaurantWorkTimesTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('restaurant_work_times', function (Blueprint $table) {
            $table->dropColumn(['working_date_en']);
            $table->dropColumn(['working_date_ja']);
            $table->dropColumn(['opening_hours']);
            $table->dropColumn(['closing_hours']);

            $table->boolean('all_days')->default(0);// 0: all day, 1: sepecific day
            $table->boolean('sun')->default(true)->nullable();
            $table->boolean('mon')->default(true)->nullable();
            $table->boolean('tue')->default(true)->nullable();
            $table->boolean('wed')->default(true)->nullable();
            $table->boolean('thu')->default(true)->nullable();
            $table->boolean('fri')->default(true)->nullable();
            $table->boolean('sat')->default(true)->nullable();
            $table->boolean('all_times')->default(0);  //0:Now-future, 1:specific date
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_work_times', function ($table) {
            $table->string('working_date_en')->nullable();
            $table->string('working_date_ja')->nullable();
            $table->time('opening_hours')->nullable();
            $table->time('closing_hours')->nullable();

            $table->dropColumn(['all_days']);
            $table->dropColumn(['sun']);
            $table->dropColumn(['mon']);
            $table->dropColumn(['tue']);
            $table->dropColumn(['wed']);
            $table->dropColumn(['thu']);
            $table->dropColumn(['fri']);
            $table->dropColumn(['sat']);
            $table->dropColumn(['all_times']);
            $table->dropColumn(['from_time']);
            $table->dropColumn(['to_time']);
        });
    }
}
