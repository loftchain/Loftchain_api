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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix => admin', 'as' => 'admin.', 'middleware' => ['auth']], function (){
   Route::get('transactions', 'Admin\TransactionController@index')->name('transaction');
   Route::get('transactions/get', 'Admin\TransactionController@get')->name('transaction.get');
   Route::get('currencies', 'Admin\CurrencyController@index')->name('currency');
   Route::get('currencies/get', 'Admin\CurrencyController@get')->name('currency.get');
   Route::get('customer', 'Admin\CustomerController@index')->name('customer');
   Route::get('customer/get', 'Admin\CustomerController@get')->name('customer.get');
   Route::get('customer/get/name', 'Admin\CustomerController@getCustomerName')->name('customer.get.name');
   Route::get('customer/create', 'Admin\CustomerController@create')->name('customer.create');
   Route::post('customer/create', 'Admin\CustomerController@store')->name('customer.store');
});