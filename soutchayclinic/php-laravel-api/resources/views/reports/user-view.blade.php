@extends('layouts.report')
@section('content')
<div id="report-title"><h1>User Details</h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Userid</th>
            <td>{{ $record->userid }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $record->username }}</td>
        </tr>
        <tr>
            <th>Displayname</th>
            <td>{{ $record->displayname }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $record->email }}</td>
        </tr>
        <tr>
            <th>Phonenumber</th>
            <td>{{ $record->phonenumber }}</td>
        </tr>
        <tr>
            <th>User Role Id</th>
            <td>{{ $record->user_role_id }}</td>
        </tr>
    </tbody>
</table>
@endsection