<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object_type');
            $table->integer('object_id');
            $table->integer('all_days');
            $table->integer('sun');
            $table->integer('mon');
            $table->integer('tue');
            $table->integer('wed');
            $table->integer('thu');
            $table->integer('fri');
            $table->integer('sat');
            $table->integer('all_times');
            $table->integer('period_type');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('has_special_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_settings');
    }
}
