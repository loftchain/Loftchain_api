<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Register;
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
        if ($request->wallet_eth && !$request->wallet_btc) {
            $this->storeCustomers($request, $request->wallet_eth_currency, $request->wallet_eth);
        } elseif ($request->wallet_btc && !$request->wallet_eth) {
            $this->storeCustomers($request, $request->wallet_btc_currency, $request->wallet_btc);
        } else {
            foreach ($request->all() as $key => $item) {
                if ($key === 'wallet_eth_currency') {
                    $this->storeCustomers($request, $request->wallet_eth_currency, $request->wallet_eth);
                } elseif ($key === 'wallet_btc_currency') {
                    $this->storeCustomers($request, $request->wallet_btc_currency, $request->wallet_btc);
                }
            }
        }

        return redirect()->route('admin.customer');
    }


    public function getCustomerName()
    {
        return Customers::all()->unique('name');
    }

    public function storeCustomers(Request $request, $currency, $wallet)
    {
        Customers::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'wallet_currency' => $currency,
            'wallet' => $wallet
        ]);
    }
}
