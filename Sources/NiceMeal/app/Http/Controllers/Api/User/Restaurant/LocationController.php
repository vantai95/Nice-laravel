<?php

namespace App\Http\Controllers\Api\User\Restaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Restaurant;
use App\Models\Tag;

class LocationController extends Controller
{
    public function getFilterList(Request $request){
        $lang = $request->header('language');
        $district_id = $request->input('district_id');
        
        // query db
        $cuisines = Tag::where('type', Tag::TYPE['cuisine'])->select('tags.id',"name_$lang as name")->get();
        $categories = Tag::where('type', Tag::TYPE['category'])->select('tags.id',"name_$lang as name")->get();

        return response()->json([
            'success' => true,
            'data' => [
                'cuisines' => $cuisines,
                'categories' => $categories,
            ]
        ]);
    }
}
