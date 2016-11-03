@extends('layouts.webSite2');

@section('content')

    <h1> <span class="label label-info " >CUSTOMER NEWS PAGE</span></h1>

    <div id="listGroup" class="list-group">

        @foreach ($messages as $message)


            <a href="#" class="list-group-item row" >

                <div style="color:#1c94c4;font-weight:bolder">{{$message->date}}</div>
                <div class="row">

                    <div class="col-sm-6" style="color:orangered;font-weight:bolder">{{$message->head}}</div>
                    <div class="col-sm-1" style="float:left" ><button  type="button" id="{{$message->id }}" class="btn btn-xs btn-info" onclick="CustomerNewsOpenContent(this.id)">OPEN</button></div>
                </div>

                <div id="{{$message->id . '_C'}}" style=" color:#1c94c4;background-color:white;display:none;border-radius:4px;border : 1px solid #1c94c4;padding:5px;margin-top:5px">{!!$message->content!!}</div>
            </a>

        @endforeach

    </div>


@endsection