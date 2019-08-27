<?php

namespace App\Services\Restaurant;

/**
 *
 */
class RestaurantSortService
{
  public static function sort($sort, $restaurants){
    if (isset($sort)) {
        if ($sort['key'] == '') {
            ($sort['direction'] == 'asc')
                ? $restaurants = $restaurants->sortByDesc('vip_restaurant')->sortByDesc('is_open_now')
                : $restaurants = $restaurants->sortBy('vip_restaurant')->sortByDesc('is_open_now');
        } else {
            ($sort['direction'] == 'asc')
                ? $restaurants = $restaurants->sortBy($sort['key'])
                : $restaurants = $restaurants->sortByDesc($sort['key']);

        }
    }

    $idx = 0;
    foreach ($restaurants as $restaurant) {
        $restaurant->idx = $idx;
        $idx = $idx + 1;
    }

    return $restaurants;
  }
}
