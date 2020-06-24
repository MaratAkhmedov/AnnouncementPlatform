<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Category;
use App\Subcategory;
use App\User;



class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the admin dashboard with all announcement.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $announcements = Announcement::Announcement_card(null, "updated_at")->get()->toArray();
        return view("admin.index")->with("announcements", $announcements);
    }

    public function show_announcement($id){
        $announcement = Announcement::get_announcement($id)->with("user")->first()->toArray();
        return view("product_page",  ['announcement' => $announcement]);
    }

    /**
     * change status in annuncement
     * status::
     * 0 -> waiting to be aproved
     * 1 -> blocked (contenido prohibido)
     * 2 -> blocked (otras causas)
     * 10 -> approved
     *
     * $status -> integer
     * $id -> integer
     */
    public function change_status($id, $status){
        $announcement =Announcement::find($id);
        $announcement->status = $status;
        $announcement->save();
        return redirect()->back();
    }


    /**
     * Show the category list
     */
    public function category_settings()
    {
        $categories = Category::all()->toArray();
        return view("admin.categories")->with("categories", $categories);
    }

    /**
     *  delete Selected Category and all subcategories related with this category, also this method will delete all announcements related with this category
     */
    public function delete_category($id){
        $category = Category::find($id);
        $subcategory_related = Category::find($id)->subcategories();
        $subcategory_id_array = $subcategory_related -> pluck("id") ->toArray();
        if($subcategory_id_array) {
            $announcements_id_related = Announcement::where("subcategory_id", $subcategory_id_array)->pluck("id")->toArray();


            foreach ($announcements_id_related as $announcement_id) {
                app('App\Http\Controllers\AnnouncementController')->destroy($announcement_id);
            }
            $subcategory_related->delete();
        }
        $category -> delete();
        return redirect()->back();
    }

    /**
     * add category to category db
     */
    public function add_category(Request $request){
        $category_name = $request->post("category_name");
        if($category_name){
            Category::create(["name" => $category_name]);
        }
        return redirect()->back();
    }

    /**
     *   change the name of the category passed as id, the request contains the new name
     */
    public  function change_category_name(Request $request,$id){
        $category_name = $request->post("category_name");
        if($category_name) {
            $category = Category::find($id);
            $category->name = $category_name;
            $category->save();
        }
        return redirect()->back();
    }

    /**
     * show the subcategory list
     */
    public function subcategory_settings(){
        $categories = Category::with("subcategories")->get()->toArray();
        return view("admin.subcategories")->with("categories", $categories);
    }

    /**
     * add subcategory to category db
     */
    public function add_subcategory(Request $request){
        $category_id = $request->post("category_id");
        $subcategory_name = $request->post("subcategory_name");
        if($subcategory_name){
            Subcategory::create(["name" => $subcategory_name, "category_id" => $category_id]);
        }
        return redirect()->back();
    }

    public function delete_subcategory($id){
        $subcategory = Subcategory::find($id);
        $announcements_id_related = Announcement::where("subcategory_id", $subcategory->id)->pluck("id")->toArray();
        foreach ($announcements_id_related as $announcement_id) {
            app('App\Http\Controllers\AnnouncementController')->destroy($announcement_id);
        }
        $subcategory->delete();
        return redirect()->back();
    }

    /**
     *   change the name of the category passed as id, the request contains the new name
     */
    public  function change_subcategory_name(Request $request,$id){
        $subcategory_name = $request->post("subcategory_name");
        if($subcategory_name) {
            $subcategory = Subcategory::find($id);
            $subcategory->name = $subcategory_name;
            $subcategory->save();
        }
        return redirect()->back();
    }

    /**
     * Ajustes de los usuarios
     */
    public function user_settings(){
        $users = User::all()->toArray();
        return view("admin.user_settings", ["users" => $users]);
    }

    /**
     * Borrar el usuario de la base de datos y todos los anuncion relacionados con el usuario
     */
    public function delete_user($id){
        $user = User::find($id);
        $announcements_id_related = Announcement::where("user_id", $id)->pluck("id")->toArray();
        foreach ($announcements_id_related as $announcement_id) {
            app('App\Http\Controllers\AnnouncementController')->destroy($announcement_id);
        }
        $user->delete();
        return redirect()->back();
    }
}
