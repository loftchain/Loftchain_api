<?php

namespace App\Services\Currencies;

use GuzzleHttp\Client;
use App\Models\Cur;
use Illuminate\Support\Facades\DB;

class CurService
{


  public function cur_get()
  {
    $client = new Client();
    $res1 = $client->request('GET', 'https://min-api.cryptocompare.com/data/pricemulti?fsyms='.env('CURRENCIES').'&tsyms=USD');
    $res2 = $client->request('GET', 'https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms='.env('CURRENCIES'));
    $body1 = json_decode($res1->getBody());
    $body2 = json_decode($res2->getBody());
    return [$body1, $body2];
  }

  public function cur_recompileAndStoreTx()
  {
    $db = [];
      $currencies = $this->cur_get();
      for ($i = 0; $i < count($currencies); $i++) {
//        $date = gmdate("Y-m-d H:i:s", now());
//        if ($newTx != $transactions[$i]->txid) {
//          $db[] = [
//            'txId' => $transactions[$i]->txid,
//            'from' => $transactions[$i]->senders[0],
//            'amount' => $transactions[$i]->amounts_received[0]->amount,
//            'date' => $date,
//            'status' => $transactions[$i]->confidence == 1 ? 'true' : 'false',
//          ];
       }
       foreach ($currencies[0] as $k=>$v){
         $db[] = [
           'pair' => $k.'/'.$v,
         ];
       }
    print_r($db);
//        $newTx = $transactions[$i]->txid;
//      }
//      $latest_tx = '=' . $transactions[count($transactions) - 1]->txid;
//
//    for ($k = 0; $k < count($db); $k++){
//      if (!Btc::where('txId', '=', $db[$k]['txId'])->exists()) {
//        Btc::create($db[$k]);
//      }
//    }
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