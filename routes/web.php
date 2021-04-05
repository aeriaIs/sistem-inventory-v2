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
    return view('dashboard');
});


Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/supplier', 'SupplierController');
Route::resource('/product', 'ProductController');
Route::resource('/order', 'OrderController');
Route::get('/order/product/{supplier}', 'OrderController@getProduct')->name('order.product');
Route::patch('/order/approve/{id}', 'OrderController@approve')->name('order.approve');
Route::post('/order/add-item/{id}', 'OrderController@addItem')->name('order.add-item');
Route::delete('/order/delete-item/{id}', 'OrderController@deleteItem')->name('order.delete-item');
Route::patch('/order/update-qty/{id}', 'OrderController@updateQty')->name('order.update-qty');

//Manage GoodReceipt
Route::resource('/good-receipt', 'GoodReceiptController');
Route::patch('/good-receipt/approve/{id}', 'GoodReceiptController@approve')->name('good-receipt.approve');

Auth::routes();