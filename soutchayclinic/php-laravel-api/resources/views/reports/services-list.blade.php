@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Services</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Service Id</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Duration Min</th>
            <th>Description</th>
            <th>Is Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->service_id }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->category }}</td>
            <td>{{ $record->price }}</td>
            <td>{{ $record->duration_min }}</td>
            <td>{{ $record->description }}</td>
            <td>{{ $record->is_active }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection