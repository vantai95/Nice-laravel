<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs_type', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en')->nullable();    
            $table->string('name_vn')->nullable();
            $table->boolean('active')->default(true);
            $table->string('faqs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs_type');
    }
}
