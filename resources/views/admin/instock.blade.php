@extends("layouts.webSite2");

@section("content")

    {{--Custom Message--}}
    @include("flash::message");



    <h1> <span class="label label-info " >INSTOCK ADMIN PAGE</span></h1>


    <div class="dropdown" style="margin-bottom:15px;">
        <button class="btn btn-info dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Sortiment
            <span class="caret"></span></button>
        <ul class="dropdown-menu list-group" style="color:#1c94c4;" role="menu" >

            @foreach ($sortiments as $sortiment)

                {{--Sortiment-Untergruppen werden eingerückt !--}}

                @if(( $sortiment->group - floor($sortiment->group))  != 0)

                    <li role="presentation" class="list-group-item list-group-item-info"><a role="menuitem" tabindex="-1" href="/admin/instock/{{$sortiment->group}}" style="margin-left: 10px">{{$sortiment->name_long}}</a></li>

                @else

                    <li  role="presentation" class="list-group-item list-group-item-info"><a role="menuitem" tabindex="-1"  href="/admin/instock/{{$sortiment->group}}" style="text-decoration: underline">{{$sortiment->name_long}}</a></li>

                @endif



            @endforeach



        </ul><span> : {{$actSortiment }}</span>
    </div>

    
    <div class="container">

        <div class="row">

            <div class="col-sm-7 col-md-6 col-lg-5">


                <h3 style="color:  #1c94c4;" >Update : Artikel Instock </h3>

                <div class="tableAdminArtikel">
                    <div class="tblHead"style="font-size: small;" >
                        <div style="width:40px">ID</div>
                        <div style="width:40px">G</div>
                        <div style="width:120px;" >Artikel</div>
                     
                        <div style="width:55px" >InStock</div>
                        
                        
                        <div style="border-right:1px solid #1c94c4;width:45px;" >Select</div>
                    </div>


                    <form action="{{ url("admin/instock/update") }}" method="POST" class="form-horizontal" >

                        {!! csrf_field() !!}

                        <input type="hidden" value="{{$actSortiment }}"  name="actSortiment"  />

             <div style=" overflow:auto;height:200px;width:320px;">

                @foreach ($articles as $article)

                {{--DataRow der ArtikelTabelle--}}

                <div   class="tblContent" >

                        <div style="width:40px" > <input style="width:30px;" name="{{ 'id_'. $article->id}}" type="text" readonly value="{{$article->id}}"/> </div>

                        <div style="width:40px" ><input type="text" maxlength="4"  style="width:33px;" name="  {{ 'group_'. $article->id}}" value="{{$article->group}}" /></div>

                        <div style="width:120px"><input type="text" style="width:110px;" name="  {{ 'name_'. $article->id}}" value="{{$article->name}}" /></div>

                        <div style="width:55px"><input type="text"  style="width:40px;" name="  {{ 'instock_'. $article->id}}" value="{{$article->instock}}" /></div>


                    {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                    <input type="hidden" value="off"  name="{{ 'check_'. $article->id}}"  />

                    <div style="border-right:1px solid #1c94c4;width:45px;" >&nbsp;&nbsp;<input name="  {{ 'check_'. $article->id}}"  value="on"  type="checkbox" /></div>

                </div>

                @endforeach

             </div> {{-- Scrolled div --}}
            </div> {{--End tableAdminArtikel--}}

            </div> {{--End Col--}}
            
            
            <div class="col-sm-2">

                <div class="row">

                    <div class="col-sm-3">

                      {{--<button  class="btn btn-info" style="margin:5px" >UPDATE</button>--}}

                        <input type="submit" value="UPDATE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />

                        </form>
                    </div>

                </div>

                    
            </div>
            
            
        </div>
        
    </div>
    

@endsection