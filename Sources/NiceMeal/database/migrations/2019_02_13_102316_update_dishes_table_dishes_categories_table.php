<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDishesTableDishesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dishes', function ($table) {
            $table->dropColumn(['sequence']);
        });
        Schema::table('dishes_categories', function (Blueprint $table) {
            $table->integer('sequence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->integer('sequence')->nullable();
        });
        Schema::table('dishes_categories', function ($table) {
            $table->dropColumn(['sequence']);
        });
    }
}
