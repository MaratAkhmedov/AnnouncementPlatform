<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //
    protected $table = 'subcategories';

    protected $fillable = [
        'category_id','name'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
