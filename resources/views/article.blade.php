@extends('layouts.webSite2');

@section('content')

    {{--Custom Message--}}
    @include('flash::message');

    <div class="container">
        <p style="color:orangered"><a href="/order">Articles</a> / {{ $article->name }}</p>
        <h1 style="color: #1c94c4;">{{ $article->name }}</h1>

        <hr>

        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('images/article/'. $article->image)}}" alt="product" class="img-responsive" style="border:solid 1px #1c94c4;">
            </div>

            <div class="col-md-8">
                <h3>{{ $article->price }} &euro;</h3>


                <form action="{{ url('/storeArticle') }}" method="POST" class="side-by-side">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $article->id }}">
                    <input type="hidden" name="name" value="{{ $article->name }}">
                    <input type="hidden" name="price" value="{{ $article->price }}">

                    Units <input class="numeric" style="width: 50px !important;margin-left: 0px!important;" id="{{$article->id}}" name="units"    min="1"  max="99" maxlength="2"  type="number"  />

                    <input type="submit" class="btn btn-success btn-md" value="Add to Cart">
                </form>



                <br><br>

                <p style="color:orangered;padding:0;padding-left:10px;">  {{$article->description}}   </p>
            </div> <!-- end col-md-8 -->
        </div> <!-- end row -->
    </div>


@endsection