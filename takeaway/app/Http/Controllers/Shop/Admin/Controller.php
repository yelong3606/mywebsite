<?php

namespace App\Http\Controller\Shop\Admin;

use App\Http\Controller\Shop\Controller as BaseController;

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