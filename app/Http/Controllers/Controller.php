<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $categories = Category::select("id", "name as category_name")->with("subcategories:id,category_id,name as subcategory_name")->get()->toArray();
        View::share('categories', $categories);
    }
}
