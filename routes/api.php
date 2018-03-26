<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/eth/{eth_wallet}', 'Transactions\EthController@getEthTransactions');
Route::get('/store_eth/{eth_wallet}', 'Transactions\EthController@storeTxtoDB');
Route::get('/btc/{btc_wallet}', 'Transactions\BtcController@getBtcTransactions');
Route::get('/store_btc/{btc_wallet}', 'Transactions\BtcController@storeTxtoDB');
Route::get('/tx/{customer_id}', 'Transactions\TxController@getWholeTransactions');

Route::get('/currencies', 'Currencies\CurController@getCurrencies');
Route::get('/cur', 'Currencies\CurController@getCur');
Route::get('/sc', 'SmartContract\ScController@getTokenSupply');

