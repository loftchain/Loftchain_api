<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
  protected $table = 'transactions';

  protected $fillable = [
    'id',
    'customer_id',
    'currency',
    'txId',
    'from',
    'amount',
    'date',
    'status',
  ];
}
