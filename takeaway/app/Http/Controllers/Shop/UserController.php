<?php

namespace App\Http\Controllers\Shop;

class UserController extends Controller
{
    public function __construct()
    {
        // auth
        $this->middleware('auth');

        parent::__construct();
    }

    public function addresses() 
    {
        return "addresses page";
    }
}