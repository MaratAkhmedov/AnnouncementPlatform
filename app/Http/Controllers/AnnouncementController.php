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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$categories = App\category::select(['name'])->pluck('name');
        //echo var_dump($categories);
        /*foreach ($categories as $category){
            $subcategories = App\subcategory::all();
        }*/
        $categories = App\category::all();
        //echo var_dump($subcategories);
        $category_name_array = [];
        foreach ($categories as $category){
            $category_name = $category->name;
            $subcategories = $category->subcategories;
            $category_name_array[] = ["category_name" => $category_name, "subcategories" => $subcategories];
            //$category_name_array = ["$category_name" => [$subcategories]];
        }
        //echo var_dump($category_name_array);

        //$subcategories = App\subcategory::all();
        /*foreach ($categories as $category){
            echo $category->name;
        }*/
        return view('createAnnouncement.category.selectCategory')->with("category_array", $category_name_array);
    }

    public function createAnnouncement($subcategoryId = null){
        // sacamos la categoria a partir de la subcategoria
        $subcategory = App\subcategory::find($subcategoryId);

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
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'price' => 'required',
            'announcement_name' => 'required',
            'photos'=>'required',

        ]);


        //insert form data into database
        $announcement = new Announcement();
        $announcement -> name = $request -> announcement_name;
        $announcement -> description = $request -> description;
        $announcement -> price = $request -> price;

        //get subcategory id
        $subcategory_id = Subcategory::where("name", $request -> subcategory_selected)->first()->id;
        $announcement -> subcategory_id = $subcategory_id;
        $announcement -> user_id = Auth::id();
        //save location of the user
        $location = $request -> adress;
        $announcement -> location = $location;

        $announcement -> save();
        //get announcement_id
        $announcement_id = $announcement->id;


        //insert images into database
        $allowedfileExtension=["jpg","png", "JPG", "PNG"];

        if($request->hasfile('photos'))
        {
            $i = 1;
            foreach($request->file('photos') as $photo)
            {
                $extension = $photo->getClientOriginalExtension();
                $compatible = in_array($extension,$allowedfileExtension);
                $name=$photo->getClientOriginalName();

                //$photo->move(public_path().'/images/', $name);
                //$data[] = $name;
                //si es una extension compatible
                if($compatible){
                    $fileName = time().$name;
                    $photo->move(public_path().'/images/', $fileName);
                    //create rows in database images
                    $image = new Image();
                    $image -> image_url = '/images/'.$fileName;
                    $image -> save();
                    //to get the id of inserted element
                    $image_id = $image->id;
                    // create row into database announcements_images
                    $announcement_image = new Announcement_image();
                    $announcement_image->order_index = $i;
                    $announcement_image->image_id = $image_id;
                    $announcement_image->announcement_id = $announcement_id;
                    $announcement_image -> save();
                }else{
                    return "El formato de la imagen no es compatible";
                }
                $i++;
            }
        }else{
            return "hay que cargar photos";
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
        $array = App\Announcement::with("subcategory.category", "announcement_images.image")->where("id", $id)->first()->toArray();
        //dd($array);
        return view("profile.update_announcement.update_announcement_form")->with("array", $array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $announcement = App\Announcement::find($id);

        //update all columns in Announcement table
        $announcement->update($request->all());
        // array with id of images that are uploaded on the server
        $array_uploaded_on_server = App\Announcement_image::where("announcement_id", $id)->pluck("image_id")->toArray();

        //delete all images that dont belongs to that array

        //dd($array_uploaded_on_server);
        $array = $request->all();

        // delete those elements from database
        //var_dump($array_uploaded_on_server);
        //var_dump($array["uploaded_photos"]);
        //dd($array);
        //$uploaded_photos_array = array_key_exists("uploaded_photos", $array) ? $array["uploaded_photos"] : [];
        $array_images_to_remove = array_diff($array_uploaded_on_server, $array["photos"]);
        //delete from announcement_image and image table all rows that belongs to this array
        foreach ($array_images_to_remove as $image_id){
            //dd($image_id);
            App\Announcement_image::where("image_id", $image_id)->delete();
            $image = App\Image::find($image_id);
            $image_path = $image->image_url;
            File::delete(public_path().$image_path);
            $image->delete();
        }

        //dd($request->all());
        //$announcement->update($request->all());

        $allowedfileExtension=["jpg","png", "JPG", "PNG"];

            $i = 1;
            foreach($array["photos"] as $photo)
            {
                if (is_file($photo)) {
                    $extension = $photo->getClientOriginalExtension();
                    $compatible = in_array($extension, $allowedfileExtension);
                    $name = $photo->getClientOriginalName();

                    //$photo->move(public_path().'/images/', $name);
                    //$data[] = $name;
                    //si es una extension compatible
                    if ($compatible) {
                        $fileName = time() . $name;
                        $photo->move(public_path() . '/images/', $fileName);
                        //create rows in database images
                        $image = new Image();
                        $image->image_url = '/images/' . $fileName;
                        $image->save();
                        //to get the id of inserted element
                        $image_id = $image->id;
                        // create row into database announcements_images
                        $announcement_image = new Announcement_image();
                        $announcement_image->order_index = $i;
                        $announcement_image->image_id = $image_id;
                        $announcement_image->announcement_id = $id;
                        $announcement_image->save();
                    } else {
                        return "El formato de la imagen no es compatible";
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
       // dd($image_id_array)
        //array with url of images that we should delete
        $array_image_url = App\Image::find($image_id_array)->pluck("image_url")->toArray();
        foreach ($array_image_url as $image_url){
            //dd("$image_url");
            if(File::exists(public_path().$image_url)) {
                File::delete(public_path().$image_url);
            }
        }

        $announcement_images->delete();
        $aux = App\Image::whereIn("id", $image_id_array)->delete();
        $announcement->delete();
        return redirect()->route("profile");
    }
}
