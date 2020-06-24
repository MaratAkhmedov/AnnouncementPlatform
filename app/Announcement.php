<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App;

class Announcement extends Model
{
    //

    protected $primaryKey  = 'id';
    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'announcements.name',
        'announcements.description'
    ];

    protected $fillable = [
        'user_id','subcategory_id', 'name', 'description',
        'price', 'location', 'email', 'phone', 'contact_preferences'
    ];


    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if(strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode( ' ', $words);

        return $searchTerm;
    }

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
     */
    public function announcement_images()
    {
        return $this->hasMany('App\Announcement_image')->orderBy("order_index")->select("id", "announcement_id", "order_index", "image_id");
    }

    /**
     * get status by id of announcement
     * @param $id -> integer
     */
    public function get_status($id){
        return $this->where("id", $id)->select("id")->first()->status;
    }


    /** announcement card in home page if $search isnt null app will search announcements with those parameters
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeAnnouncement_card($query, $search = null, $orderBy = null){
       $query
           ->when($search, function ($query, $search) {
               $columns = implode(',',$this->searchable);
               return $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , $this->fullTextWildcards($search));
           })
           ->join('announcement_images', function ($join) {
                $join->on('announcements.id', '=', 'announcement_images.announcement_id')
                    ->where('announcement_images.order_index', '=', 1);
                })
           ->join('images','announcement_images.image_id', '=', 'images.id')
           ->join('subcategories', 'announcements.subcategory_id', '=', 'subcategories.id')
           ->join('categories', 'subcategories.category_id', '=', 'categories.id')
           ->select("announcements.*","categories.name AS category_name","subcategories.name AS subcategory_name","images.image_url")
           ->when($orderBy, function ($query, $orderBy) {
               return $query->orderBy($orderBy, "ASC");
           })
       ;
        return $query;
    }




    /** announcement card in profile
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeAnnouncement_card_user($query,$id){
        $query
            ->where("announcements.user_id", "=", $id)
            ->announcement_card();

        return $query;
    }

    /** returns all announcements that belongs to subcategory passed as parameter
     * @param $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSubcategory_announcements($query, $subcategory_name, $search = null){
        $query->where("subcategories.name", $subcategory_name)->announcement_card($search);
        return $query;
    }

    /**  returns all announcements that belongs to category passed as parameter
     * @param $category_name
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeCategory_announcements($query,$category_name, $search = null){
        $query
            ->where("categories.name", $category_name)
            ->announcement_card($search);
        return $query;
    }

    /** check paramaters passed in aside bar at the right on the index page
     * @param $query
     * @param null $min_price
     * @param null $max_price
     * @return mixed
     */
    public function scopeCheck_parameters($query, $min_price = null, $max_price = null){
        $query
            ->when($min_price, function ($query, $min_price) {
                return $query->where("announcements.price", ">=", $min_price);
            })
            ->when($max_price, function ($query, $max_price) {
                return $query->where("announcements.price", "<=", $max_price);
            });
        return $query;
    }


    public function scopeOrder_by($query, $order_by = null){
        if(!$order_by || $order_by == "Fecha"){
            $query
                ->orderBy("created_at", "DESC");
        }
        else if ($order_by == "Precio"){
            $query
                ->orderBy("price", "ASC");
        }

        //else if(){
        //.................
        //}
        return $query;
    }


    public function scopeGet_announcement($query, $id){
        $query
            ->where("announcements.id", $id)
            ->with("announcement_images.image:id,image_url");
        return $query;
    }

    /**
     * returns the user that has this announcement
     * @param $announcement_id
     *
     */
    public static function getUserId($announcement_id){
        $announcement = self::find($announcement_id);
        return $announcement->user_id;
    }

    /** create Announcement based on parameters received
     * @param $name
     * @param $price
     * @param $description
     * @param $location
     * @param null $email
     * @param null $phone
     * @param null $contact_preferences
     * @return mixed return the id of the created announcement
     */
    public static function create_AnnouncementDB($name, $price, $description, $location, $subcategory_id, $user_id,$email = null, $phone = null, $contact_preferences = null){
        $announcement = new Announcement();
        $announcement -> name = $name;
        $announcement -> description = $description;
        $announcement -> price = $price;
        $announcement -> location = $location;
        $announcement -> email = $email;
        $announcement -> phone = $phone;
        $announcement -> contact_preferences = $contact_preferences;
        $announcement -> user_id = $user_id;
        $announcement -> subcategory_id = $subcategory_id;
        $announcement -> save();
        return $announcement->id;
    }

}
