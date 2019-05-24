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

//Route::resource('Admin','ProductController');

Route::get('/Admin', function () {
    return view('Admin.AdminInventory');
});
Route::get('/inventory', 'ProductController@index');
Route::get('/create', 'ProductController@create')->name('create');
Route::get('/edit', 'ProductController@edit')->name('edit');
Route::get('/destroy', 'ProductController@destroy')->name('destroy');

//Route::resource('Customer','ProductController');


// Route::get('/Admin/show', 'ProductController@index');

Route::get('/check', 'ProductController@check');


Route::get('/ShoppingCart', function ()
{
	return view('Customer/ShoppingCart');
});

Route::get('/Product/search', 'ProductController@search');

