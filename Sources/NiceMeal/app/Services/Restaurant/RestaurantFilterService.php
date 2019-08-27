<?php

namespace App\Services\Restaurant;
use App\Models\Tag;

class RestaurantFilterService
{
  public static function filterByCuisine($condition, $restaurants, $lang = "en"){
    if (isset($condition['cuisines'])) {
        $tagNames = Tag::whereIn('id', $condition['cuisines'])->select("name_$lang as name")->pluck('name')->toArray();
        if (in_array('all', $condition['cuisines'])) {
            // query without condition
        } else if (in_array('other', $condition['cuisines'])) {
            $restaurants = $restaurants->where("title_brief", null);
        } else {
          $restaurants = $restaurants->filter(function($value,$key) use ($tagNames){
            $resTagNames = explode(', ', $value->title_brief);
            return count(array_intersect($resTagNames, $tagNames)) > 0;
          });
        }
    }
    return $restaurants;
  }

  public static function filterByCategories($condition, $restaurants, $lang = "en"){
    if (isset($condition['categories'])) {
        $tagNames = Tag::whereIn('id', $condition['categories'])->select("name_$lang as name")->pluck('name')->toArray();
        if (in_array('all', $condition['categories'])) {
            // query without condition
        } else if (in_array('other', $condition['categories'])) {
            $restaurants = $restaurants->where("title_brief", null);
        } else {

          $restaurants = $restaurants->filter(function($value,$key) use ($tagNames){
            $resTagNames = explode(', ', $value->title_brief);
            return count(array_intersect($resTagNames, $tagNames)) > 0;
          });
        }
    }

    return $restaurants;
  }
}
