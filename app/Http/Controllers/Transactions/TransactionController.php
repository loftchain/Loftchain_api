<?php

namespace App\Http\Controllers\Transactions;

use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{

  public function __construct()
  {

  }

  public function getBtcTransactions($btc_wallet){
    $client = new Client(['Accept' => 'application/json']);;
    $res = $client->request('GET', 'https://block.io/api/v2/get_transactions/?api_key='. env('BLOCKIO_API_BTC') .'&type=received&addresses='.$btc_wallet);
    $body =  json_decode($res->getBody());
    return response()->json($body->data->txs);

    //TODO: Перенести это в сервис. Огранизовать запись в базу.
  }

}
