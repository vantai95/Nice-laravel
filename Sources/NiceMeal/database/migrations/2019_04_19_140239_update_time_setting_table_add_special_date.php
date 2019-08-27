<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimeSettingTableAddSpecialDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('time_settings', function (Blueprint $table) {
          $table->date('special_date')->nullable();
          $table->integer('has_special_date')->default(0);
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
            $table->dropColumn(['has_special_date']);
            $table->dropColumn(['special_date']);
        });
    }
}
