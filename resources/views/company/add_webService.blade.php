@extends('layouts.mainCompany')
@section('title','Add WebService | Company')
@section('content')
<?php
    
    $Weather3Hours = array("StationNameTh","Province","Observe","Temperature","StationPressure",
    "RelativeHumidity","WindSpeed","Rainfall","TotolCloud");
    $service = array("Weather3Hours","WeatherToday","WeatherForecast7DaysByRegion","WeatherForecast7Days","WeatherForecastDaily");
    
?>
<style>
    
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
        padding: 0.5% 6%;
    }
    .regis
    {

        padding: 0.5% 42%;
        
    }
    

}
</style>
<br>
<h3>Add WebService</h3><hr>
<h5>Detail Service</h5>

<div style ="padding:0.5% 3%;">
    <form action="" class='form-inline'>
    
        <label for="" class="mb-2 mr-sm-2 col-6 col-md-2">Service Name :</label>
        <input type="text" class ="form-control mb-2 mr-sm-4 col-6 col-md-4" style='' id="service_name" name="service_name" placeholder="">                
        <label for="" class="mb-2 mr-sm-3 col-6 col-md-1">Alias :</label>            
        <input type="text" class ="form-control mb-2 mr-sm-4 col-6 col-md-4" style='width:200px' id="service_name" name="service_name" placeholder=" ">   
        
    </form>
    <form action="" class='form-inline'>
        <label for="" class="mb-2 mr-sm-2 col-6 col-md-2">URL :</label>            
        <input type="text" class ="form-control mr-sm-4 mb-2 col-6 col-md-4" style='width:369px' id="service_name" name="service_name" placeholder=" ">  
    </form> 
    <form action="" class='form-inline' style='padding: 0.5% 4.5%;'>
        <button type="button" id="Select1" class="btn btn-primary  mr-sm-3 col-5 col-md-2" style='width:200px'> <i class="fa fa-plus"></i> Add Column</button>    
        <button type="button" id="btn-regis" class="btn btn-success col-3 col-md-1" > Save</button>
    </form> 
 


</div>

<div id = "we" >
    <div class ="row">
        <div class='col-4 col-md-3'> 
            <label for="country">Input</label>
        </div> 
        <div class='col-4 col-md-2'> 
            <label for="country">Type</label>
        </div> 
        <div class='col-4 col-md-2'> 
            <label for="country">Permission</label>
        </div>         
    </div>

    <div id="add_detail">
        <div class ='row '  >
            <div class='col-4 col-md-3'>
                <input type='text' id='input_detail' name='' placeholder=''>    
            </div> 
            <div class='col-4 col-md-2'> 
                <select class='form-control' id=''> 
                    <option>int</option> 
                    <option>string</option>
                    <option>double</option>  
                    <option>text</option> 
                </select> 
            </div> 
            <div class='col-4 col-md-2'> 
                <select class='form-control' id=''> 
                    <option>Public</option> 
                    <option>Semi-private</option> 
                    <option>private</option> 
                </select> 
            </div>         
        </div>
    </div>

  
</div>

<script>

$(document).ready(function() {
    var ati = ["StationNameTh","Province","Observe","Temperature","StationPressure","RelativeHumidity","WindSpeed","Rainfall","TotolCloud"];
    var html = $("#add_detail").html();
    $("#Select1").click(function(){       
            $("#we").append(html);
            //$("#we").append("<br><div class ='row' ><div class='col-2 '> <input type='text' id='input_detail' name='' placeholder=''></div> <div class='col-2 '> <select class='form-control' id=''> <option>int</option> <option>string</option>  <option>double</option> <option>text</option> </select>  </div> <div class='col-2 '> <select class='form-control' id=''> <option>Public</option><option>Semi-private</option><option>private</option> </select>  </div>  </div>");   

    });
});

</script>
@endsection
