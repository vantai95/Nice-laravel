<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UpdatePromotions2Table extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->boolean('include_request')->default(0);// 0: no, 1: yes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function ($table) {
            $table->dropColumn(['include_request']);
        });
    }
}
