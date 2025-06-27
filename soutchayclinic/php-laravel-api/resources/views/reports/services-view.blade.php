@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Service Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Service Id</th>
            <td>{{ $record->service_id }}</td>
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
            <th>Price</th>
            <td>{{ $record->price }}</td>
        </tr>
        <tr>
            <th>Duration Min</th>
            <td>{{ $record->duration_min }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $record->description }}</td>
        </tr>
        <tr>
            <th>Is Active</th>
            <td>{{ $record->is_active }}</td>
        </tr>
    </tbody>
</table>
@endsection