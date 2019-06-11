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

/**
 * shop:
 */	
Route::get('/', function () {
    return view('welcome');
});

// shop_admin
Route::namespace('Admin')->group(function() {
	Route::get('/admin/dashboard', 'DashboardController@index')->middleware('auth:admin');
	Route::get('/admin/orders', 'OrdersController@index')->middleware('auth:admin');
	// Route::get('/admin/settings', '');
	Route::resource('/admin/categories', 'CategoriesController')->middleware('auth:admin');
	Route::resource('/admin/products', 'ProductsController')->middleware('auth:admin');
		Route::get('/admin/products/create/{category}', 'ProductsController@create')->middleware('auth:admin');
});


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


Auth::routes();

Route::get('/admin/login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\Admin\LoginController@login');
Route::post('/admin/logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');

Route::get('/manage/login', 'Auth\Manage\LoginController@showLoginForm')->name('manage.login');
Route::post('/manage/login', 'Auth\Manage\LoginController@login');
Route::post('/manage/logout', 'Auth\Manage\LoginController@logout')->name('manage.logout');

// shop_user
Route::namespace('User')->group(function() {
	Route::get('/user/dashboard', 'DashboardController@index')->middleware('auth');

});

/**
 * site_admin
 */
Route::namespace('Manage')->group(function() {
	Route::resource('/manage/shops', 'ShopsController')->middleware('auth:manage');
	// Route::resource('/admin/categories', 'CategoriesController')->middleware('auth:admin');
	// Route::resource('/admin/products', 'ProductsController')->middleware('auth:admin');
	// 	Route::get('/admin/products/create/{category}', 'ProductsController@create')->middleware('auth:admin');
});