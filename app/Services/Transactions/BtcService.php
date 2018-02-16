<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
use App\Models\Btc;
use Illuminate\Support\Facades\DB;

class BtcService
{

  protected function btc_numberOfInputTransactions()
  {
    $client = new Client();
    $res = $client->request('GET', 'https://chain.so/api/v2/address/BTC/' . env('MAIN_BTC'));
    $body = json_decode($res->getBody());
    return $body->data->total_txs;
  }

  protected function btc_getTx($latest_tx)
  {
    $client = new Client();
    $res = $client->request('GET', 'https://block.io/api/v2/get_transactions/?api_key=' . env('BLOCKIO_API_BTC') . '&type=received&addresses=' . env('MAIN_BTC') . '&before_tx' . $latest_tx);
    $body = json_decode($res->getBody());
    return $body->data->txs;
  }

  public function btc_recompileAndStoreTx()
  {

    $db = [];
    $tx_num = $this->btc_numberOfInputTransactions();
    $iterator = (int)ceil($tx_num / 25); // Сколько раз нужно собрать по 25 транзакций. Транзакции выдаются только по 25 штук, при текущем API.
    $latest_tx = '';
    $newTx = '';

    for ($j = 0; $j < $iterator; $j++) {
      $transactions = $this->btc_getTx($latest_tx);
      for ($i = 0; $i < count($transactions); $i++) {
        $date = gmdate("Y-m-d H:i:s", $transactions[$i]->time);
        if ($newTx != $transactions[$i]->txid) {
          $db[] = [
            'txId' => $transactions[$i]->txid,
            'from' => $transactions[$i]->senders[0],
            'amount' => $transactions[$i]->amounts_received[0]->amount,
            'date' => $date,
            'status' => $transactions[$i]->confidence == 1 ? 'true' : 'false',
          ];
        }
        $newTx = $transactions[$i]->txid;
      }
      $latest_tx = '=' . $transactions[count($transactions) - 1]->txid;
    }

    for ($k = 0; $k < count($db); $k++){
      if (!Btc::where('txId', '=', $db[$k]['txId'])->exists()) {
        Btc::create($db[$k]);
      }
    }
    //return $db;
  }

  public function btc_getTxFromDb()
  {
    $txs = DB::table('btcTx')
      ->orderBy('id', 'desc')
      ->get();
    return $txs;

  }

  public function btc_cronProcess($btc_wallet)
  {


  }


}

//TODO: вывод транзакций из базы в апи
//TODO: Сделать тоже самое для ETH
//TODO: Крон