@extends('layouts.webSite2');

@section('content')

    {{--Custom Message--}}
    @include('flash::message');

    <div class="dropdown" style="margin-bottom:15px;">

        <button class="btn btn-info dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Sortiment
            <span class="caret"></span></button>
        <ul class="dropdown-menu list-group" style="color:#1c94c4;" role="menu" >

            @foreach ($sortiments as $sortiment)

                {{--Sortiment-Untergruppen werden eingerückt !--}}

                @if(( $sortiment->group - floor($sortiment->group))  != 0)

                     <li role="presentation" class="list-group-item list-group-item-info"><a role="menuitem" tabindex="-1" href="/order/{{$sortiment->group}}" style="margin-left: 10px">{{$sortiment->name_long}}</a></li>

                @else

                    <li  role="presentation" class="list-group-item list-group-item-info"><a role="menuitem" tabindex="-1"  href="/order/{{$sortiment->group}}" style="text-decoration: underline">{{$sortiment->name_long}}</a></li>

                @endif



            @endforeach


        </ul><span> : {{$actSortiment }}</span><span style="color: orangered;margin-left:10px;font-size: 10px">{{  'KUNDE : ' . $customer}}</span><br><br>
        <a style="font-size:18px " href="{{ url('/cart') }}"><div class="glyphicon glyphicon-shopping-cart" ></div> ({{ Cart::instance('shopping')->count(false) }})</a>


    </div>

            <div id="list" style="max-height: 300px; overflow-y:auto;overflow-x: hidden; " >

                <div class="list-group">

                    @foreach ($articles as $article)


                    <a href="/article/{{ $article->id }}" class="list-group-item row">

                        <div class="col-sm-2 orderRow">

                            <img style="border:solid 1px #1c94c4; " src="{{ asset('images/article/'. $article->image)}}" width="80px" height="70px">

                        </div>

                        <div class="col-sm-5 orderRow">

                                <h4 class="media-heading product_name">{{$article->name}}</h4>

                                <p style="color:orangered;padding:0;padding-left:10px;">  {{$article->description}}   </p>

                        </div>

                        <div class="col-sm-5 orderRow" >

                            <h3>&euro;  {{$article->price}}</h3>

                        </div>


                    </a>

                    @endforeach

                </div>
        </div>

    
@endsection


