<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Announcement extends Model
{
    use FullTextSearch;
    //
    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'user_id','subcategory_id', 'name', 'description',
        'price', 'location', 'email', 'phone', 'contact_preferences'
    ];

    /**
     * Get the user associated with this announcement.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the subcategory associated with this announcement.
     */
    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }

    /**
     * Get get urls of all images associated with this announcements
     *
     * $images = App\Announcement_image::find(1)->announcements;
     * foreach ($announcements as $announcement) {
     *     echo $announcement->name;
     *}
    }
     */
    public function announcement_images()
    {
        return $this->hasMany('App\Announcement_image')->orderBy("order_index");
    }


    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public static function announcement_card(){
        $announcement = DB::table("announcements")
            ->join('announcement_images', function ($join) {
                $join->on('announcements.id', '=', 'announcement_images.announcement_id')
                    ->where('announcement_images.order_index', '=', 1);
            })
            ->join('images','announcement_images.image_id', '=', 'images.id')
            ->join('subcategories', 'announcements.subcategory_id', '=', 'subcategories.id')
            ->join('categories', 'subcategories.category_id', '=', 'categories.id')
            ->select("announcements.*","categories.name AS category_name","subcategories.name AS subcategory_name","images.image_url");

        return $announcement;
    }




    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public static function announcement_card_user($id){
        $announcement = DB::table("announcements")
            ->where("announcements.user_id", "=", $id)
            ->join('announcement_images', function ($join) {
                $join->on('announcements.id', '=', 'announcement_images.announcement_id')
                    ->where('announcement_images.order_index', '=', 1);
            })
            ->join('images','announcement_images.image_id', '=', 'images.id')
            ->select("announcements.name","announcements.price","announcements.location", "announcements.id", "announcements.description", "announcements.updated_at","images.image_url");

        return $announcement;
    }


    /**
     * remove all relationship
     */

    // this is a recommended way to declare event handlers
   /* public static function boot() {
        parent::boot();

        static::deleting(function($announcement) { // before delete() method call this
            //$announcement->announcement_images()->delete();
            $announcement->announcement_images()->image()->delete();
            // do the rest of the cleanup...
        });
    }*/


}
