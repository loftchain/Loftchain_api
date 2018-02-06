<?php

namespace App\Http\Controllers\Transactions;

use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class EthController extends Controller
{

  public function __construct()
  {

  }

  public function getTransactions($sc){
    $client = new Client();
    $res = $client->request('GET', 'http://api.etherscan.io/api?module=account&action=txlist&address='. $sc .'&sort=asc&apikey='.env('ETHERSCAN_API_KEY'));
    return $res;

    //TODO: Перенести это в сервис. Огранизовать запись в базу.
  }

}
