<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $primaryKey  = 'id';
    //
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    public function subcategories()
    {
        return $this->hasMany('App\Subcategory', "category_id");
    }

    public function scopeCategory_and_subcategories($query){


        return $query;
    }
}
