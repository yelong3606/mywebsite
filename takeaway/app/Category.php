<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // // table name
    // protected $table = "categories";
    // // primary key
    // protected $primaryKey = 'id';
    // // increatment
    // public $incrementing = true;
    // // timestamps
    // public $timestamps = true; 

    // default value for attributes
    protected $attributes = [
    	'category_order' => 0,
    ];
}
