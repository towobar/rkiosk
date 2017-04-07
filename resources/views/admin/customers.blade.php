@extends("layouts.webSite2");

@section("content")

    {{--Custom Message--}}
    @include("flash::message");



    <h1> <span class="label label-info " >KUNDEN ADMIN PAGE</span></h1>

    <h4> ALLE KUNDEN </h4>
    
    <div class="container">

        <div class="row">
            
            <form action="{{ url("admin/customers/updateDelete") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}
            
            <div class="col-md-8 ">
    
                <div class='tableAdminSortiment'>
                    <div class='tblHead'>
                        <div style='width:30px' >Id</div>                       
                        <div style='width:140px;'>Name</div>
                        <div style='width:60px'>Anrede</div>                       
                        <div style='width:140px;'>Email</div>
                        <div style='width:80px;'>Newsletter</div>                        
                        <div style='border-right:1px solid #1c94c4;width:60px;' >Select</div>
                    </div>
                  
                 <div style=" overflow:auto;height:200px;width:540px;border:2px solid black;">

                        @foreach ( $customers as $customer )

                        {{--DataRow der CustomerTabelle--}}
                        
                       

                        <div   class="tblContent" style="clear:left;">

                                <div style="width:30px;height:35px;" > <input style="width:20px;" name="{{ 'id_'. $customer->id}}" type="text" readonly value="{{$customer->id}}"/> </div>

                                <div style="width:140px;height:35px;"><input type="text" style="width:120px;" name="  {{ 'name_'. $customer->id}}" value="{{$customer->name}}" /></div>

                                
                                <div style="width:60px;height:35px;" ><input type="text" maxlength="4"  style="width:50px;" name="  {{ 'anrede_'. $customer->id}}" value="{{$customer->title}}" /></div>


                                <div style="width:140px;height:35px;"><input type="text"  style="width:120px;" name="  {{ 'email_'. $customer->id}}" value="{{$customer->email}}" /></div>

      
                                {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                            <input type="hidden" value="off"  name="{{ 'checknl_'. $customer->id}}"  />

                            
                            @if ($customer->newsletter == true)                           
                               <div style="border-right:1px solid #1c94c4;width:80px;;height:35px;text-align: center" ><input name="  {{ 'checknl_'. $customer->id}}"  value="on"  type="checkbox" checked /></div>                           
                            @else                           
                               <div style="border-right:1px solid #1c94c4;width:80px;;height:35px;text-align: center" ><input name="  {{ 'checknl_'. $customer->id}}"  value="on"  type="checkbox" /></div>                           
                            @endif            
                             
                            
                            

                        
                                
                                {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                            <input type="hidden" value="off"  name="{{ 'check_'. $customer->id}}"  />

                            <div style="border-right:1px solid #1c94c4;width:60px;;height:35px;text-align: center" ><input name="  {{ 'check_'. $customer->id}}"  value="on"  type="checkbox" /></div>

                        </div>

                        @endforeach

                    </div> {{-- Scrolled div --}}    
               </div> {{--End tableAdminSortiment--}} 
            </div> {{--End column--}} 
            
            <div class=" col-md-4 ">
                
                <input type="submit" value="UPDATE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />
                <input type="submit" value="DELETE"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />
               
                
            </div>
            
            </form>
        </div> {{--End row--}} 
        
        <div class="row" style="margin-top: 40px;">
            
            <form action="{{ url("admin/customer/new") }}" method="POST" class="form-horizontal" >

                    {!! csrf_field() !!}
            
                    <div class="col-md-10" >

                        <div class='tableAdminSortiment'>
                            <div class='tblHead'>                                         
                                <div style='width:140px;'>Name</div>
                                <div style='width:60px'>Anrede</div>   
                                <div style='width:100px'>Password</div>  
                                <div style='width:140px;'>Email</div>
                                <div style='width:80px;'>Newsletter</div>                        
                                <div style='border-right:1px solid #1c94c4;width:60px;' >Select</div>
                            </div>


                            <div style="clear:left;">
                                <div   class="tblContent" style="">

                                <div style="width:140px;height:35px;"><input type="text" style="width:120px;" name="customerName" value="" /></div>

                                
                                <div style="width:60px;height:35px;" ><input type="text" maxlength="4"  style="width:50px;" name="customerAnrede" value="" /></div>

                                <div style="width:100px;height:35px;" ><input type="text"   style="width:90px;" name="customerPassword" value="" /></div>

                                <div style="width:140px;height:35px;"><input type="text"  style="width:120px;" name="customerEmail" value="" /></div>

      
                                {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                                <input type="hidden" value="off"  name="checknl"  />

                                <div style="border-right:1px solid #1c94c4;width:80px;;height:35px;text-align: center" ><input name="checknl"  value="on"  type="checkbox" /></div>

                        
                                
                                {{--Trick damit die chekbox mit status "off" sichtbar ist bei POST--}}
                                <input type="hidden" value="off"  name="check"  />

                                <div style="border-right:1px solid #1c94c4;width:60px;;height:35px;text-align: center" ><input name="check"  value="on"  type="checkbox" /></div>

                           </div>
                                
                        </div>
                    </div>
                
                    <div class=" col-md-2" >
                            
                        <input type="submit" value="NEW"  name="submit" class="btn btn-xs btn-info" style="margin:5px" />    
                            
                    </div>
            </form>
        </div>
        
    </div>
        
    </div>
@endsection