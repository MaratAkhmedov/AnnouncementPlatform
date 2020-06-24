<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    //
    /**
     * deletes all images with the id passed as parameter
     **/
    public static function delete_photos($array_images_to_remove){
        //delete from announcement_image and image table all rows that belongs to this array
        foreach ($array_images_to_remove as $image_id){
            //dd($image_id);
            App\Announcement_image::where("image_id", $image_id)->delete();
            $image = App\Image::find($image_id);
            $image_path = $image->image_url;
            File::delete(public_path().$image_path);
            $image->delete();
        }
    }


    /** create rows in database
     * @param $image_url save route
     * @return mixed returns the id of inserted image
     */
    public static function create_imageDB($image_url){
        $image = new Image();
        $image -> image_url = $image_url;
        $image -> save();
        return $image->id;
    }

}
