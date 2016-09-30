@extends("layouts.webSite2");

@section("content")

    {{--Custom Message--}}
    @include("flash::message");



    <h1> <span class="label label-info " >ARTICLE ADMIN PAGE</span></h1>


    <div class="dropdown" style="margin-bottom:15px;">
        <button class="btn btn-info dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Sortiment
            <span class="caret"></span></button>
        <ul class="dropdown-menu list-group" style="color:#1c94c4;" role="menu" >

            @foreach ($sortiments as $sortiment)

                {{--Sortiment-Untergruppen werden eingerückt !--}}

                @if(( $sortiment->group - floor($sortiment->group))  != 0)

                    <li role="presentation" class="list-group-item list-group-item-info"><a role="menuitem" tabindex="-1" href="/admin/articles/{{$sortiment->group}}" style="margin-left: 10px">{{$sortiment->name_long}}</a></li>

                @else

                    <li  role="presentation" class="list-group-item list-group-item-info"><a role="menuitem" tabindex="-1"  href="/admin/articles/{{$sortiment->group}}" style="text-decoration: underline">{{$sortiment->name_long}}</a></li>

                @endif



            @endforeach



        </ul><span> : {{$actSortiment }}</span>
    </div>



    <div class="container">

        <div class="row">

            <div class="col-sm-6">


                <h3 style="color:  #1c94c4;" >Update : Artikel </h3>

                <div class="tableAdminArtikel">
                    <div class="tblHead">
                        <div style="width:32px">ID</div>
                        <div style="width:40px">G</div>
                        <div style="width:120px;" >Artikel</div>
                        <div style="width:40px">Bild</div>
                        <div style="width:70px" >Preis</div>
                        <div style="width:120px" >Beschreibung</div>
                        <div style="border-right:1px solid #1c94c4;width:60px;" >Select</div>
                    </div>


                    <form action="{{ url("admin/articles/updateDelete") }}" method="POST" class="form-horizontal" >

                        {!! csrf_field() !!}

                        <input type="hidden" value="{{$actSortiment }}"  name="actSortiment"  />

             <div style=" overflow:auto;height:200px;width:500px;">

                @foreach ($articles as $article)

                {{--DataRow der ArtikelTabelle--}}

                <div   class="tblContent" >

                        <div style="width:32px" > <input  name="{{ 'id_'. $article->id}}" type="text" readonly value="{{$article->id}}"/> </div>

                        <div style="width:40px" ><input type="text" maxlength="4"  style="width:33px;" name="  {{ 'group_'. $article->id}}" value="{{$article->group}}" /></div>

                        <div style="width:120px"><input type="text" style="width:110px;" name="  {{ 'name_'. $article->id}}" value="{{$article->name}}" /></div>

                        <div id="{{$article->id}}" onclick="AdminArticleShowImage(this.id)" style="width:40px;cursor:pointer" >click!<input  id="" type="text"  style="width:25px;display:none"  value="{{$article->image . '_' . $article->name}}" /> </div>

                        <div style="width:70px"><input type="text"  style="width:60px;" name="  {{ 'price_'. $article->id}}" value="{{$article->price}}" /></div>

                        <div id="{{ 'descrip_'. $article->id}}"  onclick="ArticleDescripInputPrompt(this.id)"  style="width:120px;text-align:center;cursor:pointer">click!<input type="text" name="{{ 'descrip_'. $article->id}}"   style="width:120px;display:none" value="{{ $article->description }}" /></div>



                    <input type="hidden" value="off"  name="{{ 'check_'. $article->id}}"  />


                    <div style="border-right:1px solid #1c94c4;width:60px;" >&nbsp;&nbsp;&nbsp;&nbsp;<input name="  {{ 'check_'. $article->id}}"  value="on"  type="checkbox" /></div>

                </div>

                @endforeach

             </div> {{-- Scrolled div --}}
            </div> {{--End tableAdminArtikel--}}

            </div> {{--End Col--}}



            <div class="col-sm-6">

                <div class="row">

                    <div class="col-sm-2">

                      {{--<button  class="btn btn-info" style="margin:5px" >UPDATE</button>--}}

                        <input type="submit" value="UPDATE"  name="submit" class="btn btn-info" style="margin:5px" />


                    </div>

                    <div class="col-sm-2">

                        {{--<button  class="btn btn-info" style="margin:5px">DELETE</button>--}}

                        <input type="submit" value="DELETE"  name="submit" class="btn btn-info" style="margin:5px" />

                    </div>

                    </form>

                    <div class="col-sm-2">

                        <form action="{{ url("admin/articles/refresh")}}" method="POST" class="form-horizontal"  >

                            {!! csrf_field() !!}

                            <input type="hidden" value="{{$actSortiment }}"  name="actSortiment"  />

                            <input type="submit" value="REFRESH"  name="submit" class="btn btn-info" style="margin:5px" />
                        </form>




                        {{--<button  class="btn btn-info" style="margin:5px">REFRESH</button>--}}

                    </div>

                </div>


            </div>

            <div class="row">

                <div class="col-sm-6" style="margin-top: 10px">

                    <div id="adminHeadArticle" style="font-size:10px;color:#1c94c4;">{{ "Artikel Name : " . $initArticleName }}</div>

                    <span  id="adminHeadImgFile" style="font-size:10px;color:#1c94c4;">{{ "File Name : " . $initArticleImage }}</span>

                    <img id="adminImgArticle" class="img-responsive" style="width: 200px;height:200px;margin-top:5px;border: solid 2px #1c94c4;border-radius: 4px" src="{{ asset($initArticleImage)}}" alt="Article" >
                </div>
             </div>




        </div>  {{--End Row--}}

        <div class="row"  >

            <form action="{{ url("admin/articles/new") }}" method="POST" class="form-horizontal" >

                {!! csrf_field() !!}

            <div class="col-sm-4" style="height:120px">


              {{--MarkUp für die eingabe neuer Artikel --}}

                <h3 style="color:  #1c94c4;" >New : Artikel </h3>

                {{--Head der AdminArtikelTabelle (New)  : Achtung die Formatierung erfolgt mit den  css-Klassen--}}

                <div class="tableAdminArtikelNew">
                    <div class="tblHead">
                        <div style="width:120px">ArtikelName</div>
                        <div style="width:70px">Preis</div>
                        <div style="border-right:1px solid #1c94c4;width:140px">Sortiment</div>
                    </div>



                    {{--DataRow der ArtikelNewTabelle--}}
                    <div   class="tblContentNew">

                        <div style="width:120px"><input type="text" name="newArticleName"style="width:110px;" /></div>

                        <div style="width:70px"><input type="text"  name="newArticlePrice" style="width:60px;" /></div>

                        {{--OptionMenu für die Warengruppen--}}

                        <div style="border-right:1px solid #1c94c4;width:140px">

                            <select name="newArticleGroup" style="font-size:12px;font-weight:bolder;color:#1c94c4;" >

                                {{--Auslesen der WarenGruppen : $rowsSortiment wurde schon oben aus der DB augelesen !--}}

                                {{--// $sortiment Sortiment-Objekt--}}
                                @foreach ($sortiments as $sortiment)

                                    @if($sortiment->name_long != "GESAMT")


                                        {{--Sortiment-Untergruppen werden eingerückt !--}}
                                        @if(( $sortiment->group - floor($sortiment->group))  != 0)

                                          <option  style="color:#eb8f00;" value="{{$sortiment->group}}">&nbsp;&nbsp; {{$sortiment->name_long . "(" . $sortiment->name_short . ")" }} </option>


                                        @else

                                           <option style="color:#1c94c4;" value="{{$sortiment->group}}">{{$sortiment->name_long . "(" . $sortiment->name_short . ")" }} </option>

                                        @endif

                                    @endif

                                @endforeach

                            </select>

                            </div>

                        </div>
                    </div>
                {{--</div>--}}



            </div> {{--End Col--}}

            <div class="col-sm-1">

                {{--<button  class="btn btn-info" style="margin-top:60px">NEW</button>--}}

                <input type="submit" value="NEW"  name="submit" class="btn btn-info" style="margin-top:60px" />



            </div>


            </form> {{--End Form Article New--}}


            <div class="col-sm-7">
                {{--// Markup für die Anzeige des fileuploads--}}

                <form action="{{ url("admin/articles/attachImage") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}

                    <input type="hidden" value="{{$actSortiment }}"  name="actSortiment"  />

                     <span> <h6  style="color:#1c94c4;">AID</h6>
                     <input id="adminArticleID" name="adminArticleID" type=text" maxlength="3" style="width:40px;height: 18px;color:#1c94c4;"/></span>
                    <h6  style="color:#1c94c4;">Uploaded Image</h6>
                    <input id="adminArticleImageName" name="adminArticleImageName" type="text" readonly style="width:155px;height: 18px;font-size: smaller;font-weight: bolder;color:#1c94c4;" value="{{ $filename }}"/>
                    <button onclick="ConfirmAdminAttachImageArticle()"  class="btn btn-info" >Attach Image</button>

                </form>

            </div>

        </div>  {{--End Row--}}

        <div class="row" >

            <div class="col-sm-12" >

                <form action="{{ url("admin/articles/upload") }}" method="POST" class="form-horizontal" enctype="multipart/form-data">


                    {!! csrf_field() !!}

                    <input type="hidden" value="{{$actSortiment }}"  name="actSortiment"  />

                    <label>Bitte ein Image zum Upload auswählen</label>

                    <input type="file" id="image"  name="image" >

                    <input type="submit" value="Upload"  name="submit" style="margin-top: 5px;" class="btn btn-info">


                </form>


            </div>




        </div>  {{--End Row--}}

    </div>  {{--End Container--}}




@endsection