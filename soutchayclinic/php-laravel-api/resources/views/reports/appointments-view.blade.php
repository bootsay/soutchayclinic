@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Appointment Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Appointment Id</th>
            <td>{{ $record->appointment_id }}</td>
        </tr>
        <tr>
            <th>Patient Id</th>
            <td>{{ $record->patient_id }}</td>
        </tr>
        <tr>
            <th>Service Id</th>
            <td>{{ $record->service_id }}</td>
        </tr>
        <tr>
            <th>Staff Id</th>
            <td>{{ $record->staff_id }}</td>
        </tr>
        <tr>
            <th>Appointment Date</th>
            <td>{{ $record->appointment_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $record->status }}</td>
        </tr>
        <tr>
            <th>Notes</th>
            <td>{{ $record->notes }}</td>
        </tr>
    </tbody>
</table>
@endsection