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
</style>
<br>
<h3>Add WebService</h3><hr>

<div class="form-group">
    <label for="exampleFormControlSelect1"><h5> Select Service</h5></label>
    <select class="form-control" id="Select1">
    <option>------------Select------------</option>
    <?php  
        for ($i=0; $i < count($service) ; $i++) { 
            echo "<option>".$service[$i]."</option>";
        }
    ?>
      
    </select>
</div>
<h6>Detail Service</h6>
<br>
<div id = "we">
  
</div>
<script>
$(document).ready(function() {
    var ati = ["StationNameTh","Province","Observe","Temperature","StationPressure","RelativeHumidity","WindSpeed","Rainfall","TotolCloud"];
    $("#Select1").change(function(){
    $("#we").empty();
    if($(this).val() == "Weather3Hours")
    {
        
        var i ;
        for(i=0 ; i<ati.length ; i++)
        {
            $("#we").append("<div class ='row'> <div class='col-3'> <div class='checkbox icheck-turquoise '> <input type='checkbox'  id='turquoise" + i + "' /> <label for='turquoise" + i +"' >"+ati[i]+"</label> </div ></div> <div class='col-6'> <select class='form-control' id='SelectPublic'> <option>Public</option> <option>Semi-private</option> <option>private</option> </select> </div> </div> ");
       
       
        }
    }
    
    

});
});

</script>
@endsection
