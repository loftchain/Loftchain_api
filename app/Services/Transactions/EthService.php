<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
use App\Models\Transactions;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;

class EthService
{


  public function eth_getTx($eth_wallet)
  {
    $client = new Client();
    $res = $client->request('GET', 'http://api.etherscan.io/api?module=account&action=txlist&address=' . $eth_wallet . '&sort=asc&apikey=' . env('ETHERSCAN_API_KEY'));
    $body = json_decode($res->getBody());
    return $body->result;
  }

  public function eth_recompileAndStoreTx($eth_wallet)
  {
    $db = [];
    $_eth_divider = 1000000000000000000;
    $customer = Customers::where('wallet', $eth_wallet)->first();

    if (!$customer) {
      return response()->json(['response' => 'customer with such wallet does not exist']);
    }

    $transactions = $this->eth_getTx($eth_wallet);
    for ($i = 0; $i < count($transactions); $i++) {
      if ($transactions[$i]->value != '0') {
        $date = gmdate("Y-m-d H:i:s", $transactions[$i]->timeStamp);
        $db[] = [
          'txId' => $transactions[$i]->hash,
          'customer_id' => $customer['customer_id'],
          'currency' => $customer['wallet_currency'],
          'from' => $transactions[$i]->from,
          'amount' => $transactions[$i]->value / $_eth_divider,
          'date' => $date,
          'status' => $transactions[$i]->isError == 1 ? 'false' : 'true',
        ];
      }
    }

    for ($k = 0; $k < count($db); $k++) {
      if (!Transactions::where('txId', '=', $db[$k]['txId'])->exists()) {
        Transactions::create($db[$k]);
      }
    }
    return $db;
  }

  public function eth_getTxFromDb($eth_wallet)
  {
    $customer = Customers::where('wallet', $eth_wallet)->first();
    $txs = Transactions::where('customer_id', $customer['customer_id'])->where('currency', 'ETH')->orderBy('date', 'desc')->get();

    if (!$customer) {
      return response()->json(['response' => 'Customer with such wallet does not exist']);
    }

    if (!$txs) {
      return response()->json(['response' => 'This address does not yet have any transactions']);
    }

    return $txs;

  }

}