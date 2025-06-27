@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Patients</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Patient Id</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->patient_id }}</td>
            <td>{{ $record->full_name }}</td>
            <td>{{ $record->gender }}</td>
            <td>{{ $record->birth_date }}</td>
            <td>{{ $record->phone }}</td>
            <td>{{ $record->email }}</td>
            <td>{{ $record->address }}</td>
            <td>{{ $record->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection