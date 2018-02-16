<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Btc extends Model
{
  protected $table = 'btcTx';

  protected $fillable = [
    'id',
    'txId',
    'from',
    'amount',
    'date',
    'status',
  ];
}
