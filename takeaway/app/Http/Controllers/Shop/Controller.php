<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\View;

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
            $domain = parse_url(url()->current(), PHP_URL_HOST);
            $this->shop = \App\Shop::where('shop_domain', $domain)->first() ?: abort(404);
            View::share('shop', $this->shop);
        }
    }

    protected function shop()
    {
        return $this->shop;
    }
}
