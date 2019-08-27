<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Log, DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const WEEKNAME = [
        0 => 'sun',
        1 => 'mon',
        2 => 'tue',
        3 => 'wed',
        4 => 'thu',
        5 => 'fri',
        6 => 'sat',
    ];

    const MONTH_NAME = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    protected function base64ToImagePath($base64String, $parentPath) {
        $imageName = time() . '.png';

        $image = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $base64String));

        File::put($parentPath . '/' . $imageName, base64_decode($image));

        return $imageName;
    }

    public function validateAttr($attr) {
        $validArray = [];

        array_push($validArray, $attr->Null ? 'nullable' : 'required');
        if (strpos($attr->Type, 'tinyint') !== false)
            array_push($validArray, 'integer|boolean');
        else if (strpos($attr->Type, 'int') !== false)
            array_push($validArray, 'integer');
        if ($attr->Field == 'email')
            array_push($validArray, 'email');

        return implode('|', $validArray);
    }

    /*
     * $validates : ['key1' => 'value1', 'key2' => 'value2', ...]
     */
    public function validation(string $table, Request $request, $overrideValids) {

        $columnsIgnore = [ 'id', 'created_at', 'updated_at', 'deleted_at', 'slug' ];
        foreach($overrideValids as $key=>$value)
            array_push($columnsIgnore, $key);
        $columns = DB::select('describe ' . $table);
        $validateKeys = [];

        $validateKeys = array_merge($validateKeys, $overrideValids);
        foreach($columns as $key=>$column) {
            if(in_array($column->Field, $columnsIgnore)) {
                unset($columns[$key]);
            }
            else {
                $validateKeys[$column->Field] = $this->validateAttr($column);
            }
        }

        return $this->validate($request, $validateKeys);
    }

}
