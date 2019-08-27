<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UpdatePromotionsTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('promotion_affects', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('promotions_available_times', function (Blueprint $table) {
            $table->softDeletes();
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
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('promotion_affects', function ($table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('promotions_available_times', function ($table) {
            $table->dropColumn(['deleted_at']);
        });
    }
}
