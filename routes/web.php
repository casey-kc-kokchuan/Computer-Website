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


// Admin
Route::get('/Admin', 'PageController@showLogin');
Route::get('/Admin/ProductManager', 'PageController@showProductManager');
Route:: get('/Admin/Account', 'PageController@showAccount');


Route::get('/Test', 'PageController@testGet');
Route::post('/Test', 'PageController@testPost');

/*
--------------------------------------------------------------------------
Product Controller
--------------------------------------------------------------------------
*/
//Route::resource('Admin','ProductController');	

// Route::get('/Admin', function () {
//     return view('Admin.AdminInventory');
// });

Route::get('/check', 'ProductController@check');

Route::get('/Product/search', 'ProductController@search');
Route::post('/Product/AddProduct', 'ProductController@AddProduct');

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

Route::get('Account/ShowAllData', 'AccountController@ShowAllData');
Route::get('Account/Logout', 'AccountController@Logout');

Route::post('Account/Login', 'AccountController@Login');
Route::post('Account/AddAccount', 'AccountController@AddAccount');
Route::post('Account/RemoveAccount', 'AccountController@RemoveAccount');





