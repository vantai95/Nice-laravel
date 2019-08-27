<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserCustomerInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_customer_infos', function (Blueprint $table) {
            $table->integer('gender')->nullable();
            $table->date('birth_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_customer_infos', function (Blueprint $table) {
            $table->dropColumn(['gender']);
            $table->dropColumn(['birth_day']);
        });
    }
}
