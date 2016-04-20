@extends('layouts.webSite');

@section('content')


        <h1>NEWS : Customers Table</h1>
        <!-- Table-to-load-the-data Part -->
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
            </thead>
            <tbody id="users-list" name="users-list">
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->password}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>



@endsection


