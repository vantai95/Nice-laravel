<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeBasePricingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_base_pricing_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable(); 
            $table->string('name')->nullable(); 
            $table->boolean('active')->default(true)->nullable();
            $table->integer('period_type')->default(0);  //0:Now-future, 1:specific date
            $table->date('from_date')->nullable(); 
            $table->date('to_date')->nullable(); 
            $table->boolean('all_days')->default(0);// 0: all day, 1: sepecific day
            $table->boolean('sun')->default(true)->nullable();
            $table->boolean('mon')->default(true)->nullable();
            $table->boolean('tue')->default(true)->nullable();
            $table->boolean('wed')->default(true)->nullable();
            $table->boolean('thu')->default(true)->nullable();
            $table->boolean('fri')->default(true)->nullable();
            $table->boolean('sat')->default(true)->nullable();            
            $table->integer('all_times')->default(0);  //0:Now-future, 1:specific date
            $table->time('from_time')->nullable(); 
            $table->time('to_time')->nullable(); 
            $table->integer('type')->default(0);//0: %, 1: value
            $table->double('value')->nullable();

        });
        Schema::create('time_base_pricing_affects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id'); 
            $table->integer('rule_id'); 
            $table->integer('dish_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_base_pricing_rules');
        Schema::dropIfExists('time_base_pricing_affects');
    }
}
