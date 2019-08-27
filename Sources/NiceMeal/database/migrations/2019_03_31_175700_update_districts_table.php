<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UpdateDistrictsTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
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
        Schema::table('districts', function ($table) {
            $table->dropColumn(['sequence']);
        });
    }
}
