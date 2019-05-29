<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Shop;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * instance of shop
     * @var App\Shop;
     */
    protected $shop;

    /**
     * constructor
     */
    function __construct()
    {
    	// todo: domain get method
        if (isset($_SERVER['SERVER_NAME'])) {
            $domain = $_SERVER['SERVER_NAME'];
            $this->shop = Shop::where('shop_domain', $domain)->first();
            if ($this->shop === null) {
                abort(404);
            }
            }
    }
}
