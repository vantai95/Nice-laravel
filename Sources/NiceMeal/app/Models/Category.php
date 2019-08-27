<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;
use DB;
use Carbon\Carbon;
use App\Models\TimeBaseDisplayAffect;
use App\Models\TimeBaseDisplayRule;
use App\Http\Controllers\Controller;

class Category extends Model
{
    use Sluggable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

    const CATEGORIES_FILTER = [
        'breakfast_lunch_dinner' => 'Breakfast / Lunch / Dinner',
        'pizza_pasta' => 'Pizza & Pasta',
        'burger_sandwich' => 'Burger & Sandwich',
        'snack_fast_food' => 'Snack & Fast food',
        'vegetarian_salad' => 'Vegetarian & Salad',
        'sushi_sashimi' => 'Sushi & Shashimi',
        'rice_noodle' => 'Rice & Noodle',
        'steak_rib' => 'Steak & Rib',
        'wine_beer' => 'Wine & Beer',
        'cake_dessert' => 'Cake & Dessert',
        'juice_smoothy' => 'Juice & Smoothy',
        'coffee_milk_tea' => 'Coffee & Milk tea'
    ];

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['restaurant_id', 'title_en', 'title_ja', 'image', 'active', 'slug','sequence'];

    public function status()
    {
        if ($this->active) {
            return __('admin.restaurants.statuses.active');
        }
        return __('admin.restaurants.statuses.inactive');
    }

    public function status_class()
    {
        if ($this->active) {
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title_en'
            ]
        ];
    }

    public function timeBaseRuleList(){
        $data = DB::table('time_base_display_affects')
        ->join('time_base_display_rules','time_base_display_rules.id','=','time_base_display_affects.rule_id')
        ->select('time_base_display_rules.*')
        ->where('time_base_display_affects.restaurant_id','=',$this->restaurant_id)
        ->where('category_id','=',$this->id)->whereNull('dish_id')->get();
        if($data){
            return $data;
        }            
        return '';
    }

    public function timeBaseDisplay() {
        $now = Carbon::now();
        $isDateAvail = true;
        $isDayNameAvail = true;
        $isTimeAvail = true;

        $ruleIds = TimeBaseDisplayAffect::where('category_id', $this->id)->whereNull('dish_id')->pluck('rule_id')->toArray();

        if (TimeBaseDisplayRule::whereIn('id', $ruleIds)->where('active', 1)->get()->count() == 0) return false;

        foreach ($ruleIds as $ruleId) {
            $rule = TimeBaseDisplayRule::where('id', $ruleId)->where('active', 1)->first();
            if (!$rule) continue;    

            $isDateAvail = $isDateAvail && ($rule->period_type == 0 || ($rule->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $rule->to_date));
            $isDayNameAvail = $isDayNameAvail && ($rule->all_days == 1 || $rule[Controller::WEEKNAME[$now->dayOfWeek]] == 1);
            $isTimeAvail = $isTimeAvail && ($rule->all_times == 1 || (substr($rule->from_time, 0, 5) <= $now->format('H:i') && $now->format('H:i') <= substr($rule->to_time, 0, 5)));
        }
        
        return $isDateAvail && $isDayNameAvail && $isTimeAvail;
    }

    public function customizationList(){
        $data = DB::table('categories_customizations')
            ->join('customizations','customizations.id','=','categories_customizations.customization_id')
            ->select('customizations.*')
            ->where('customizations.restaurant_id','=',$this->restaurant_id)
            ->where('categories_customizations.category_id','=',$this->id)->get();
        if($data){
            return $data;
        }
        return '';
    }

    public function imageUrl()
    {
        if (!empty($this->file_name) && File::exists(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $this->file_name)) {
            return url(config('constants.UPLOAD.IMAGES') . '/' . $this->file_name);
        }
        return url(config('constants.CATEGORY.IMAGE'));
    }

    
    public function dishesList(){
        $data = DB::table('dishes_categories')         
            ->where('dishes_categories.restaurant_id','=',$this->restaurant_id)
            ->where('dishes_categories.category_id','=',$this->id)->pluck('dish_id')->toJson();;
        if($data){
            return $data;
        }
        return '';
    }

    public function timeBaseDisplayRule(){
        return $this->belongsToMany('App\Models\TimeBaseDisplayRule','time_base_display_affects','category_id','rule_id');
    }

    public function customization(){
        return $this->belongsToMany('App\Models\Customization','categories_customizations','category_id','customization_id');
    }

    public function dishes(){
        return $this->belongsToMany('App\Models\Dish','dishes_categories','category_id','dish_id');
    }

    public function categoryCustomization() {
        return $this->hasMany('App\Models\CategoryCustomization', 'category_id', 'id');
    }
}
