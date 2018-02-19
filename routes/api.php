<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/eth', 'Transactions\EthController@getEthTransactions');
Route::get('/btc/{btc_wallet}', 'Transactions\BtcController@getBtcTransactions');
Route::get('/store_btc/{btc_wallet}', 'Transactions\BtcController@storeTxtoDB');
Route::get('/store_eth', 'Transactions\EthController@storeTxtoDB');
Route::get('/currencies', 'Currencies\CurController@getCurrencies');
Route::get('/cur', 'Currencies\CurController@getCur');
Route::get('/sc', 'SmartContract\ScController@getTokenSupply');

