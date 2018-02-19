<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
  protected $table = 'customers';

  protected $fillable = [
    'id',
    'name',
    'wallet_currency',
    'wallet',
  ];
}
