<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDateToWorkingtimeAndPromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_work_times', function (Blueprint $table) {
          $table->date('from_date')->nullable();
          $table->date('to_date')->nullable();
        });

        Schema::table('promotions_available_times', function (Blueprint $table) {
          $table->date('from_date')->nullable();
          $table->date('to_date')->nullable();
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
        $table->dropColumn(['from_date']);
        $table->dropColumn(['to_date']);
      });

      Schema::table('promotions_available_times', function (Blueprint $table) {
        $table->dropColumn(['from_date']);
        $table->dropColumn(['to_date']);
      });
    }
}
