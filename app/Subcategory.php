<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $primaryKey  = 'id';
    //
    protected $table = 'subcategories';

    protected $fillable = [
        'category_id','name'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    /**
     * @param $subCategory_name    string
     * @return mixed the id of category searched
     */
    public static function getSubcategoryId($subcategory_name){
        return Subcategory::where("name", $subcategory_name)->first()->id;

    }
}
