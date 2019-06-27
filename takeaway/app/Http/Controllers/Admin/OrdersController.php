<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function index() {
    	return view('admin.orders');
    }
}