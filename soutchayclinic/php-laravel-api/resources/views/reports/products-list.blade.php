@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Products</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Product Id</th>
            <th>Name</th>
            <th>Category</th>
            <th>Stock Quantity</th>
            <th>Cost Price</th>
            <th>Sale Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->product_id }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->category }}</td>
            <td>{{ $record->stock_quantity }}</td>
            <td>{{ $record->cost_price }}</td>
            <td>{{ $record->sale_price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection