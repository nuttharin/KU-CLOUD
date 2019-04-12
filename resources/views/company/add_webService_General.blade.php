@extends('layouts.mainCompany')
@section('title','Add WebService | Company')
@section('content')

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

    #status-webservice {
        width: 20%;
        height: 40px;
    }

  

    .from-input-detail h6,input,.from-treeView h6 {
       
        font-weight: normal;

    }

    .from-input-detail input,.from-input-detail textarea,.from-input-detail select{
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

    /* .modal-header{
        background: linear-gradient(120deg,#00e4d0,#5983e8);
    } */
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
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    .customcheck {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 2px;
    cursor: pointer;
    font-size: 15px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.customcheck input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
    border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.customcheck:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.customcheck input:checked ~ .checkmark {
    background-color: #02cf32;
    border-radius: 5px;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.customcheck input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.customcheck .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
#paramater {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
    }

    #paramater td, #paramater th {
        border: 1px solid #308ee0;
        padding: 8px;
        color:black;
    }

    /* #paramater tr:nth-child(even){background-color: #f2f2f2;} */

    #paramater tr:hover {background-color: #cedfed;}

    #paramater th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #308ee0;
        color: white;
    }
    .tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

    .tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
    }
    #myModal {
        overflow-y:scroll;
    }
    #myModal2 
    { overflow-y:scroll }

    .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }

</style>
<link href="{{url('css/i-check.min.css')}}" rel="stylesheet"/>
<link href="{{url('jstree/style.min.css')}}" rel="stylesheet" />
<link href="{{url('jstree/style.css')}}" rel="stylesheet" />
<link href="{{url('css/togglebutton.css')}}" rel="stylesheet" />
<link href="{{url('css/loading.css')}}" rel="stylesheet" />
<br>

<div class="row">
    <div class="col-sm-6">
        <h4>Create a new webservice</h4>
    </div>
    <div class="col-sm-2">
        <div class="form-group">           
            <select class="form-control" id="status">
                <option>Public</option>
                <option>Private Company</option>
                <option>Private Owner</option>                
            </select>
        </div>
    </div>
</div>
<hr>
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
            <input type="text" class="mb-2" id="url-webservice" name="firstname" placeholder="Url of WebService" require>
            <h6>Description</h6>
            <textarea type="text" rows="2" class="form-control mb-2"  id="description-webservice" placeholder="Webservice description" ></textarea>
            <div class="row">
                <div class="col-sm-12">
                        <h6 >Update Data <span style="color:red">*</span></h6>
                        <!-- Modal -->
                        <div class="modal fade" id="howtouse-crontrab" role="dialog">
                            <div class="modal-dialog">
                            
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">Cron Syntax</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                <h5>Allowed values</h5><br/>
                                <center>
                                <table id="paramater">
                                    <thead>
                                        <th>field</th>
                                        <th>value</th>
                                    </thead>
                                    <tbody>
                                        <td>*</td>
                                        <td>any value</td>
                                    <tr>
                                        <td>,</td>
                                        <td>value list separator</td>
                                    <tr>
                                        <td>-</td>
                                        <td>range of values</td>
                                    <tr>
                                        <td>/</td>
                                        <td>step values</td>
                                    <tr>
                                        <td>minute</td>
                                        <td>0-59</td>
                                    <tr>
                                        <td>hour</td>
                                        <td>0-23</td>
                                    </tbody>
                                </table>
                                </center>
                                <hr/>
                                <h5>Examples</h5>
                                <p>How to write a crontab schedule expression for:</p>
                                    <div class="row" >
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" style="width:100%; text-align: center;" id="minute_input" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" style="width:100%; text-align: center;" id="hour_input" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-3">
                                            <center>minute</center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>Hour</center>
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-sm-12">
                                            <center><p id="description_time"></p></center>
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" id="every_minute">every minute</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="#" id="every_30_minute">every 30 minute</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" id="every_3_hour">every 3 hour</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="#" id="every_day">every day</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" id="every_day_at_1am">every day at 1am</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="#" id="between_certain_hours">between certain hours</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                            <div class="row">
                                <!-- <div class="col-sm-6">
                                    <input style="width:100%; text-align: center; " title="second" class="" id="time-webservice-second" name="time-webservice-second" value="* * * * * *" placeholder="*">
                                </div> -->
                                    <div class="col-sm-2">
                                        <input type="input" style="width:100%; text-align: center;" title="minute" class="" id="time-webservice-minute" value="*" name="time-webservice-minute" placeholder="*">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="input" style="width:100%; text-align: center;" title="hour" class="" id="time-webservice-hour" value="*" name="time-webservice-hour" placeholder="*">
                                    </div>
                                    <div class="col-sm-4">
                                    <a href="#" data-toggle="modal" data-target="#howtouse-crontrab"> How to use</a>
                                    </div>
                                </div>
                
                                
                            
                        
                        <div class="row">
                            <div class="col-sm-2">
                                <center>minute</center>
                            </div>
                            <div class="col-sm-2">
                                <center>hour</center>
                            </div>
                        </div>
                </div>
            </div>
            <button type="button" id="showvalue" class="btn btn-primary show-header"><a style="color:white" href="#select">Show value</a></button>  
            
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
            <div class="loader" style="display: none;float :center">

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
<script type="text/javascript" src="{{url('js/company/services/addservice_general.js')}}"></script>
<script type="text/javascript" src="{{url('jstree/jstree.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>

<script>
    
</script>


@endsection
