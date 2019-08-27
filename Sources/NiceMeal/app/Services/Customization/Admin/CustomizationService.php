<?php
namespace App\Services\Customization\Admin;

use App\Models\Customization;
use App\Models\CustomizationOption;
use App\Services\Customization\Admin;
use DB;

class CustomizationService{

  public static function updateOption($requestData,$customization_id,$restaurant_id){
    $current_options = CustomizationOption::where('customization_id', '=', $customization_id)->get()->pluck('id');
    if (isset($requestData['option']) && $requestData['has_options'] == 1) {
        $request_otpions = collect($requestData['option']);
        Admin\OptionService::updateSequence($request_otpions);
        $new_options = $request_otpions->filter(function ($value, $key) {
            return $value['option_id'] == 0;
        });
        $old_options = $request_otpions->filter(function ($value, $key) {
            return $value['option_id'] > 0;
        });

        $deleted_option = $current_options->diff($old_options->pluck('option_id'));

        $option_updateable = $old_options->filter(function ($value, $key) use ($deleted_option) {
            return !in_array($value['option_id'], $deleted_option->toArray());
        });

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        if ($requestData['has_options']) {
            //if ($requestData['selection_type'] == Customization::SELECTION_TYPE['multiple_choice']) $requestData['quantity_changeable'] = 0;
            if (count($requestData['option']) == 0) $requestData['has_options'] = 0;
        }

        /**
        *1/ Must re-sequence all the option.
        *2/ Get the max sequence at this time
        *3/ Re-sequence all the option from max + 1
        */

        CustomizationOption::whereIn('id', $deleted_option)->delete();
        if (count($option_updateable) > 0) {
            Admin\OptionService::updateCustomizationOption($option_updateable);
        }

        if ($requestData['has_options'] && count($new_options) > 0) {
            Admin\OptionService::insertCustomizationOption($new_options, $customization_id, $restaurant_id);

        }
    } else {
        CustomizationOption::where('customization_id', $id)->delete();
    }

  }

  public static function createCustomization($requestData,$restaurant_id){
    $requestData = self::formatInputData($requestData,$restaurant_id);
    $id = Customization::create($requestData)->id;
    if (count($requestData['option']) > 0) {
        Admin\OptionService::updateSequence($requestData['option']);
        Admin\OptionService::insertCustomizationOption($requestData['option'], $id, $restaurant_id);
    } else {
        $requestData['has_options'] = 0;
    }
  }

  public static function formatInputData($requestData,$restaurant_id = 0){
    $requestData['has_options'] = 1;
    $requestData['name_ja'] = !empty($requestData['name_ja']) ? $requestData['name_ja'] : $requestData['name_en'];
    $requestData['description_ja'] = !empty($requestData['description_ja']) ? $requestData['description_ja'] : $requestData['description_en'];
    $requestData['description_en'] = strip_tags($requestData['description_en']);
    $requestData['description_ja'] = strip_tags($requestData['description_ja']);
    isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
    if($restaurant_id != 0){
      $requestData['restaurant_id'] = $restaurant_id;
    }
    $requestData['min_quantity'] = $requestData['max_quantity'];
    return $requestData;
  }

  public static function updateCustomization($requestData,$customization){
    $requestData = self::formatInputData($requestData);
    Admin\CustomizationService::updateOption($requestData,$customization->id,$customization->restaurant_id);
    $customization->update($requestData);
  }
}
