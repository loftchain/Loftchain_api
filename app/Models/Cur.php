<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cur extends Model
{
  protected $table = 'currencies';

  protected $fillable = [
    'id',
    'pair',
    'price',
    'timestamp',
  ];
}
