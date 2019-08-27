<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en');
            $table->string('name_ja')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ja')->nullable();
            $table->string('image')->nullable();
            $table->string('promotion_code',10)->nullable()->comment('Apply for Voucher');
            $table->integer('restaurant_id')->nullable();
            $table->boolean('is_global')->default(false)->comment('true: apply for all restaurant, false: apply for specific restaurant');            
            
            $table->integer('type')->default(0)->comment('0:%, 1:value, 2:free item');            
            $table->double('value')->nullable();
            $table->string('free_item')->default('[]')->nullable();
            $table->integer('created_by');
            $table->double('maximun_discount')->nullable();
            $table->integer('number_usage')->nullable()->comment('Apply for Voucher');   

            $table->integer('apply_to')->default(0)->comment('0: Áp dụng toàn menu vs những item có giá từ x đến y, 1: Áp dụng toàn category vs những item có giá từ x đến y, 2: Áp dụng cho những item dc chọn cụ thể, 3.Áp dụng cho toàn bộ đơn hàng với tổng subtotal có giá trị từ x đến y');                     
            
            $table->double('min_order_value')->default(0)->nullable()->comment('Ap dung co apply_to:3');
            $table->double('max_order_value')->default(0)->nullable()->comment('Ap dung co apply_to:3');

            $table->double('item_value_from')->nullable()->comment('Ap dung co apply_to:0,1');
            $table->double('item_value_to')->nullable()->comment('Ap dung co apply_to:0,1');
            
            $table->boolean('status')->default(true)->comment('0:inactive, 1:active');

        });

        Schema::create('promotions_available_times', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('promotion_id');    
            $table->boolean('all_days')->default(0);// 0: all day, 1: sepecific day
            $table->boolean('sun')->default(true)->nullable();
            $table->boolean('mon')->default(true)->nullable();
            $table->boolean('tue')->default(true)->nullable();
            $table->boolean('wed')->default(true)->nullable();
            $table->boolean('thu')->default(true)->nullable();
            $table->boolean('fri')->default(true)->nullable();
            $table->boolean('sat')->default(true)->nullable();
            $table->boolean('all_times')->default(0);  //0:Now-future, 1:specific date
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable(); 
        });  

        Schema::create('promotion_affects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('promotion_id');
            $table->integer('restaurant_id');
            $table->integer('dish_id')->nullable();
            $table->integer('category_id');
        });
        
        Schema::create('promotion_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('order_id');
            $table->integer('restaurant_id');
            $table->integer('promotion_id');
            $table->double('promotion_value')->nullable();
            $table->integer('free_item_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('promotions_available_times');
        Schema::dropIfExists('promotion_affects');
        Schema::dropIfExists('promotion_usages');
    }
}
