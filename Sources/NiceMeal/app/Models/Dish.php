<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use DB, Log;
use App\Models\TimeBaseDisplayRule;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class Dish extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dishes';

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
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
    protected $fillable = ['restaurant_id', 'category_id', 'name_en', 'name_ja', 'description_en', 'description_ja' ,
        'price', 'active','slug', 'group_id', 'image'];

    public function status()
    {
        if($this->active) {
            return __('admin.restaurants.statuses.active');
        }
        return __('admin.restaurants.statuses.inactive');
    }

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }

    public function customizationList(){
        $data = DB::table('dishes_customizations')
        ->join('customizations','customizations.id','=','dishes_customizations.customization_id')
        ->select('customizations.*')
        ->where('customizations.restaurant_id','=',$this->restaurant_id)
        ->where('dish_id','=',$this->id)->get();
        if($data){
            return $data;
        }
        return '';
    }

    public function timeBaseRuleList(){
        $data = DB::table('time_base_display_affects')
        ->join('time_base_display_rules','time_base_display_rules.id','=','time_base_display_affects.rule_id')
        ->select('time_base_display_rules.*')
        ->where('time_base_display_affects.restaurant_id','=',$this->restaurant_id)
        ->where('dish_id','=',$this->id)->get();
        if($data){
            return $data;
        }
        return '';
    }

    public function timeBasePricingRuleList(){
        $data = DB::table('time_base_pricing_affects')
            ->join('time_base_pricing_rules','time_base_pricing_rules.id','=','time_base_pricing_affects.rule_id')
            ->select('time_base_pricing_rules.*')
            ->where('time_base_pricing_affects.restaurant_id','=',$this->restaurant_id)
            ->where('dish_id','=',$this->id)->get();
        if($data){
            return $data;
        }
        return '';
    }

    public function timeBaseDisplay($ruleId) {
        $now = Carbon::now();

        $rule = TimeBaseDisplayRule::find($ruleId);

        if ($rule->active == 0) return false;

        $isDateAvail = $rule->period_type == 0 || ($rule->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $rule->to_date);
        $isDayNameAvail = $rule->all_days == 1 || $rule[Controller::WEEKNAME[$now->dayOfWeek]] == 1;
        $isTimeAvail = $rule->all_times == 1 || (substr($rule->from_time, 0, 5) <= $now->format('H:i') && $now->format('H:i') <= substr($rule->to_time, 0, 5));

        return $isDateAvail && $isDayNameAvail && $isTimeAvail;
    }

    public function getTBD() {
        $rules = $this->timeBaseDisplayRule()->get();
        if (count($rules) == 0) return false;
        $tbd = false;
        foreach ($rules as $rule) {
            $tbd = $tbd || $this->timeBaseDisplay($rule->id);
        }
        return $tbd;
    }

    public function timeBasePricing(){
        $now = Carbon::now();


        $dishRules = DB::table('time_base_pricing_affects as tbp_affs')
            ->whereRaw("tbp_affs.dish_id = $this->id")
            ->join('time_base_pricing_rules as tbp_rules', 'tbp_rules.id', '=', 'tbp_affs.rule_id')
            ->whereRaw('tbp_rules.active = 1')
            ->whereRaw('period_type = 0')
            ->orderBy('tbp_affs.id', 'desc')
            ->select('tbp_rules.*', 'tbp_affs.id as tbp_aff_id')->get();
        foreach($dishRules as $key=>$rule) {
            $isDateAvail = $rule->period_type == 0 || ($rule->from_date <= $now->format('Y-m-d') && $now->format('Y-m-d') <= $rule->to_date);
            $isDayNameAvail = $rule->all_days == 1 || $rule->{Controller::WEEKNAME[$now->dayOfWeek]} == 1;
            $isTimeAvail = $rule->all_times == 1 || (substr($rule->from_time, 0, 5) <= $now->format('H:i') && $now->format('H:i') <= substr($rule->to_time, 0, 5));

            if (($isDateAvail && $isDayNameAvail && $isTimeAvail) == false)
                unset($dishRules[$key]);
        }
        if(count($dishRules) == 0) return $this->price;
        else if(count($dishRules) == 1) {
            $rule = $dishRules[0];
            return $dishRules[0]->value;
            // $direction = $rule->inscrease == 1 ? 1 : -1;
            // return $rule->type == 1 ? $dish->price + $direction*$rule->value : $dish->price*$direction*(1+$rule->value/100);
        }
        else if(count($dishRules) > 1){
            return $dishRules->min('value');
        }
    }

    public function status_class()
    {
        if($this->active){
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function timeBaseDisplayRule(){
        return $this->belongsToMany('App\Models\TimeBaseDisplayRule','time_base_display_affects','dish_id','rule_id');
    }

    public function timeBaseDisplayAffect(){
      return $this->hasMany('App\Models\TimeBaseDisplayAffect','dish_id');
    }

    public function timeBasePricingRule(){
        return $this->belongsToMany('App\Models\TimeBasePricingRule','time_base_pricing_affects','dish_id','rule_id');
    }

    public function customization(){
        return $this->belongsToMany('App\Models\Customization','dishes_customizations','dish_id','customization_id');
    }

    public function category(){
        return $this->belongsToMany('App\Models\Category','dishes_categories','dish_id','category_id');
    }

    public function dishCategory() {
        return $this->hasMany('App\Models\DishCategory', 'dish_id');
    }

    public function categoriesList(){
        $data = DB::table('dishes_categories')
            ->where('dishes_categories.restaurant_id','=',$this->restaurant_id)
            ->where('dishes_categories.dish_id','=',$this->id)->pluck('category_id')->toJson();;
        if($data){
            return $data;
        }
        return '';
    }

}
