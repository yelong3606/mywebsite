<?php

namespace App\Http\Controllers\Site\Shopadmin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    /**
     * @var App\Shop;
     */
    protected $shop;

    /**
     * constructor
     * init shop object
     */
    public function __construct(Router $router) {
        // auth
        $this->middleware('auth:site');

        // init shop object
        if (!app()->runningInConsole()) {
            $id = $router->input('shop');
            $this->shop = \App\Shop::find($id) ?: abort(403, 'Shop #' . $id . ' Not Exist!');
            View::share('shop', $this->shop);
        }
    }

    /**
     * @return App\Shop
     */
    protected function shop()
    {
        return $this->shop;
    }

    /**
     * @return String
     */
    protected function template_prefix()
    {
        return 'site.shopadmin.';
    }
}