<?php

namespace App\Http\Controllers\Transactions;

use App\Services\Transactions\EthService;
use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class EthController extends Controller
{

  protected $ethService;

  public function __construct(EthService $ethService)
  {
    $this->ethService = $ethService;
  }

  public function getEthTransactions(){

    return $this->ethService->eth_getTxFromDb();

  }
  public function storeTxtoDB(){

    return $this->ethService->eth_recompileAndStoreTx();

  }

}
