@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Staff Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Staff Id</th>
            <td>{{ $record->staff_id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $record->name }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $record->role }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $record->phone }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $record->email }}</td>
        </tr>
        <tr>
            <th>Is Active</th>
            <td>{{ $record->is_active }}</td>
        </tr>
    </tbody>
</table>
@endsection