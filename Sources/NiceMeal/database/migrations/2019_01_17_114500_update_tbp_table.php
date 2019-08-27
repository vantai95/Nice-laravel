<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTbpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_base_pricing_rules', function (Blueprint $table) {          
            $table->string('inscrease')->default(0)->nullable()->comment('0:decrease,1:inscrease');         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        $table->dropColumn(['inscrease']);
        Schema::table('time_base_pricing_rules', function ($table) {
            $table->dropColumn(['inscrease']);
        });
    }
}
