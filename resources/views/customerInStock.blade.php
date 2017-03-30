@extends('layouts.webSite2');

@section('content')

   

    <div class="container">
        
        <div style="color:#A1C652;text-align:center;font-weight: bolder;font-size:14px; ">

            <p><i>Brötchen Alarm !</i> </p>
            <img  src="images/wecker31.jpg" />

            <p> Aktueller Vorrat an Brötchen am : </p>
            
            <div id="inStockArticlesDate">{{ $date }}</div>


        </div>
        
        <hr>

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
                                    <h4>InStock:  <span style="color:orangered;padding:0;padding-left:10px;" >{{$article->instock}}</span> </h4>
                                </div>


                            </a>

                            @endforeach

                        </div>
        </div>
        
    </div>
@endsection