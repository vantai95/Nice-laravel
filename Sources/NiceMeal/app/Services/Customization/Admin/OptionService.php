<?php
namespace App\Services\Customization\Admin;

use App\Models\Customization;
use App\Models\CustomizationOption;

class OptionService{

  public static function getOption($customization_id){
    $customization = Customization::find($customization_id);
    $option = $customization->options()->orderBy('sequence','desc')->get();
    return $option;
  }

  public static function updateSequence(&$listOption){
    if(is_array($listOption)){
      $listOption = collect($listOption);
    }
    $currentMaxSequence = CustomizationOption::max('sequence')+1;
    $listOption = $listOption->map(function($item,$key) use (&$currentMaxSequence){
      $item['sequence'] = $currentMaxSequence;
      $currentMaxSequence++;
      return $item;
    });
  }

  public static function insertCustomizationOption($data, $customization_id, $restaurant_id)
  {
      $option = [];
      foreach ($data as $item) {
          $option_row = [
              'name_en' => $item['name_en'],
              'name_ja' => isset($item['name_ja']) ? $item['name_ja'] : $item['name_en'],
              'price' => str_replace('.', '', $item['price']),
              'max_quantity' => $item['max_quantity'],
              'min_quantity' => (intval($item['min_quantity']) <= 0) ? 1 : $item['min_quantity'],
              'customization_id' => $customization_id,
              'restaurant_id' => $restaurant_id,
              'sequence' => $item['sequence']
          ];
          array_push($option, $option_row);
      }
      CustomizationOption::insert($option);
  }

  public static function updateCustomizationOption($data)
  {
      $update = "";
      foreach ($data as $option) {
          $option_id = $option['option_id'];
          $option['name_ja'] = isset($option['name_ja']) ? $option['name_ja'] : $option['name_en'];
          $option['price'] = str_replace('.',"",$option['price']);
          $option = collect($option)->except('option_id');
          CustomizationOption::where('id', $option_id)->update($option->toArray());
      }
  }
}
