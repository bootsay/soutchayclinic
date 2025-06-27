@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Product Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Product Id</th>
            <td>{{ $record->product_id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $record->name }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $record->category }}</td>
        </tr>
        <tr>
            <th>Stock Quantity</th>
            <td>{{ $record->stock_quantity }}</td>
        </tr>
        <tr>
            <th>Cost Price</th>
            <td>{{ $record->cost_price }}</td>
        </tr>
        <tr>
            <th>Sale Price</th>
            <td>{{ $record->sale_price }}</td>
        </tr>
    </tbody>
</table>
@endsection