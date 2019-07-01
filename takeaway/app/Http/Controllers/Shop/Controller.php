<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * shop instance
     */
    protected $shop;

    /**
     * constructor
     */
    public function __construct()
    {
        if (!app()->runningInConsole()) {
            // init shop instance
            
            // $id = $router->input('shop');
            // $this->shop = \App\Shop::find($id) ?: abort(403, 'Shop #' . $id . ' Not Exist!');
            // View::share('shop', $this->shop);
        }
    
    }
}
