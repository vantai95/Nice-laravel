<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Storage, File;

class ImageUploadController extends Controller
{
    public function uploadImage(Request $request) {
        $files = $request->file('files');
        $returnData = [];
        foreach($files as $key => $file){
            $time = time();
            $photoName =  "{$time}.{$key}.{$file->getClientOriginalExtension()}";
            Storage::disk(ENV('FILESYSTEM_CLOUD'))->put($photoName, file_get_contents($file->getRealPath()));

            $image = Image::create(['image' => $photoName]);
            $imageId = $image->id;
            $photoUrl = $photoName;
            $data = [
                'thumb_image_name' => $image->image,
                'image_id' => $imageId,
                'imageURL' => $photoUrl
            ];
            array_push($returnData,$data);
        }
        return response()->json([
            'success' => true,
            'message' => 'Upload success',
            'data' =>  $returnData
        ]);
    }

    public function getImageList() {
        $imageList = Image::get();
        return response()->json([
            'data' =>  $imageList
        ]);
    }
}
