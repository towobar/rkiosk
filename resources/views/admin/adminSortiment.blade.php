@extends("layouts.webSite2");

@section("content")

    {{--Custom Message--}}
    @include("flash::message");



    <h1> <span class="label label-info " >SORTIMENT ADMIN PAGE</span></h1>

    <h4> ALLE WARENGRUPPEN </h4>
    
    <div class="container">

        <div class="row">

            <form action="{{ url("admin/sortiment/updateDelete") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}
            
            <div class="col-sm-7 col-md-6 col-lg-5">
    
                <div class='tableAdminSortiment'>
                    <div class='tblHead'>
                        <div style='width:30px' >Id</div>
                        <div style='width:35px'>G</div>
                        <div style='width:160px;'>Name</div>
                        <div style='width:50px;'>Kurz</div>
                        <div style='border-right:1px solid #1c94c4;width:60px;' >Select</div>
                    </div>

                
                    
                    
                    
                    <div style=" overflow:auto;height:200px;width:355px;">

                        @foreach ( $sortiments as $sortiment )

                        {{--DataRow der SortimentTabelle--}}
                        
                       

                        <div   class="tblContent" style="">

                                <div style="width:30px;height:35px;" > <input style="width:20px;" name="{{ 'id_'. $sortiment->id}}" type="text" readonly value="{{$sortiment->id}}"/> </div>

                                <div style="width:35px;height:35px;" ><input type="text" maxlength="4"  style="width:25px;" name="  {{ 'group_'. $sortiment->id}}" value="{{$sortiment->group}}" /></div>

                                <div style="width:160px;height:35px;"><input type="text" style="width:140px;" name="  {{ 'name_'. $sortiment->id}}" value="{{$sortiment->name_long}}" /></div>

                                <div style="width:50px;height:35px;"><input type="text"  style="width:40px;" name="  {{ 'kurz_'. $sortiment->id}}" value="{{$sortiment->name_short}}" /></div>


                            {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                            <input type="hidden" value="off"  name="{{ 'check_'. $sortiment->id}}"  />

                            <div style="border-right:1px solid #1c94c4;width:60px;;height:35px;text-align: center" ><input name="  {{ 'check_'. $sortiment->id}}"  value="on"  type="checkbox" /></div>

                        </div>

                        @endforeach

                    </div> {{-- Scrolled div --}}
                </div> {{--End tableAdminSortiment--}} 
            </div> {{--End column--}} 
            
            <div class="col-sm-5 col-md-6 col-lg-7">
                
                <input type="submit" value="UPDATE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />
                <input type="submit" value="DELETE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />
               
                
            </div>
             
            </form>
        </div>{{--End row--}} 
        
        
        {{--Eingabe einer neuen Warengruppe--}}
        
        <div class="row" style="margin-top: 40px;">
            
            <form action="{{ url("admin/sortiment/new") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}
            
                    <div class="col-sm-5 col-md-6 col-lg-7" >

                        <div class='tableAdminSortiment'>
                            <div class='tblHead'>
                                <div style='width:35px'>G</div>
                                <div style='width:160px;'>Name</div>
                                <div style='width:50px;'>Kurz</div>
                                <div style='border-right:1px solid #1c94c4;width:60px;' >Select</div>
                            </div>


                            <div style="clear:left;">
                                <div   class="tblContent" style="">

                                        <div style="width:35px;height:35px;" ><input type="text" maxlength="4"  style="width:25px;" name="newSortimentGroup" value="" /></div>

                                        <div style="width:160px;height:35px;"><input type="text" style="width:140px;" name="newSortimentNameLong" value="" /></div>

                                        <div style="width:50px;height:35px;"><input type="text"  style="width:40px;" name="newSortimentNameShort" value="" /></div>


                                        {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                                        <input type="hidden" value="off"  name="check"  />

                                        <div style="border-right:1px solid #1c94c4;width:60px;;height:35px;text-align: center" ><input name="check"  value="on"  type="checkbox" /></div>

                                </div>    
                            </div>
                    </div>
                
                    <div class="col-sm-7 col-md-6 col-lg-5" >
                            
                        <input type="submit" value="NEW"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />    
                            
                    </div>
            </form>
        </div>   
            
        </div>
        
    </div>
    
    
    
    
    @endsection