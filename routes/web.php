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
    return view('Customer/CustomerPage');
});


Route::get('/Admin', function () {
    return view('Admin/AdminPage');
});

// Route::get('/Admin/show', 'ProductController@index');




Route::get('/ShoppingCart', function ()
{
	return view('Customer/ShoppingCart');
});

Route::get('/Product/search', 'ProductController@search');

