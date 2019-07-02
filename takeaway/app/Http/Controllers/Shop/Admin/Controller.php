<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Controllers\Shop\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        // auth
        $this->middleware('auth:shop');
    
        // init shop instance
        parent::__construct();
    }
}