<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UpdateTimeBaseDisplayRulesTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('time_base_display_rules', function (Blueprint $table) {
            $table->boolean('all_days')->default(0);// 0: all day, 1: sepecific day
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_base_display_rules', function ($table) {
            $table->dropColumn(['all_days']);
        });
    }
}
