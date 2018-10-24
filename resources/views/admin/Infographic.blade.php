@extends('layouts.main')
@section('title','Admin | Company')
@section('content')

<style>

</style>

<link href="{{url('css/Infographic.css')}}" rel="stylesheet">
<link href="{{url('css/loading-text.css')}}" rel="stylesheet" />
<link href="{{url('css/animate.css')}}" rel="stylesheet">

<div class="row border-bottom">
    <div class="col-12 text-right">
        <button type="button" class="btn btn-default btn-md" style="margin: 20px;"><i class="fas fa-desktop"></i></button>
        <button type="button" class="btn btn-primary btn-md">Download</button>
        <button type="button" class="btn btn-success btn-md">Save</button>
    </div>      
</div>
<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-3">
        <div class="row">
            <div class="col-4 vertical-menu">
                <a href="#" id="btnGraph"><i class="fas fa-chart-line fa-2x"></i></a>
                <a href="#" id="btnMap"><i class="fas fa-map-marker-alt fa-2x"></i></a>
                <a href="#" id="btnFont"><i class="fas fa-font fa-2x"></i></a>
                <a href="#" id="btnImage"><i class="far fa-image fa-2x"></i></a>
                <a href="#" id="btnShapes"><i class="fab fa-microsoft fa-2x"></i></a>
            </div>
            <div class="col-8 select-menu" id="selectMenu">   
                <input type="hidden" id="pathImg" value="{{url('img_test.png')}}"/>
            </div>
        </div>
    </div>  
    <div class="col-6">
        <!-- A4 Size -->
        <canvas id="canvas" width="595" height="842" style="display: block; margin: 0 auto; margin-bottom: 0.5cm; box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);"></canvas>
    </div>
    <div class="col-3">

    </div>     
</div>

<script type="text/javascript" src="{{url('js/admin/Infographic/Infographic.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#sidebarCollapse").click();
        $("#selectMenu").hide();
    });
</script>
@endsection