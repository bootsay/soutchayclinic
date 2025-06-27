@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Appointments</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Appointment Id</th>
            <th>Patient Id</th>
            <th>Service Id</th>
            <th>Staff Id</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->appointment_id }}</td>
            <td>{{ $record->patient_id }}</td>
            <td>{{ $record->service_id }}</td>
            <td>{{ $record->staff_id }}</td>
            <td>{{ $record->appointment_date }}</td>
            <td>{{ $record->status }}</td>
            <td>{{ $record->notes }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection