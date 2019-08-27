<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimeSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('time_settings', function (Blueprint $table) {
            $table->integer('restaurant_id')->default(0);
            $table->integer('all_days')->default(0)->change();
            $table->integer('sun')->default(0)->change();
            $table->integer('mon')->default(0)->change();
            $table->integer('tue')->default(0)->change();
            $table->integer('wed')->default(0)->change();
            $table->integer('thu')->default(0)->change();
            $table->integer('fri')->default(0)->change();
            $table->integer('sat')->default(0)->change();
            $table->integer('all_times')->default(0)->change();
            $table->integer('period_type')->default(0)->change();
            $table->date('from_date')->nullable()->change();
            $table->date('to_date')->nullable()->change();
            $table->dropColumn(['has_special_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('time_settings', function ($table) {
          $table->dropColumn(['restaurant_id']);
          $table->integer('has_special_date')->default(0);
      });
    }
}
