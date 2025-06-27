@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Patient Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Patient Id</th>
            <td>{{ $record->patient_id }}</td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td>{{ $record->full_name }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $record->gender }}</td>
        </tr>
        <tr>
            <th>Birth Date</th>
            <td>{{ $record->birth_date }}</td>
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
            <th>Address</th>
            <td>{{ $record->address }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $record->created_at }}</td>
        </tr>
    </tbody>
</table>
@endsection