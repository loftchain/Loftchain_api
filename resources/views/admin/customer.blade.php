@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <a href="{{ route('admin.customer.create') }}" class="btn btn-primary">Add</a>
        <hr>
    </div>
@endsection