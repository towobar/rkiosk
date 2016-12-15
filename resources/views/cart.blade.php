@extends('layouts.webSite2');

@section('content')

    {{--Custom Message--}}
    @include('flash::message');

    <h1> <span class="label label-info " >SHOPPING - CART</span></h1>

    <div id="list" style="max-height: 300px; overflow-y:auto;overflow-x: hidden; " >

        <div class="list-group">

            @foreach (Cart::instance('shopping')->content() as $row)

                <a href="#" class="list-group-item row">

                    <div class="col-sm-2 orderRow">
                        <img style="border:solid 1px #1c94c4; " src="{{ asset('images/article/'. 'Schrippe.jpg')}}" width="80px" height="70px">
                    </div>

                    <div class="col-sm-5 orderRow">


                        <h4 class="media-heading product_name">{{$row->name}}</h4>

                        <p style="color:orangered;padding:0;padding-left:10px;">  {{'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et'}}   </p>


                    </div>

                    <div class="col-sm-2 orderRow" >


                      <h3>&euro;  {{$row->price}}</h3>

                    </div>


                    <div class="col-sm-1 orderRow" >

                        Units <input style="width: 50px !important;margin-left: 0px!important;" class="quantity" data-id="{{ $row->rowId }}" type="number" maxlength="2"   value="{{$row->qty}}" />

                    </div>


                    <div class="col-sm-1 orderRow" >

                        Subtotal {!! '<br>' . '<h4>&euro;' . $row->subtotal .'</h4>' !!}

                    </div>

                    <div class="col-sm-1 orderRow" >

                        <form action="/cartRemove/{{$row->rowId}}" method="GET" class="side-by-side">

                            <input type="submit" class="btn btn-danger btn-sm" value="Remove">

                        </form>


                    </div>

                </a>

            @endforeach
        </div>

    </div>


    <div class="row" style="margin-top:20px;margin-left:10px;">

        <form action="{{ url('/cartCheckout') }}" method="POST">

            {!! csrf_field() !!}

            <div class="col-sm-3 orderRow" >

                <a href="{{ url('/order') }}" class="btn btn-primary btn-md">Continue Shopping</a>

            </div>

            <div class="col-sm-2 orderRow" >

                <input type="submit" class="btn btn-success btn-md" value="Checkout">

            </div>

            <div class="col-sm-2 orderRow" >

                <h4>{!! 'TOTAL : '. '<span id="cartTotal">' . Cart::instance('shopping')->total() .'</span>' !!}</h4>

            </div>

            <div class="col-sm-5 orderRow" >

                <label for="datepicker">DATE:</label>

                <input type="text" id="datepicker" readonly="true" name="datepicker" style="width: 200px;">

            </div>

        </form>



    </div>

    <div class="row" style="margin-top:10px;margin-left:10px;">

        <div class="col-sm-12 orderRow" >
            <form action="{{ url('/emptyCart') }}" method="POST">

                {!! csrf_field() !!}

                <input type="submit" class="btn btn-danger btn-md " value="Empty Cart">

            </form>
        </div>
    </div>

@endsection

@section('extra-js')
    <script>
        (function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.quantity').on('change', function() {

                var id = $(this).attr('data-id')

                $.ajax({
                    type: "POST",
                    url: 'cartQuantity',

                    // Wird hier nicht benötigt, da die Seite neu geladen wird !
                    data: {
                        'quantity': this.value,
                        'rowId' : id
                    },
                    success: function(data) {

                       window.location = 'cart';
                    },
                    error: function (data) {

                        console.log('Error:', data);

                    }

                });

            });

        })();

    </script>
@endsection
