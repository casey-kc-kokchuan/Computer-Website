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



/*
--------------------------------------------------------------------------
Page Controller
--------------------------------------------------------------------------
*/

// Customer
Route::get('/', 'PageController@showShoppingCart');
Route::get('/VerifyOrderEmail', 'PageController@showVerifyOrderEmail');


 
// Admin
Route::group(['prefix' => '/Admin', 'middleware' => ['auth']], function()
	{
		Route::get('/ProductManager', 'PageController@showProductManager')->middleware('role:Admin|Store Manager|Product Manager');
		Route::get('/Account', 'PageController@showAccount')->middleware('role:Admin|Store Manager');
		Route::get('/OrderManager', 'PageController@showOrderManager');
		Route::get('/Home', 'PageController@showHome');
	});

Route::get('/Admin', 'PageController@showLogin');
Route::get('/Admin/ChangePasswordRequest', 'PageController@showChangePasswordRequest');


/*
--------------------------------------------------------------------------
Product Controller
--------------------------------------------------------------------------
*/


Route::get('/Product/search', 'ProductController@search');

Route::group(['prefix' => 'Product', 'middleware' => ['auth','role:Admin|Store Manager|Product Manager']], function()
{
	Route::post('/AddProduct', 'ProductController@AddProduct');
	Route::post('/EditProduct', 'ProductController@EditProduct');
	Route::post('/RemoveProduct', 'ProductController@RemoveProduct');
	Route::post('/AddType', 'ProductController@AddType');
	Route::post('/DeleteType', 'ProductController@DeleteType');
	Route::post('/AddBrand', 'ProductController@AddBrand');
	Route::post('/DeleteBrand','ProductController@DeleteBrand');

});



Route::get('/check', 'ProductController@check');

 
/*
--------------------------------------------------------------------------
Order Controller
--------------------------------------------------------------------------
*/



Route::group(['prefix' => '/Order'], function()
{
	Route::get('/ConfirmOrder', 'OrderController@ConfirmOrder');
	Route::get('/ShowOrder', 'OrderController@ShowOrder');
	Route::post('/PlaceOrder', 'OrderController@PlaceOrder');
	Route::post('/UpdateOrderStatus', 'OrderController@UpdateOrderStatus');
});

/*
--------------------------------------------------------------------------
Account Controller
--------------------------------------------------------------------------
*/

Route::group(['prefix' => '/Account', 'middleware' => ['auth','role:Admin|Store Manager']], function()
{
	Route::get('/ShowAllData', 'AccountController@ShowAllData');
	Route::post('/AddAccount', 'AccountController@AddAccount');
	Route::post('/EditAccount', 'AccountController@EditAccount');
	Route::post('/RemoveAccount', 'AccountController@RemoveAccount');
});


Route::get('/Account/Logout', 'AccountController@Logout')->middleware('auth');
Route::get('/Account/VerifyChangePasswordRequest', 'AccountController@VerifyChangePasswordRequest');
Route::post('/Account/ChangePassword', 'AccountController@ChangePassword');
Route::post('/Account/ChangePasswordRequest', 'AccountController@ChangePasswordRequest');
Route::post('/Account/Login', 'AccountController@Login');
