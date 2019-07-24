<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement_image extends Model
{
    //
    protected $table = 'announcement_images';

    protected $fillable = [
        'announcement_id','order_index', 'image_id'
    ];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }
}
