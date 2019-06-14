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
// Route::get('/', function () {
//     return view('welcome');
// });

// shop_admin
// Route::namespace('Admin')->group(function() {
// 	Route::get('/admin/dashboard', 'DashboardController@index')->middleware('auth:admin');
// 	Route::get('/admin/orders', 'OrdersController@index')->middleware('auth:admin');
// 	// Route::get('/admin/settings', '');
// 	Route::resource('/admin/categories', 'CategoriesController')->middleware('auth:admin');
// 	Route::resource('/admin/products', 'ProductsController')->middleware('auth:admin');
// 		Route::get('/admin/products/create/{category}', 'ProductsController@create')->middleware('auth:admin');
// });


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

// // shop_user
// Route::namespace('User')->group(function() {
// 	Route::get('/user/dashboard', 'DashboardController@index')->middleware('auth');

// });

/**
 * site_admin
 */
Route::namespace('Manage')->group(function() {
	// shops
	Route::resource('/manage/shops', 'ShopsController')->middleware('auth:manage');

	// shop-dashboard
	Route::get('/manage/shop/{shop}/dashboard', 'Shop\DashboardController@index')->name('manage.dashboard');
	
	// shop-categories
	Route::get('/manage/shop/{shop}/categories', 'Shop\CategoriesController@index')->name('manage.categories.index');
	Route::get('/manage/shop/{shop}/categories/create', 'Shop\CategoriesController@create')->name('manage.categories.create');
	Route::post('/manage/shop/{shop}/categories', 'Shop\CategoriesController@store')->name('manage.categories.store');
	Route::get('/manage/shop/{shop}/categories/{category}/edit', 'Shop\CategoriesController@edit')->name('manage.categories.edit');
	Route::put('/manage/shop/{shop}/categories/{category}', 'Shop\CategoriesController@update')->name('manage.categories.update');
	Route::delete('/manage/shop/{shop}/categories/{category}/destroy', 'Shop\CategoriesController@destroy')->name('manage.categories.destroy');

	// shop-menu-options
	Route::get('/manage/shop/{shop}/options', 'Shop\OptionsController@index')->name('manage.options.index');
	Route::get('/manage/shop/{shop}/options/create', 'Shop\OptionsController@create')->name('manage.options.create');
	Route::post('/manage/shop/{shop}/options', 'Shop\OptionsController@store')->name('manage.options.store');
	Route::get('/manage/shop/{shop}/options/{option}/edit', 'Shop\OptionsController@edit')->name('manage.options.edit');
	Route::put('/manage/shop/{shop}/options/{option}', 'Shop\OptionsController@update')->name('manage.options.update');
	Route::delete('/manage/shop/{shop}/options/{option}/destroy', 'Shop\OptionsController@destroy')->name('manage.options.destroy');

	// shop-menus
	Route::get('/manage/shop/{shop}/menus', 'Shop\MenusController@index')->name('manage.menus.index');
	Route::get('/manage/shop/{shop}/menus/create', 'Shop\MenusController@create')->name('manage.menus.create');
	Route::post('/manage/shop/{shop}/menus', 'Shop\MenusController@store')->name('manage.menus.store');
	Route::get('/manage/shop/{shop}/menus/{option}/edit', 'Shop\MenusController@edit')->name('manage.menus.edit');
	Route::put('/manage/shop/{shop}/menus/{option}', 'Shop\MenusController@update')->name('manage.menus.update');
	Route::delete('/manage/shop/{shop}/menus/{option}/destroy', 'Shop\MenusController@destroy')->name('manage.menus.destroy');
});