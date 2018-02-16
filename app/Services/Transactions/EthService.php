<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
use App\Models\Eth;
use Illuminate\Support\Facades\DB;



class EthService
{


  public function eth_getTx()
  {
    $client = new Client();
    $res = $client->request('GET', 'http://api.etherscan.io/api?module=account&action=txlist&address=' . env('MAIN_ETH') . '&sort=asc&apikey=' . env('ETHERSCAN_API_KEY'));
    $body = json_decode($res->getBody());
    return $body->result;
  }

  public function eth_recompileAndStoreTx()
  {
    $db = [];
    $_eth_divider = 1000000000000000000;

    $transactions = $this->eth_getTx();
    for ($i = 0; $i < count($transactions); $i++) {
      if ($transactions[$i]->value != '0') {
        $date = gmdate("Y-m-d H:i:s", $transactions[$i]->timeStamp);
        $db[] = [
          'txId' => $transactions[$i]->hash,
          'from' => $transactions[$i]->from,
          'amount' => $transactions[$i]->value / $_eth_divider,
          'date' => $date,
          'status' => $transactions[$i]->isError == 1 ? 'false' : 'true',
        ];
      }
    }

    for ($k = 0; $k < count($db); $k++) {
      if (!Eth::where('txId', '=', $db[$k]['txId'])->exists()) {
        Eth::create($db[$k]);
      }
    }
    return $db;
  }

  public function eth_getTxFromDb()
  {
    $txs = DB::table('ethTx')
      ->orderBy('id', 'desc')
      ->get();
    return $txs;

  }

}