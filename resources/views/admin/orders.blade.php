@extends('layouts.webSite2');

@section('content')
    {{--Custom Message--}}
    @include('flash::message');

    <h1> <span class="label label-info" >CUSTOMERS ORDERS :</span></h1>

    <div class="container">


        <div class="row">


            {{--Form DeleteButton: wegen Layout--}}
            <form action="{{ url('admin/ordersDeleteUpdate') }}" method="POST" class="form-horizontal">

            <div class="col-sm-7 col-md-6 col-lg-5">

                <div id="adminTableOrders" >

                    <div class='tblHead' style="font-size: small;width: 500px">
                        <div style='width:55px;'>OrderID</div>
                        <div style='width:65px;' >Name</div>
                        <div style='width:170px;' >Date</div>
                        <div style='border-right:1px solid #1c94c4;width:65px;' >Status</div>
                        <div style="border-right:1px solid #1c94c4;width:50px;" >Select</div>
                    </div>




                    <div style=" overflow:auto;height:200px;width:425px;">


                        @foreach ($orders as $order)

                            <div id={{$order->id . "_T"}}  class='tblContent' style="clear:left;">

                                <div id={{$order->id . "_Cl"}}  style='cursor:pointer;width:55px;' onclick="AdminOrdersShowDetails(this.id)" ><input name="{{$order->id}}" value="{{$order->id}}" readonly style="width: 45px;height:17px;font-size: 10px"/></div>
                                <div style='width:65px;font-size: 10px;'> {{$order->name}} </div>
                                <div style='width:170px;font-size: 10px;'> {{$order->order_date}} </div>
                                <div style='border-right:1px solid #1c94c4;width:65px;'>


                                    @if($order->order_status == "DONE")
                                        <select name="{{ "orderStatus_" . $order->id }}" style="font-size:12px;font-weight:bolder;color:#eb8f00;padding:0;">

                                    @else
                                        <select name="{{ "orderStatus_" . $order->id }}" style="font-size:12px;font-weight:bolder;color:#1c94c4;padding:0;">
                                    @endif

                                         <option  style="color:#eb8f00;" value="NEW">NEW</option>

                                         @if($order->order_status == "DONE")
                                             <option  style="color:#eb8f00;" selected="selected" value="DONE">DONE</option> </select>
                                         @else
                                              <option  style="color:#eb8f00;"  value="DONE">DONE</option> </select>

                                         @endif




                                </div>

                                {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}

                                <input type="hidden" value="off"  name="{{ 'check_'. $order->id}}"  />

                                <div style="border-right:1px solid #1c94c4;width:50px;" >&nbsp;&nbsp;&nbsp;<input name="  {{ 'check_'. $order->id}}"  value="on"  type="checkbox" /></div>

                                <div id="{{$order->id}}" style='display:none;width:400px;clear:left;border:none;height:auto'></div>

                            </div>
                        @endforeach

                    </div>   {{-- End Scrolled div--}}
                </div>
            </div>


            <div class="col-sm-5 ">

                <div class="row">

                    <div class="col-sm-3 col-md-2 ">

                            {!! csrf_field() !!}

                            {{--<button type="submit" class="btn btn-info ">DELETE</button>--}}

                        <input type="submit" value="DELETE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />



                    </div>

                    <div class="col-sm-3 col-md-2">


                        {{--<button type="submit" class="btn btn-info ">DELETE</button>--}}

                        <input type="submit" value="UPDATE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />

                        {{-- ordersDelete: openTag am Beginn AdminTableOrders--}}



                    </div>
            </form>


            <div class="col-sm-3 col-md-2" >

                        <form action="{{ url('admin/orders') }}" method="GET" class="form-horizontal">

                            <button type="submit" class="btn btn-xs btn-info" style="margin:5px" >REFRESH</button>

                        </form>

                    </div>

                {{--</div>--}}


                <div class="row">

                    <div class="col-sm-12" >

                        <form action="{{ url('admin/ordersDay') }}" method="POST" class="form-horizontal">


                            {!! csrf_field() !!}

                            <label >Orders eines Tages</label><br>

                            <input type="text" id="datepickerAdmin1" readonly="true" name="datepickerAdmin1" style="width: 200px;">

                            <button type="submit" class="btn btn-xs btn-info">GET</button>

                        </form>



                        <form action="{{ url('admin/ordersArticle') }}" method="POST" class="form-horizontal">

                            {!! csrf_field() !!}

                            <label >Artikelliste eines Tages</label><br>

                            <input type="text" id="datepickerAdmin2" readonly="true" name="datepickerAdmin2" style="width: 200px;">

                            <button type="submit" class="btn btn-xs btn-info">GET</button>


                        </form>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="row  text-center" style="margin-top: 30px;">--}}

        {{----}}

    {{--</div>--}}




    {{--<input type="hidden" id="token" value="{{ csrf_token() }}">--}}

</div>

    </div>
@endsection