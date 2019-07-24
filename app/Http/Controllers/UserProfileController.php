<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App;

class UserProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //get id of logged in user
        $user_id = Auth::id();
        $array = App\Announcement::announcement_card_user($user_id)->get();

        //$array = App\Announcement::with("announcement_images.image")->get()->toArray();
        /*$array = DB::table('announcements')
            ->where("user_id", $user_id)
            ->join('announcement_images', function ($join) {
                $join->on('announcements.id', '=', 'announcement_images.announcement_id')
                    ->where("order_index", 1);
            })
            ->join('images', 'announcement_images.image_id', '=', 'images.id')
            ->select('announcements.name','announcements.id','announcements.price','announcements.location','announcements.description','announcements.updated_at', 'announcement_images.order_index', 'images.image_url')
            ->get();
        $array = $array->map(function($i) {
            return (array)$i;
        })->toArray();*/

       // $array = App\Announcement::select("name", "price", "location", "description", "updated_at")->where("user_id", $user_id)->get()->toArray();

        $array = $array->map(function($i) {
            return (array)$i;
        })->toArray();

        //dd($array);
        return view("profile.index")->with('array', $array);
    }
}
