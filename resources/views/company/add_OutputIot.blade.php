@extends('layouts.mainCompany')
@section('title','Create Output IoT | Company')
@section('content')

<style>
    #CopyKey {
        float: right;
    }

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

    #name-iotservice{
        width: 100%;
        height: 40px;


    }

    #alias-iotservice{
        width: 100%;
        height: 40px;
    }

   

    #status-iotservice {
        width: 20%;
        height: 40px;
    }

    #url-nooffiotservice{
        width: 100%;
        height: 40px;
    }

  

    .from-input-detail h6,input,.from-treeView h6 {
       
        font-weight: normal;

    }

    .from-input-detail input,.from-input-detail textarea,.from-input-detail select ,.card-collect{
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
    margin-bottom: 12px;
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
</style>
<link href="{{url('css/i-check.min.css')}}" rel="stylesheet"/>
<link href="{{url('jstree/style.min.css')}}" rel="stylesheet" />
<link href="{{url('jstree/style.css')}}" rel="stylesheet" />
<link href="{{url('css/togglebutton.css')}}" rel="stylesheet" />
<br>
<div class="row">
    <div class="col-sm-6">
        <h4>Create a new Output IoT</h4>
    </div>
    <div class="col-sm-6">
        <div class="onoffswitch2">
        <input type="checkbox" name="onoffswitch2" class="onoffswitch2-checkbox" id="status-iotservice">
        <label class="onoffswitch2-label" for="status-iotservice">
            <span class="onoffswitch2-inner"></span>
            <span class="onoffswitch2-switch"></span>
        </label>
        </div>
        
    </div>
</div>
<hr>

<hr>
<!-- Modal -->



<script type="text/javascript" src="{{url('js/company/iot/addiot.js')}}"></script>
<script type="text/javascript" src="{{url('jstree/jstree.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{url('clipboard/clipboard.min.js')}}"></script>


<script>
    var clipboard = new ClipboardJS('#CopyKey');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>


@endsection
