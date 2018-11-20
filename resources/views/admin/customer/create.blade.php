@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel panel-heading" style="font-size: 20px">
                Create customers
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
                        <label>Currency</label>
                        <select class="form-control" name="currency">
                            <option value="ETH">ETH</option>
                            <option value="BTC">BTC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="wallet" placeholder="Enter wallet">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection