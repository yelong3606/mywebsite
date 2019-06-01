<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $domain = str_replace(['http://', 'https://'], '', $request->root());
        $this->shop = \App\Shop::where('shop_domain', $domain)->first() ?: abort(404);
    }
}
