@extends('layouts.mainCompany')
@section('title','Add WebService | Company')
@section('content')
<?php
    
    $Weather3Hours = array("StationNameTh","Province","Observe","Temperature","StationPressure",
    "RelativeHumidity","WindSpeed","Rainfall","TotolCloud");
    $service = array("Weather3Hours","WeatherToday","WeatherForecast7DaysByRegion","WeatherForecast7Days","WeatherForecastDaily");
    
?>
<style>
    #detail-show{
        background-color: #EBF5FB    ;        
    }

    #detail-show p {
        font-size: 13px;
        color : #616A6B  ;
        padding-left : 10px;
        padding-right:8px;

    }       
     
    #detail{
        border-left-style: solid;
        border-left-color: #AED6F1 ;
        border-width: 2px;
    }

    .from-input-detail,.from-treeView{
        padding-left:30px;
    }

    input,textarea{
        border-radius: 4px;
        border: none;
        padding: 5px 20px;
        cursor: pointer;
        padding: 12px;


    }

    #name-webservice{
        width: 100%;
        height: 40px;


    }

    #alias-webservice{
        width: 100%;
        height: 40px;
    }

    #url-webservice{
        width: 100%;
        height: 40px;
    }

  

    .from-input-detail h6,input,.from-treeView h6 {
       
        font-weight: normal;

    }

    .from-input-detail input,.from-input-detail textarea{
        border: 1px solid #AED6F1 ;
    }
    
    .show-header{
        float:right;
    }
    #select
    {
        padding-top:20px;
        background-color:white;
        border:1px solid #AED6F1;
    }
    #id_search
    {
        border:1px solid #AED6F1;
    }
    #search
    {
        padding-left:50px;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 100%;
        border-radius: 5px;
    }
    .proton-demo{
            max-width: 100%;
            padding: 10px;
            border-radius: 3px;
        }
    .from-treeView ul ,.from-treeView li {
        font-size: large;
        /* padding-left : 30px; */
    }

    li , ul {
        list-style : none ;
    
    }
    .from-treeView .card ul input {
        padding-left : 50px;
    }

    #check {
        font-size:18px;
        padding-top:20px;
        padding-left:50px;
    }
    .jstree-default .jstree-clicked{
        background-color : transparent !important;
        box-shadow: none !important;
    }
    
    #submitcheck{
        padding-left:50px;
        padding-top:30px;
        padding-bottom:30px;
    }
    .jstree-proton .jstree-clicked
    {
        color: black !important; 
    }
    .jstree-proton .jstree-wholerow-clicked
    {
        background:transparent !important;
    }
    .jstree-proton .jstree-wholerow-hovered {
        background: #F5F5F5 !important;
    }
    .jstree-proton .jstree-hovered {
        color: none !important;
    }
    .jstree-proton .jstree-search{
        color:#6699FF !important;
    }
</style>
<link href="{{url('css/i-check.min.css')}}" rel="stylesheet"/>
<link href="{{url('jstree/style.min.css')}}" rel="stylesheet" />
<link href="{{url('jstree/style.css')}}" rel="stylesheet" />
<br>
<h4>Create a new webservice</h4><hr>
<div class="from-input-detail">
    <div class="row">
        <div class="col-sm-8 " >
            <div class ="row">
                <div class="col-sm-8">
                    <h6 >Service Name <span style="color:red">*</span></h6>
                    <input type="text" class="mb-2" id="name-webservice" name="name" placeholder="Webservice name">
                </div>
                <div class="col-sm-4">
                    <h6 >Alias <span style="color:red">*</span></h6>
                    <input type="text" class="mb-2" id="alias-webservice" name="alias" placeholder="Webservice alias ">
                </div>

                
            </div>

            <h6>URL <span style="color:red">*</span></h6>
            <input type="text" class="mb-2" id="url-webservice" name="firstname" placeholder="Url of WebService">
            <h6>Description</h6>
            <textarea type="text" rows="2" class="form-control mb-2"  id="description-webservice" placeholder="Webservice description" ></textarea>
            <button type="button" id="showvalue" class="btn btn-primary show-header"><a href="#select">Show value</a></button>  
            
        </div>
        
        <div class="col-sm-4"  >
                <!-- <div class ="col-sm-1" id="detail-left"></div> -->
                <div class = "col-sm-12" id="detail" >
                    <h6 style="font-style: oblique;"> Resource Data Type </h6>
                    <div id="detail-show">
                        <p>When creating a new resource, you need to specify the 
                        type of data that is expected to be persisted to this resource.

                        Beebotte has a number of defined data types; click here for more information.
                        </p>
                    </div> 

                    <h6 style="font-style: oblique;"> Public is ? </h6>
                    <div id="detail-show">
                        <p>When creating a new resource, you need to specify the 
                        type of data that is expected to be persisted to this resource.

                        Beebotte has a number of defined data types; click here for more information.
                        </p>
                    </div> 
                </div>
        </div>
    </div>
</div>
<hr>
<div>
</div>
<div class = 'from-treeView'>

    <div class="row">
        
        <div class="col-sm-8 treeView-list" id="checkshow">
            <div id="loading" style="display:none;">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <h6 class='text-center'>Loading Tree ...</h6>
            </div>
        </div>
        <div id="showtext" class="col-sm-4"  >
        <!-- ขีดข้าง css #detail ,detail-show1,detail-show2 = code in addservice.js เเสดงวิธีใช้ -->
            <div class = "col-sm-12" id="detail" >  
                <div id="detail-show1">
                </div>
                <div id="detail-show2">
                </div>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript" src="{{url('js/company/services/addservice.js')}}"></script>
<script type="text/javascript" src="{{url('jstree/jstree.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>

<script>
    
</script>


@endsection
