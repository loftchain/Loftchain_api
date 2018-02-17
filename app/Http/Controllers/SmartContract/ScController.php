<?php

namespace App\Http\Controllers\SmartContract;

use App\Services\SmartContract\ScService;
use GuzzleHttp\Client;
Use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class ScController extends Controller
{

  protected $scService;

  public function __construct(ScService $scService)
  {
    $this->scService = $scService;
  }

  public function getTokenSupply(){

    return $this->scService->sc_get();

  }

}
