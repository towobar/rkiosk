@extends('layouts.webSite2');

@section('content')
    {{--Custom Message--}}
    @include('flash::message');

    <h1> <span class="label label-info" >CUSTOMERS ORDERS :</span></h1>

    <div class="container">

        <div class="row">

            <div class="col-sm-6">

                <div id="adminTableOrders" >

                    <div class='tblHead'>
                        <div>OrderID</div><div>Name</div>
                        <div style='width:170px;' >Date</div>
                        <div style='border-right:1px solid #1c94c4;width:65px;' >Status</div>
                    </div>


                @foreach ($orders as $order)

                    <div id={{$order->id . "_T"}}  class='tblContent' style="clear:left">

                        <div id={{$order->id . "_Cl"}} style='cursor:pointer' > {{$order->id}} </div>
                        <div> {{$order->name}} </div>
                        <div style='width:170px;'> {{$order->order_date}} </div>
                        <div style='border-right:1px solid #1c94c4;width:65px;'>INIT</div>

                        <div id={{$order->id}} style='display:none;width:400px;clear:left;border:none;height:auto'></div>

                    </div>
                @endforeach

                </div>
            </div>

            <div class="col-sm-6">

                <form action="{{ url('admin/ordersDay') }}" method="POST" class="form-horizontal">


                    {!! csrf_field() !!}

                    <label >Orders eines Tages</label><br>

                    <input type="text" id="datepickerAdmin1" readonly="true" name="datepickerAdmin1" style="width: 200px;">

                    <button type="submit" class="btn btn-info">GET</button>

                </form>

                <form action="{{ url('admin/orders') }}" method="GET" class="form-horizontal">

                    <button type="submit" class="btn btn-info">REFRESH</button>

                </form>



                <form action="{{ url('admin/ordersArticle') }}" method="POST" class="form-horizontal">

                    {!! csrf_field() !!}

                    <label >Artikelliste eines Tages</label><br>

                    <input type="text" id="datepickerAdmin2" readonly="true" name="datepickerAdmin2" style="width: 200px;">

                    <button type="submit" class="btn btn-info">GET</button>


                </form>
            </div>

        </div>
    </div>

    {{--<div class="row  text-center" style="margin-top: 30px;">--}}

        {{----}}

    {{--</div>--}}




    {{--<input type="hidden" id="token" value="{{ csrf_token() }}">--}}


@endsection