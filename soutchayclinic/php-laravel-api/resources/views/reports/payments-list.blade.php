@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Payments</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Payment Id</th>
            <th>Appointment Id</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Payment Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->payment_id }}</td>
            <td>{{ $record->appointment_id }}</td>
            <td>{{ $record->amount }}</td>
            <td>{{ $record->method }}</td>
            <td>{{ $record->payment_date }}</td>
            <td>{{ $record->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection