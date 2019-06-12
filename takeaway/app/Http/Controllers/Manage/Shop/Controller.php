<?php

namespace App\Http\Controllers\Manage\Shop;

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
        $this->middleware('auth:manage');

        // init shop object
        if (!app()->runningInConsole()) {
            $id = $router->input('shop');
            $this->shop = \App\Shop::find($id) ?: abort(403, 'Shop #' . $id . ' Not Exist!');
            View::share('shop', $this->shop);
            View::share('route_prefix', $this->route_prefix());
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
        return 'manage.shop.';
    }

    /**
     * @return String
     */
    protected function route_prefix()
    {
        return 'manage.';
    }
}