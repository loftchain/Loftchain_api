<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transaction');
    }

    public function get()
    {
        return Transactions::all();
    }
}
