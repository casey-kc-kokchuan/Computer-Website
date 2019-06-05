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
Route::get('/', 'PageController@showShoppingCart');
Route::get('/Admin/ProductManager', 'PageController@showProductManager');
Route::get('/Test', 'PageController@testGet');
Route::post('/Test', 'PageController@testPost');

/*
--------------------------------------------------------------------------
Product Controller
--------------------------------------------------------------------------
*/
//Route::resource('Admin','ProductController');

Route::get('/Admin', function () {
    return view('Admin.AdminInventory');
});

Route::get('/check', 'ProductController@check');

Route::get('/Product/search', 'ProductController@search');
Route::post('/Product/AddProduct', 'ProductController@AddProduct');
Route::post('/Product/AddType', 'ProductController@AddType');
Route::post('/Product/AddBrand', 'ProductController@AddBrand');
Route::post('/Product/DeleteBrand','ProductController@DeleteBrand');


Route::get('/inventory', 'ProductController@index');
Route::get('/create', 'ProductController@create')->name('create');
Route::get('/edit', 'ProductController@edit')->name('edit');
Route::get('/destroy', 'ProductController@destroy')->name('destroy');
/*
--------------------------------------------------------------------------
Order Controller
--------------------------------------------------------------------------
*/


/*
--------------------------------------------------------------------------
Account Controller
--------------------------------------------------------------------------
*/
