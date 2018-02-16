<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eth extends Model
{
  protected $table = 'ethTx';

  protected $fillable = [
    'id',
    'txId',
    'from',
    'amount',
    'date',
    'status',
  ];
}
