@extends('layouts.webSite2');

@section('content')

    {{--Custom Message--}}
    @include("flash::message");


    <h1> <span class="label label-info " > ADMIN NEWS PAGE</span></h1>

    <div class="container">


        <div class="row">

            <div class="col-sm-6" >

                <form action="{{ url("admin/news/newMessage") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}

                    <table>
                        <tr><td><h6>HEAD</h6></td><td><input id='newsAdminHead' name="newsHead" type='text' style='width:300px' ></td></tr>

                       {{--Achtung Styles für  Markitup-Editor in : css/Markitup/skins/markitup/style.ccs--}}

                        <tr><td><h6>CONTENT</h6></td><td><textarea id='newsAdminContent' name="newsContent"  style='width:300px;height:200px;resize:none;z-index:100'></textarea></td></tr>
                        <tr><td><h6>DATUM</h6></td><td><input type='text' name="newsDate" value='Bitte Datum auswählen' readonly  id='datepickerNewMessage' size='30px' style='width:200px;font-size:12px;font-weight:bold;color:#1c94c4;'/>
                        <button type="submit" name="newMessage" class="btn btn-xs btn-info">New </button></td></tr>
                    </table>

                </form>
            </div>



            <div class="col-sm-6">

                <form action="{{ url("admin/news/deleteMessages") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}


                <h4> <span class="label label-info" > ALL NEWS</span></h4>

                <div class="row">


                            <div id="tableAdminNews" style="margin-left:10px; ">

                                <div class='tblHead'>
                                    <div style='width:40px;'>ID</div>
                                    <div style='width:210px;' >HEAD</div>
                                    <div style="border-right:1px solid #1c94c4;width:60px;" >Select</div>
                                </div>


                                <div style="overflow:auto;height:175px;width:335px;">



                                        @foreach ($news as $new)

                                            <div id=""  class='tblContent' style="clear:left">

                                                <div id={{$new->id}}  style='cursor:pointer;width:40px;' onclick="AdminNewsShowDetails(this.id)" >{{$new->id}}</div>

                                                <div id={{$new->id . '_head'}} style='width:210px;'>{{$new->head}}</div>

                                                <div id={{$new->id . '_content'}} style='display:none'>{{ $new->content }}</div>


                                                <div id={{$new->id . '_date'}} style='display:none'>{{ $new->date }}</div>

                                                {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}

                                                <input type="hidden" value="off"  name="{{ 'check_'. $new->id}}"  />

                                                <div style="border-right:1px solid #1c94c4;width:60px;" >&nbsp;&nbsp;&nbsp;&nbsp;<input name="  {{ 'check_'. $new->id}}"  value="on"  type="checkbox" /></div>



                                            </div>

                                        @endforeach



                                </div>
                            </div>


                </div>


                <div class="row top5" >

                 <div class="col-sm-12">

                     <button type="submit" name="newsDelete" class="btn btn-xs btn-info">Delete</button>


                     {{--<button onclick='ConfirmAdminNewsNew()' class="btn btn-xs btn-info pull-right ">Refresh</button>--}}

                 </div>


                </div>

                </form>

            </div> {{--EndColLeft --}}


        </div>

        <div class="row top10" style="border:solid 1px #1c94c4;border-radius:2px ;padding: 10px;">

            <form action="{{ url("admin/news/sendNewsletter") }}" method="POST" class="form-horizontal" >

                {!! csrf_field() !!}


                <div class="col-sm-6">

                    <div class="row">

                        <div class="col-sm-12">

                            NEWSLETTER TEST

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-2">

                            <button type="submit" name="submit" value="TEST" class="btn btn-xs btn-info">Send</button>

                        </div>
                        <div class="col-sm-10">

                            <input id='newsAdminEmail' name="emailAdress"  style='width:200px;'/>

                        </div>


                    </div>

                </div>

                <div class="col-sm-6">

                    <div class="row">

                        <div class="col-sm-12">

                            NEWSLETTER AN ALLE KUNDEN
                        </div>

                    </div>

                    <div class="row">


                        <div class="col-sm-6">

                            <button type="submit" name="submit" value="CUSTOMERS" class="btn btn-xs btn-info">Send</button>

                        </div>


                    </div>

                </div>
            </form>
        </div>
    </div>




@endsection