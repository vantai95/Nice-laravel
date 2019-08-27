<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UpdateRestaurantDeliverySettingsTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('restaurant_delivery_settings', function (Blueprint $table) {
            $table->double('from')->nullable();
            $table->double('to')->nullable();
            $table->dropColumn(['delivery_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_delivery_settings', function ($table) {
            $table->dropColumn(['from']);
            $table->dropColumn(['to']);
            $table->time('delivery_time')->nullable();
        });
    }
}
