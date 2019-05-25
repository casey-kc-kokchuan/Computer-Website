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

/*
--------------------------------------------------------------------------
Product Controller
--------------------------------------------------------------------------
*/
Route::resource('Admin','ProductController');	

Route::get('/check', 'ProductController@check');

Route::get('/Product/search', 'ProductController@search');
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













