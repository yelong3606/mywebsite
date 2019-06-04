<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * base controller of all shop app controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * current shop object
     * @var \App\Shop;
     */
    protected $shop;

    /**
     * constructor
     * init current shop object, must be called in subclass's constructor
     */
    public function __construct()
    {
        if (!app()->runningInConsole()) {
            $domain = str_replace(['http://', 'https://'], '', request()->root());
            $this->shop = \App\Shop::where('shop_domain', $domain)->first() ?: abort(404);
            View::share('shop', $this->shop);
        }
    }
}
