<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customer');
    }

    public function create()
    {
        $customer = Customers::all();
        $lastCustomerId = $customer->last() ? $customer->last()->customer_id + 1 : 1;

        return view('admin.customer.create', [
            'customerId' => $lastCustomerId
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
//        Customers::create()
    }
}
