<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTablesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable();
            $table->string('name');
            $table->boolean('active')->default(true);
        });        
       
        Schema::create('group_customizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();          
            $table->integer('restaurant_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('customization_id')->nullable();
            $table->boolean('active')->default(true);
        });

        Schema::table('dishes', function (Blueprint $table) {
            $table->integer('group_id')->nullable();
        });

        Schema::table('time_base_display_affects', function (Blueprint $table) {
            $table->integer('group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_customizations');
        Schema::table('dishes', function ($table) {
            $table->dropColumn(['group_id']);
        });
        Schema::table('time_base_display_affects', function ($table) {
            $table->dropColumn(['group_id']);
        });
    }
}
