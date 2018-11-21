@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div style="width: 30%; margin: auto">
            <div class="panel panel-default">
                <div class="panel panel-heading" style="font-size: 20px">
                    Create customer
                </div>
                <div class="panel panel-body">
                    <form method="post" action="{{ route('admin.customer.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name">
                        </div>
                        <div class="form-group">
                            <label>Customer ID</label>
                            <input type="text" class="form-control" name="customer_id" value="{{ $customerId }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Wallet ETH</label>
                            <input type="text" class="form-control" name="wallet_eth_currency" value="ETH" readonly>
                            </p>
                            <input type="text" class="form-control" name="wallet_eth" placeholder="Enter ETH wallet">
                        </div>
                        <div class="form-group">
                            <label>Wallet BTC</label>
                            <input type="text" class="form-control" name="wallet_btc_currency" value="BTC" readonly>
                            </p>
                            <input type="text" class="form-control" name="wallet_btc" placeholder="Enter BTC wallet">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection