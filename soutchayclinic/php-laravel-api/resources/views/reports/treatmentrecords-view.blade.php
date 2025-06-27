@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Treatment Record Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Record Id</th>
            <td>{{ $record->record_id }}</td>
        </tr>
        <tr>
            <th>Appointment Id</th>
            <td>{{ $record->appointment_id }}</td>
        </tr>
        <tr>
            <th>Notes</th>
            <td>{{ $record->notes }}</td>
        </tr>
        <tr>
            <th>Treatment Result</th>
            <td>{{ $record->treatment_result }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $record->created_at }}</td>
        </tr>
    </tbody>
</table>
@endsection