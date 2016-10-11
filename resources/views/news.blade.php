@extends('layouts.webSite');

@section('content')


        <h1>AJAX REQUESTS</h1>

    <button type="button" class="btn btn-primary" id="getRequest">Get Request</button>

    <button type="button" class="btn btn-primary" id="postRequest" value="54">Post Request</button>

    <input type="hidden" id="token" value="{{ csrf_token() }}">

    <div id="fromServer"></div>

@endsection


