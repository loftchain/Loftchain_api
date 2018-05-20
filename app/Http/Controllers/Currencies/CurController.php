<?php

namespace App\Http\Controllers\Currencies;

use App\Services\Currencies\CurService;
use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class CurController extends Controller
{

  protected $curService;

  public function __construct(CurService $curService)
  {
    $this->curService = $curService;
  }

  public function getCurrencies(){

    return $this->curService->cur_getCurFromDb();

  }

  public function getCur(){
    return $this->curService->cur_recompileAndStoreTx();
  }

}
