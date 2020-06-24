<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Category;
use App\Announcement;
use Illuminate\Support\Facades\Input;
use URL;
use Illuminate\Support\Facades\Route;


class HomeController extends Controller
{
    const CARDS_ON_INDEX_PAGE = 15;
    public $search = null;
    public $min_price = null;
    public $max_price = null;
    public $order_by = null;



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->search = request()->get("q");
        $this->min_price = request()->get("min_price");
        $this->max_price = request()->get("max_price");
        $this->order_by =  request()->get("order_by");
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


    /**Works with search (q) and also parameters and orders announcements if it is necessary
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $url = str_replace("-", " ",request()->path());
        $url_array = explode("/", urldecode($url));
        $url_array = array_filter($url_array);
        $array_length = count($url_array);
        $parameters = request()->except("page");
        $subcategory_name = null;
        $category_name = null;
        switch ($array_length){
            case 2:
                $subcategory_name = $url_array[1];
                $announcements = App\Announcement::subcategory_announcements($subcategory_name, $this->search)
                    ->check_parameters($this->min_price, $this->max_price)
                    ->paginate(self::CARDS_ON_INDEX_PAGE);
                break;
            case 1:
                $category_name = $url_array[0];
                $announcements = App\Announcement::category_announcements($category_name, $this->search)
                    ->check_parameters($this->min_price, $this->max_price)
                    ->paginate(self::CARDS_ON_INDEX_PAGE);
                break;
            default:
                $announcements = App\Announcement::announcement_card($this->search)
                    ->check_parameters($this->min_price, $this->max_price)
                    ->order_by($this->order_by)
                    ->paginate(self::CARDS_ON_INDEX_PAGE);
                break;
        }

        return view('index', ['announcements' => $announcements, 'category_name' => $category_name, 'subcategory_name' => $subcategory_name]);
    }



    public function show_page($id){
        $announcement = Announcement::get_announcement($id)->with("user")->first()->toArray();
        //dd($announcement);
        return view("product_page",  ['announcement' => $announcement]);
    }


}
