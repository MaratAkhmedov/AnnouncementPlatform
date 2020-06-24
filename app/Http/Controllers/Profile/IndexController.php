<?php
namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the index page of user with his announcements that were published before.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //get id of logged in user
        $user_id = Auth::id();
        $array = App\Announcement::announcement_card_user($user_id)->get()->toArray();
        return view("profile.index")->with('array', $array);
    }
}