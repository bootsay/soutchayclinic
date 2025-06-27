@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Treatment Records</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Record Id</th>
            <th>Appointment Id</th>
            <th>Notes</th>
            <th>Treatment Result</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->record_id }}</td>
            <td>{{ $record->appointment_id }}</td>
            <td>{{ $record->notes }}</td>
            <td>{{ $record->treatment_result }}</td>
            <td>{{ $record->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection