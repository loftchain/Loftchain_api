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

    public function get()
    {
        return Customers::all();
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
        Customers::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'wallet_currency' => $request->currency,
            'wallet' => $request->wallet
        ]);

        return redirect()->route('admin.customer');
    }


    public function getCustomerName()
    {
        return Customers::all()->unique('name');
    }
}
