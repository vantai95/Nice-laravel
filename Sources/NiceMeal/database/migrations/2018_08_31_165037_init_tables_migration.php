<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitTablesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en');
            $table->string('name_ja')->nullable();
            $table->string('type_en');
            $table->string('type_ja')->nullable();
        });        
       
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();          
            $table->integer('province_id')->nullable();
            $table->string('name_en');
            $table->string('name_ja')->nullable();
            $table->string('type_en');
            $table->string('type_ja')->nullable();
            $table->string('location')->nullable();
            $table->string('slug');
        });        
       
        Schema::create('wards', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();          
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('name_en');
            $table->string('name_ja')->nullable();
            $table->string('type_en');
            $table->string('type_ja')->nullable();
            $table->string('location')->nullable();
        });
        
        Schema::create('cuisines', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();          
            $table->string('name_en');
            $table->string('name_ja')->nullable();
        });

        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name_en')->nullable();
            $table->string('name_ja')->nullable();
            $table->string('slug');
            $table->string('highlight_label_en')->nullable();
            $table->string('highlight_label_ja')->nullable();
            $table->string('title_brief_en')->nullable();
            $table->string('title_brief_ja')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ja')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_ja')->nullable();            
            $table->integer('province_id')->nullable();         
            $table->integer('district_id')->nullable();         
            $table->integer('ward_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('banner')->nullable();
            $table->string('image')->nullable();
            $table->string('review_rate')->nullable();
            $table->string('otp')->nullable();
            $table->integer('otp_value')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('status')->nullable();
            $table->integer('latitude')->nullable();
            $table->integer('longitude')->nullable();
            $table->boolean('online_payment')->default(false);
            $table->boolean('cod_payment')->default(true);
            $table->boolean('delivery')->default(true);
            $table->boolean('pickup')->default(true);
            
        });

        Schema::create('restaurant_work_times', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable();    
            $table->string('working_date_en')->nullable();    
            $table->string('working_date_ja')->nullable();   
            $table->time('opening_hours')->nullable();      
            $table->time('closing_hours')->nullable();  
        });     

        Schema::create('restaurant_delivery_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('restaurant_id')->nullable();        
            $table->integer('district_id')->nullable();      
            $table->time('delivery_time')->nullable();      
            $table->double('delivery_cost')->nullable();   
            $table->double('min_order_amount')->nullable(); 
        });

        Schema::create('restaurants_cuisines', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable();        
            $table->integer('cuisine_id')->nullable();     
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('restaurant_id')->nullable();    
            $table->string('title_en')->nullable();    
            $table->string('title_ja')->nullable();    
            $table->string('image')->nullable();  
            $table->boolean('active')->default(true); 
            $table->string('slug');    
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('file_name');
            $table->string('extension');
            $table->integer('restaurant_id')->nullable();
            $table->integer('user_id')->nullable();
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('restaurant_id')->nullable(); 
            $table->integer('category_id')->nullable();    
            $table->string('name_en')->nullable();    
            $table->string('name_ja')->nullable();      
            $table->text('description_en')->nullable();    
            $table->string('description_ja')->nullable();  
            $table->double('price')->nullable();  
            $table->boolean('active')->default(true);  
            $table->string('slug');   
        });

        Schema::create('customizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('restaurant_id')->nullable(); 
            $table->string('name_en')->nullable();    
            $table->string('name_ja')->nullable();      
            $table->text('description_en')->nullable();    
            $table->text('description_ja')->nullable();  
            $table->double('price')->nullable();  
            $table->boolean('active')->default(true);  
            $table->boolean('required')->default(true);  
            $table->boolean('has_options')->default(true);    
            $table->integer('selection_type')->default(0);  //0:single,1:multiple 
            $table->integer('max_quantity')->nullable(); 
            $table->integer('min_quantity')->nullable(); 

        });

        Schema::create('customization_options', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable(); 
            $table->integer('customization_id')->nullable(); 
            $table->string('name_en')->nullable();    
            $table->string('name_ja')->nullable();      
            $table->double('price')->nullable();  
            $table->boolean('active')->default(true);  
            $table->integer('max_quantity')->nullable(); 
            $table->integer('min_quantity')->nullable(); 

        });

        Schema::create('dishes_customizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable(); 
            $table->integer('customization_id')->nullable(); 
            $table->integer('dish_id')->nullable(); 
        });

        Schema::create('time_base_display_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable(); 
            $table->string('name')->nullable(); 
            $table->boolean('active')->default(true)->nullable();
            $table->boolean('sun')->default(true)->nullable();
            $table->boolean('mon')->default(true)->nullable();
            $table->boolean('tue')->default(true)->nullable();
            $table->boolean('wed')->default(true)->nullable();
            $table->boolean('thu')->default(true)->nullable();
            $table->boolean('fri')->default(true)->nullable();
            $table->boolean('sat')->default(true)->nullable();
            $table->integer('period_type')->default(0);  //0:Now-future, 1:specific date
            $table->date('from_date')->nullable(); 
            $table->date('to_date')->nullable(); 
            $table->integer('all_times')->default(0);  //0:Now-future, 1:specific date
            $table->time('from_time')->nullable(); 
            $table->time('to_time')->nullable(); 

        });

        Schema::create('time_base_display_affects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id'); 
            $table->integer('rule_id'); 
            $table->integer('category_id')->nullable(); 
            $table->integer('dish_id')->nullable();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->text('permissions')->nullable();
            $table->integer('restaurant_id')->nullable();
        });

        Schema::create('users_restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->integer('user_id')->nullable();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('order_number');
            $table->integer('restaurant_id');
            $table->integer('user_id')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('sub_total_amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('tax')->nullable();
            $table->double('shipping_fee')->nullable();
            $table->integer('status')->default(0);//(0:new, 1: received, 2 admin_accepted,3:Accepted, 4 reject)
            $table->string('payment_method')->nullable();
            $table->string('order_type')->nullable();
            $table->datetime('order_time')->nullable();
            $table->string('notes')->nullable();
            $table->string('reject_reason')->nullable();
            $table->integer('promotion_id')->nullable();
            $table->double('amount_user_have')->nullable();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id');
            $table->integer('order_id');
            $table->integer('dish_id');
            $table->double('price')->nullable();
            $table->integer('quantity');
            $table->boolean('have_customization')->default(false);  
        });

        Schema::create('order_items_customizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id');
            $table->integer('order_id');
            $table->integer('order_item_id');   
            $table->integer('customization_id')->nullable();         
            $table->integer('customization_option_id')->nullable();
            $table->double('price')->nullable();
            $table->integer('quantity')->nullable();
        });

        Schema::create('order_customer_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id');
            $table->integer('order_id');
            $table->integer('user_id')->nullable();      
            $table->string('full_name')->nullable();     
            $table->string('email')->nullable();     
            $table->string('phone')->nullable();  
            $table->boolean('recieve_new_deals')->default(false); 
        });

        Schema::create('order_delivery_info', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id');
            $table->integer('order_id');
            $table->integer('user_id')->nullable();       
            $table->string('residence')->nullable();        
            $table->string('full_address')->nullable();     
            $table->integer('province_id')->nullable();         
            $table->integer('district_id')->nullable();         
            $table->integer('ward_id')->nullable();
        });

        Schema::create('favourites', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id');
            $table->integer('user_id')->nullable();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('restaurant_id');
            $table->integer('user_id')->nullable();       
            $table->string('title')->nullable();  
            $table->text('content')->nullable();
            $table->integer('food_rate')->nullable();
            $table->integer('service_rate')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('wards');
        Schema::dropIfExists('cuisines');
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('restaurant_delivery_settings');
        Schema::dropIfExists('restaurant_work_times');
        Schema::dropIfExists('restaurants_cuisines');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('customizations');
        Schema::dropIfExists('customization_options');
        Schema::dropIfExists('dishes_customizations');
        Schema::dropIfExists('time_base_display_rules');
        Schema::dropIfExists('time_base_display_affects');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users_restaurants');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('order_items_customizations');
        Schema::dropIfExists('order_customer_infos');
        Schema::dropIfExists('order_delivery_info');
        Schema::dropIfExists('favourites');
        Schema::dropIfExists('comments');
    }
}
