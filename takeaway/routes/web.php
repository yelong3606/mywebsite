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
 * site
 */
Route::domain('www.yelin.com')->group(function() {
	// homepage
	Route::get('/', 'Site\HomeController@index');

	// admin dashboard
	Route::get('/admin', 'Site\Admin\DashboardController@index')->middleware('auth:site');

	// admin:import data from justeat
	Route::get('/admin/my', 'Site\Admin\MyController@index')->middleware('auth:site');
	
	// admin:shops
	Route::resource('/admin/shops', 'Site\Admin\ShopsController')->middleware('auth:site');

	// admin:regions
	Route::resource('/admin/regions', 'Site\Admin\RegionsController')->middleware('auth:site');

	// admin:auth
	Route::get('/admin/login', 'Auth\Site\LoginController@showLoginForm')->name('site.login');
	Route::post('/admin/login', 'Auth\Site\LoginController@login');
	Route::post('/admin/logout', 'Auth\Site\LoginController@logout')->name('site.logout');

	// shopadmin:dashboard
	Route::get('/shop{shop}', 'Site\Shopadmin\DashboardController@index')->name('site.dashboard');
	
	// shopadmin:category
	Route::resource('/shop{shop}/categories', 'Site\Shopadmin\CategoriesController');

	// shopadmin:menu-options
	Route::resource('/shop{shop}/options', 'Site\Shopadmin\OptionsController');

	// shopadmin:menus
	Route::resource('/shop{shop}/menus', 'Site\Shopadmin\MenusController');

	// shopadmin:settings
	Route::get('/shop{shop}/settings/edit', 'Site\Shopadmin\SettingsController@edit')->name('settings.edit');
	Route::put('/shop{shop}/settings', 'Site\Shopadmin\SettingsController@update')->name('settings.update');

	// shopadmin:deliveries
	Route::resource('/shop{shop}/deliveries', 'Site\Shopadmin\DeliveriesController');

});

/**
 * shop
 */
// homepage
Route::get('/', 'Shop\HomeController@index');
Route::post('/addtocart', 'Shop\HomeController@addtocart');
Route::post('/removefromcart', 'Shop\HomeController@removefromcart');
Route::get('/addtocart', 'Shop\HomeController@addtocart');

// admin dashboard
Route::get('/admin', function(){
	return "dashboard";
})->middleware('auth:shop');

// admin (here use shopcategories to ignore same route name as in site/shopadmin)
Route::resource('/admin/shopcategories', 'Shop\Admin\CategoriesController');

// user
// Route::get('/user/account', 'user\AccountController@index');
// Route::get('/user/orders', 'user\OrdersController@index');
// Route::get('/user/credit', '');
// Route::get('/user/payment', '');
Route::get('/user/addresses', 'Shop\UserController@addresses');

// // flow
// Route::get('/flow/shop', '');


Auth::routes();

Route::get('/admin/login', 'Auth\Shop\LoginController@showLoginForm')->name('shop.login');
Route::post('/admin/login', 'Auth\Shop\LoginController@login');
Route::post('/admin/logout', 'Auth\Shop\LoginController@logout')->name('shop.logout');

// login with google
Route::get('/login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('/login/google/callback', 'Auth\LoginController@handleGoogleCallback');

// login with facebook
Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');



