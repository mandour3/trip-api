<?php
namespace App\traits;
require './vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
trait image_upload{



    public function verifyAndStoreImage(Request $request, $inputname , $foldername , $disk ) {

        if( $request->hasFile( $inputname ) ) {

            // Check img
            if (!$request->file($inputname)->isValid()) {
                flash('Invalid Image!')->error()->important();
                return response()->json(['message' => 'Invalid data'], 401);
            }

            $photo = $request->file($inputname);
            $name = \Str::slug($request->input('name'));
            $filename = $name. '.' . $photo->getClientOriginalExtension();

            // insert Image

            return $request->file($inputname)->storeAs($foldername, $filename, $disk);
        }

        return null;

    }

}
