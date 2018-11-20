@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <a style="margin-left: 20%" href="{{ route('admin.customer.create') }}" class="btn btn-primary">Add</a>
        <customer-table></customer-table>
    </div>
@endsection