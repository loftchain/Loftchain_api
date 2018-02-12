<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;


class EthService
{

  public function getTx($eth_smartcontract){
      $client = new Client();
      $res = $client->request('GET', 'http://api.etherscan.io/api?module=account&action=txlist&address='. $eth_smartcontract .'&sort=asc&apikey='.env('ETHERSCAN_API_KEY'));
      return $res;
  }

}