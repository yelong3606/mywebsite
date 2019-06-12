<?php

namespace App\Http\Controllers\Manage\Shop;

use Illuminate\Routing\Router;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Categories;
use Illuminate\Support\Facades\View;

class CategoriesController extends Controller
{
    use Categories;

    /**
     * constructor
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        if (!app()->runningInConsole()) {
            // init shop object
            $id = $router->input('shop');
            $this->shop = \App\Shop::find($id) ?: abort(403, 'Shop [#' . $id . '] Not Exist!');
            View::share('shop', $this->shop);

            // set template prefix
            // $this->template_prefix = 'manage.shop.categories.';

            // set route prefix
            // $this->route_prefix = 'manage.categories.';
            View::share('route_prefix', $this->route_prefix);

            // auth
            $this->middleware('auth:manage');
        }
    }
}