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


<<<<<<< HEAD
/*
--------------------------------------------------------------------------
Page Controller
--------------------------------------------------------------------------
*/
Route::get('/', 'PageController@showShoppingCart');
=======
//Route::resource('Admin','ProductController');

Route::get('/Admin', function () {
    return view('Admin.AdminInventory');
});
Route::get('/inventory', 'ProductController@index');
Route::get('/create', 'ProductController@create')->name('create');
Route::get('/edit', 'ProductController@edit')->name('edit');
Route::get('/destroy', 'ProductController@destroy')->name('destroy');

//Route::resource('Customer','ProductController');
>>>>>>> 57a097de873a76103d963223d297e191a395e098

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













