<?php

namespace App\Services\Transactions;

use GuzzleHttp\Client;
use App\Models\Transactions;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;

class TxService
{


  public function get_wholeTx($customer_id)
  {
    return Transactions::where('customer_id', $customer_id)->get();
  }

}