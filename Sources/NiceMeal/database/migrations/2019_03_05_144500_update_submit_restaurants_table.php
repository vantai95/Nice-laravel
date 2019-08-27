<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubmitRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::table('restaurants', function (Blueprint $table) {            
            $table->boolean('published')->default(false)->nullable();          
            $table->string('contract')->nullable();          
            $table->string('identity_card')->nullable();          
            $table->string('business_license')->nullable();
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function ($table) {
            $table->dropColumn(['published']);
            $table->dropColumn(['contract']);
            $table->dropColumn(['identity_card']);
            $table->dropColumn(['business_license']);
        });
      
    }
}
