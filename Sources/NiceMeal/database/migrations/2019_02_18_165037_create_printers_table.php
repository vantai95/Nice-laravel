<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class CreatePrintersTable extends Migration
{/**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('token')->nullable();
            $table->boolean('auto_print')->default(1);
            $table->string('page_header')->nullable();
            $table->string('page_footer')->nullable();
            $table->string('reject_reason')->nullable();
            $table->boolean('printer_status')->default(0);
            $table->integer('check_interval')->nullable();
            $table->string('ip')->nullable();
            $table->integer('port')->nullable();
            $table->text('polling_url')->nullable();
            $table->text('callback_url')->nullable();
            $table->dateTime('last_time_success')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printers');
    }
}
