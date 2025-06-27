@extends('layouts.report')
@section('content')
<div id="report-title"><h1>Payment Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Payment Id</th>
            <td>{{ $record->payment_id }}</td>
        </tr>
        <tr>
            <th>Appointment Id</th>
            <td>{{ $record->appointment_id }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>{{ $record->amount }}</td>
        </tr>
        <tr>
            <th>Method</th>
            <td>{{ $record->method }}</td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td>{{ $record->payment_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $record->status }}</td>
        </tr>
    </tbody>
</table>
@endsection