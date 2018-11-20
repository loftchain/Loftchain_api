<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currencies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('admin.currency');
    }

    public function get()
    {
        return Currencies::all();
    }
}
