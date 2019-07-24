<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Announcement;
use Illuminate\Support\Facades\Input;
use URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$announcements = App\Announcement::paginate(7)->items();
        $announcements = App\Announcement::announcement_card()->paginate(15);
        //dd($announcements);
        return view('index', ['announcements' => $announcements]);
    }

    public function show_page($category, $subcategory, $id){
        return view("product_page");
    }

    public function search(){
        dd(URL::current());
        dd(Input::get("q"));
        dd(Announcement::search()->get()->toArray());
    }
}
