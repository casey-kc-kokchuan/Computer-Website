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
Route::get('/Product/search', 'ProductController@search');
Route::post('/Product/AddProduct', 'ProductController@AddProduct');
Route::post('/Product/RemoveProduct', 'ProductController@RemoveProduct');
Route::post('/Product/AddType', 'ProductController@AddType');
Route::post('/Product/AddBrand', 'ProductController@AddBrand');
Route::post('/Product/DeleteBrand','ProductController@deleteBrand');

Route::get('/check', 'ProductController@check');

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
>>>>>>> 1ae8c77aaeebf36eb793fd0f06c960bfd48d8ce9
