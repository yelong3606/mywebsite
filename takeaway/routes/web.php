<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// admin
// Route::get('/admin/login', '');
// Route::get('/admin/logout', '');
Route::get('/admin/dashboard', 'Admin\DashboardController@index');
Route::get('/admin/orders', 'Admin\OrdersController@index');
// Route::get('/admin/settings', '');
// Route::get('/admin/categories', 'Admin\CategoriesController@index');
// Route::get('/admin/products', 'Admin\ProductsController@index');

// // customer
// Route::get('/customer/login', '');
// Route::get('/customer/register', '');
// Route::get('/customer/account', 'Customer\AccountController@index');
// Route::get('/customer/orders', 'Customer\OrdersController@index');
// Route::get('/customer/credit', '');
// Route::get('/customer/payment', '');
// Route::get('/customer/addresses', 'Customer\AddressesController@index');

// // flow
// Route::get('/flow/shop', '');

