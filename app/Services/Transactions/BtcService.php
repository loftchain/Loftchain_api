<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Btc;

class BtcService
{

  public function getTx($btc_wallet)
  {
    $client = new Client();
    $res = $client->request('GET', 'https://block.io/api/v2/get_transactions/?api_key=' . env('BLOCKIO_API_BTC') . '&type=received&before_tx&addresses=' . $btc_wallet);
    $body = json_decode($res->getBody());
    return $body->data->txs;
  }

  public function storeTxtoDB($btc_wallet)
  {
    $transactions = $this->getTx($btc_wallet);

    for($i=0; $i<=count($transactions)-1; $i++) {
      $date = gmdate("Y-m-d H:i:s", $transactions[$i]->time);
      if (!Btc::where('txId', '=', $transactions[$i]->txid)->exists()) {
        $db = [
          'txId' => $transactions[$i]->txid,
          'from' => $transactions[$i]->senders[0],
          'amount' => $transactions[$i]->amounts_received[0]->amount,
          'date' => $date,
          'status' => $transactions[$i]->confidence == 1 ? 'true' : 'false',
        ];
        Btc::create($db);
      }
    }
  }

}

//TODO: Придумать систему при которой будут подгружаться следующие 25 транзакций
//TODO: вывод транзакций из базы в апи
//TODO: Сделать тоже самое для ETH
//TODO: Крон