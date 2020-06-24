<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;
use App\Announcement;
use App\Announcement_image;
use App\Subcategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CreateAnnouncementValidation;


use App\Image;
use Illuminate\Support\Facades\Input;

class AnnouncementController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = App\Category::all();
        $category_name_array = [];
        foreach ($categories as $category){
            $category_name = $category->name;
            $subcategories = $category->subcategories;
            $category_name_array[] = ["category_name" => $category_name, "subcategories" => $subcategories];
            //$category_name_array = ["$category_name" => [$subcategories]];
        }
        return view('createAnnouncement.category.selectCategory')->with("category_array", $category_name_array);
    }

    public function createAnnouncement($subcategoryId = null){
        // sacamos la categoria a partir de la subcategoria
        $subcategory = App\Subcategory::find($subcategoryId);

        if(is_null($subcategory) || is_null($subcategoryId)){
            return abort(404);
        }

        $category = $subcategory->category;
        $subcategoryArray = App\category::find($category->id)->subcategories()->pluck('name')->toArray();
        $subcategorySelected = $subcategory->name;
        //eliminamos del array el elemento seleccionado
        $key = array_search($subcategorySelected, $subcategoryArray);
        unset($subcategoryArray[$key]);
        //
        $array = ["category_name" =>$category->name, "subcategories" => $subcategoryArray,
            "subcategory_selected" => $subcategorySelected];
        //$subcategories = App\category::find($category);
        return view("createAnnouncement.addAnnouncementForm")->with($array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnnouncementValidation $request)
    {
        $validatedData = $request->validated();
        $subcategory_id = Subcategory::getSubcategoryId($request->subcategory_selected);
        $announcement_id = Announcement::create_AnnouncementDB($request -> announcement_name,$request -> price, $request -> description, $request -> adress, $subcategory_id, Auth::id());

        $allowedfileExtension=["jpg","png", "JPG", "PNG"];

        if($request->hasfile('photos'))
        {
            $i = 1;
            foreach($request->file('photos') as $photo)
            {
                $extension = $photo->getClientOriginalExtension();
                $compatible = in_array($extension,$allowedfileExtension);
                $name=$photo->getClientOriginalName();
                if($compatible)
                {
                    $fileName = time().$name;
                    $photo->move(public_path().'/images/', $fileName);
                    $image_id = Image::create_imageDB('/images/'.$fileName);
                    Announcement_image::create_announcent_imageDB($i,$image_id,$announcement_id);

                }
                $i++;
            }
        }
        return redirect()->route("profile");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $old_values = App\Announcement::with("announcement_images.image")->where("id", $id)->first()->toArray();
        $subcategory_object = App\Subcategory::find($old_values["subcategory_id"]);
        $subcategory_array = App\Category::find($subcategory_object->category->id)->subcategories->pluck("name")->toArray();
        //eliminamos del array el elemento seleccionado
        $key = array_search($subcategory_object->name, $subcategory_array);
        unset($subcategory_array[$key]);
        //
        $array = ["category_name" =>$subcategory_object->category->name, "subcategories" => $subcategory_array,
            "subcategory_selected" => $subcategory_object->name, "old_values" => $old_values];
        return view("createAnnouncement.addAnnouncementForm")->with($array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id -> announcement id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateAnnouncementValidation $request, $id)
    {
        //
        //$request->validated();
        $announcement = App\Announcement::find($id);
        //update all columns in Announcement table
        $announcement->update($request->all());
        // array with id of images that are uploaded on the server
        $array_uploaded_on_server = App\Announcement_image::where("announcement_id", $id)->pluck("image_id")->toArray();

        $array = $request->all();

        $array_images_to_remove = array_diff($array_uploaded_on_server, $array["photos"]);
        Image::delete_photos($array_images_to_remove);

        $allowedfileExtension=["jpg","png", "JPG", "PNG"];

            $i = 1;
            foreach($array["photos"] as $photo)
            {
                if (is_file($photo)) {
                    $extension = $photo->getClientOriginalExtension();
                    $compatible = in_array($extension, $allowedfileExtension);
                    $name = $photo->getClientOriginalName();

                    //si es una extension compatible
                    if ($compatible) {
                        $fileName = time() . $name;
                        $photo->move(public_path() . '/images/', $fileName);
                        $image_id = Image::create_imageDB('/images/'.$fileName);
                        Announcement_image::create_announcent_imageDB($i, $image_id, $id);
                    }
                }
                App\Announcement_image::where("image_id", $photo)->update(["order_index" => $i]);
                $i++;
            }
        return redirect()->route("profile");
    }

    /**
     * Borrar un anuncio de la base de datos
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = App\Announcement::find($id);
        $announcement_images = App\Announcement::find($id)->announcement_images();
        $image_id_array = $announcement_images->get()->pluck("image_id")->toArray();

        //array with url of images that we should delete
        $array_image_url = App\Image::find($image_id_array)->pluck("image_url")->toArray();

        foreach ($array_image_url as $image_url){
            if(File::exists(public_path().$image_url)) {
                File::delete(public_path().$image_url);
            }
        }
        $announcement_images->delete();
        App\Image::whereIn("id", $image_id_array)->delete();
        $announcement->delete();
       // return redirect()->route("profile");
        return redirect()->back();
    }

}
