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

Route::get('/eth/{sc}', 'Transactions\EthController@getEthTransactions');
Route::get('/btc', 'Transactions\BtcController@getBtcTransactions');
Route::get('/store_btc/{btc_wallet}', 'Transactions\BtcController@storeTxtoDB');

