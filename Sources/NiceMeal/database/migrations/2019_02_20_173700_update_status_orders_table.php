<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatusOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('kitchen_accepted')->default(false)->nullable();
            $table->time('confirm_delivery_time')->nullable();
            $table->time('cooking_time')->nullable();
            $table->time('final_delivery_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn(['kitchen_accepted']);
            $table->dropColumn(['confirm_delivery_time']);
            $table->dropColumn(['cooking_time']);
            $table->dropColumn(['final_delivery_time']);
        });
    }
}
