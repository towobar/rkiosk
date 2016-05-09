@extends('layouts.webSite2');

@section('content')

    {{--Custom Message--}}
    @include('flash::message');



    <div class="dropdown" style="margin-bottom:15px;">
        <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Sortiment
            <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu" >

            @foreach ($sortiments as $sortiment)

                {{--Sortiment-Untergruppen werden eingerückt !--}}

                @if(( $sortiment->group - floor($sortiment->group))  != 0)

                     <li role="presentation"><a role="menuitem" tabindex="-1" href="/order/{{$sortiment->group}}" style="margin-left: 10px">{{$sortiment->name_long}}</a></li>

                @else

                    <li  role="presentation"><a role="menuitem" tabindex="-1"  href="/order/{{$sortiment->group}}" style="text-decoration: underline">{{$sortiment->name_long}}</a></li>

                @endif



            @endforeach


        </ul><span> : {{$actSortiment }}</span>
    </div>





        <form action="{{ url('order') }}" method="POST" class="form-horizontal">


            {!! csrf_field() !!}

            <div id="list" style="max-height: 300px; overflow-y:auto;overflow-x: hidden; " >



            <div class="list-group">

                @foreach ($articles as $article)


                <a href="#" class="list-group-item row">

                    <div class="col-sm-2 orderRow">
                        <img style="border:solid 1px #1c94c4; " src="{{ asset('images/article/'. $article->image)}}" width="80px" height="70px">
                    </div>

                    <div class="col-sm-5 orderRow">


                            <h4 class="media-heading product_name">{{$article->name}}</h4>

                            <p style="color:orangered;padding:0;padding-left:10px;">  {{$article->description}}   </p>


                    </div>

                    <div class="col-sm-3 orderRow" >

                        {{--Stück ( {{$article->price}} Euro )--}}

                        Stück <input style="width: 60px !important;margin-left: 0px!important;" type="text" readonly name="  {{ 'price_'. $article->id}}" value="{{$article->price}}"> Euro

                    </div>


                    <div class="col-sm-2 orderRow" >

                     Units <input style="width: 50px !important;margin-left: 0px!important;" id="{{$article->id}}" name="{{ 'units_' . $article->id}}"    min="1"  max="99" maxlength="2"  type="number">

                    </div>

                    {{--<div class="col-sm-1 orderRow" >--}}
                        {{--<label class="checkbox-inline">--}}
                            {{--<input type="checkbox" name="{{ 'selected_' . $article->id }}" value="{{ $article->id}}"> Select--}}
                        {{--</label>--}}
                    {{--</div>--}}
                </a>

                @endforeach

            </div>
        </div>


            <div class="row  text-center" style="margin-top: 30px;">

                <label for="datepicker">OrderDate:</label>

                <input type="text" id="datepicker" name="datepicker" style="width: 200px;">

                <button type="submit" class="btn btn-default">Order</button>





            </div>



            {{--@include('partials.datepicker')--}}





        </form>


        {{--<input type="hidden" id="token" value="{{ csrf_token() }}">--}}

        {{--<div class="row  text-center" style="margin-top: 20px;">--}}
          {{--<input type="button" class="btn btn-primary" value="Order" id="order"  />--}}
        {{--</div>--}}

        {{--<a href="#" id="try" data-link="{{ url('/order') }}">Try</a>--}}
    
@endsection


