@extends('layouts.report')
@section('content')
<div id="report-title"><h1>User</h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Userid</th>
            <th>Username</th>
            <th>Displayname</th>
            <th>Email</th>
            <th>Phonenumber</th>
            <th>User Role Id</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->userid }}</td>
            <td>{{ $record->username }}</td>
            <td>{{ $record->displayname }}</td>
            <td>{{ $record->email }}</td>
            <td>{{ $record->phonenumber }}</td>
            <td>{{ $record->user_role_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection