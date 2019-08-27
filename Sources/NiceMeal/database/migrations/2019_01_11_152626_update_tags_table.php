<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {          
            $table->string('type')->default(0)->nullable()->comment('0:cuisine,1:category');         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        $table->dropColumn(['type']);
        Schema::table('tags', function ($table) {
            $table->dropColumn(['type']);
        });
    }
}
