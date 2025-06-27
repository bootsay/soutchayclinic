@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Staff</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Staff Id</th>
            <th>Name</th>
            <th>Role</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Is Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->staff_id }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->role }}</td>
            <td>{{ $record->phone }}</td>
            <td>{{ $record->email }}</td>
            <td>{{ $record->is_active }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection