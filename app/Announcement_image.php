<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement_image extends Model
{
    protected $primaryKey  = 'id';
    //
    protected $table = 'announcement_images';

    protected $fillable = [
        'announcement_id','order_index', 'image_id'
    ];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }


    /** Create row into database announcements_images
     * @param $order_index
     * @param $image_id
     * @param $announcement_id
     * @return mixed returns the id of inserted element
     */
    public static function create_announcent_imageDB($order_index, $image_id, $announcement_id){
        $announcement_image = new Announcement_image();
        $announcement_image->order_index = $order_index;
        $announcement_image->image_id = $image_id;
        $announcement_image->announcement_id = $announcement_id;
        $announcement_image -> save();
        return $announcement_image->id;
    }
}
