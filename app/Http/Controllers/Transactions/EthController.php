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

  public function getEthTransactions($eth_wallet){

    return $this->ethService->eth_getTxFromDb($eth_wallet);

  }
  public function storeTxtoDB($eth_wallet){

    return $this->ethService->eth_recompileAndStoreTx($eth_wallet);

  }

}
