<?php

namespace App\Services;

use App\Models\District;

class LocationService
{
    static function saveLocationInfo($data = [], $user)
    {
        setcookie("location_info", json_encode([
            'district' => [
                'id' => $data['district_id'],
                'slug' => $data['district_slug']
            ],
            'ward' => $request->input('ward'),
            'province_id' => $district->province_id
        ]), time() + (86400 * 30), '/');

        if (Auth::check()) {
            UsersSession::create([
                'user_id' => Auth::user()->id,
                'district_id' => $district->id,
                'ward_id' => $request->input('ward'),
                'province_id' => $district->province_id
            ]);
        }
    }

    static function getAllLocations($lang = '')
    {
        $allLocation = District::with([
            'wards' => function ($query) use ($lang) {
                $query->select("wards.id as ward_id",
                    'wards.district_id',
                    "wards.province_id",
                    "wards.name_$lang as ward_name");
            }
        ])->select("districts.name_$lang as name",
            "districts.id",
            "districts.province_id",
            "districts.slug")->orderBy("sequence",'asc');

        return $allLocation;
    }

}
