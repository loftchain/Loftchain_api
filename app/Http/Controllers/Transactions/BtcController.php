<?php

namespace App\Http\Controllers\Transactions;

use App\Services\Transactions\BtcService;
use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BtcController extends Controller
{
  protected $btcService;

  public function __construct(BtcService $btcService)
  {
      $this->btcService = $btcService;
  }

  public function getBtcTransactions(){

    return $this->btcService->btc_getTxFromDb();

  }
  public function storeTxtoDB(){

    return $this->btcService->btc_recompileAndStoreTx();

  }

}
