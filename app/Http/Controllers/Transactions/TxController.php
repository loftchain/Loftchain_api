<?php

namespace App\Http\Controllers\Transactions;

use App\Services\Transactions\TxService;
use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class TxController extends Controller
{

  protected $txService;

  public function __construct(TxService $txService)
  {
    $this->txService = $txService;
  }

  public function getWholeTransactions($customer_id){

    return $this->txService->get_wholeTx($customer_id);

  }

}
