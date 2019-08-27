<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePeriodTypePromotionAndWorkingtime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('restaurant_work_times', function (Blueprint $table) {
        $table->integer('period_type');
      });

      Schema::table('promotions_available_times', function (Blueprint $table) {
        $table->integer('period_type');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('restaurant_work_times', function (Blueprint $table) {
        $table->dropColumn(['period_type']);
      });

      Schema::table('promotions_available_times', function (Blueprint $table) {
        $table->dropColumn(['period_type']);
      });
    }
}
