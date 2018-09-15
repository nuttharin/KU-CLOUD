@extends('layouts.mainCompany')
@section('title','Add WebService | Company')
@section('content')
<?php
    
    $Weather3Hours = array("StationNameTh","Province","Observe","Temperature","StationPressure",
    "RelativeHumidity","WindSpeed","Rainfall","TotolCloud");
    $service = array("Weather3Hours","WeatherToday","WeatherForecast7DaysByRegion","WeatherForecast7Days","WeatherForecastDaily");
    
?>
<style>
    #Select1 {
        width: 30%;
    }
    .input_atti
    {
        width: 25%;
    }
    #SelectPublic
    {
        width: 20%;
    }
    input[type=text]{
    width: 100%;
    padding: 3px 0px ;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;   
    
    }
    #input_detail
    {
        width: 100%;
        padding: 5.5px 0px ;
    }
    .detail_service
    {
        padding: 0.5% 5%;
    }
    #we{
        padding: 0.5% 5%;
    }
    .regis
    {

        padding: 0.5% 36.7%;
        
    }
    

}
</style>
<br>
<h3>Add WebService</h3><hr>
<h5>Detail Service</h5>
<div>
    <div class ='row detail_service'> 
        <div class='col-2 '> 
            <label for="country">Service Name :</label>
            </div> 
        
            <div class='col-3 ' style ="  padding-left: 0px; "> 
                <input type="text" id="service_name" name="service_name" placeholder="">   
            </div> 

        <div class='col-1 '> 
            <label for="country">Alias :</label>
        </div> 
    
        <div class='col-2 '> 
            <input type="text" id="service_name" name="service_name" placeholder=" ">   
        </div> 
    
    </div>

    <div class ='row detail_service'> 
        <div class='col-1 '> 
            <label for="country">URL :</label>
            </div> 
        
            <div class='col-3 ' style ="  padding-left: 0px; "> 
                <input type="text" style="width:140%;" id="url" name="service_name" placeholder="">   
            </div> 
            

            
    </div>
    <div class="col-6 detail_service" >
    <button type="button" id="btn-regis" class="btn btn-primary " > <i class="fa fa-plus"></i> Add Column</button>    
    </div>

</div>
<div id = "we">
    <div class ="row">
        <div class='col-2 '> 
            <label for="country">Input</label>
        </div> 
        <div class='col-2 '> 
            <label for="country">Type</label>
        </div> 
        <div class='col-2 '> 
            <label for="country">Permission</label>
        </div>         
    </div>

     <div class ='row' >
        <div class='col-2 '>
            <input type='text' id='input_detail' name='' placeholder=''>    
        </div> 
        <div class='col-2 '> 
            <select class='form-control' id=''> 
                <option>int</option> 
                <option>string</option>
                <option>double</option>  
                <option>text</option> 
            </select> 
        </div> 
        <div class='col-2 '> 
            <select class='form-control' id=''> 
                <option>Public</option> 
                <option>Semi-private</option> 
                <option>private</option> 
            </select> 
        </div>         
    </div>

  
</div>
<div class ='regis detail_service'>
    <button type="button" id="btn-regis" class="btn btn-success " > Add Service</button>
</div>
<script>

$(document).ready(function() {
    var ati = ["StationNameTh","Province","Observe","Temperature","StationPressure","RelativeHumidity","WindSpeed","Rainfall","TotolCloud"];
    var html = $("#input_detail").html();
    $("#Select1").click(function(){       
        
            $("#we").append("<br><div class ='row' ><div class='col-2 '> <input type='text' id='input_detail' name='' placeholder=''></div> <div class='col-2 '> <select class='form-control' id=''> <option>int</option> <option>string</option>  <option>double</option> <option>text</option> </select>  </div> <div class='col-2 '> <select class='form-control' id=''> <option>Public</option><option>Semi-private</option><option>private</option> </select>  </div>  </div>");   

    });
});

</script>
@endsection
