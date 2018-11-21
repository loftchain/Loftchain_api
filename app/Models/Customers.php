<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'id',
        'customer_id',
        'name',
        'wallet_currency',
        'wallet',
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'customer_id', 'customer_id');
    }
}
