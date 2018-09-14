@extends('layouts.mainCompany')
@section('title','Show WebService | Company')
@section('content')
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/r-2.2.2/sc-1.5.0/datatables.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/r-2.2.2/sc-1.5.0/datatables.min.js"></script>
<style>
div.dataTables_wrapper {
        width: 1000px;
        margin: 0 auto;
    }
</style>
<?php
    $json = file_get_contents('http://data.tmd.go.th/api/Weather3Hours/V1/?type=json');
    $obj = json_decode($json);
    $_SESSION["NameService"] = $obj->Header->Title ;
    $Weather3Hours = array("StationNameTh","Province","Observe","Temperature","StationPressure",
    "RelativeHumidity","WindSpeed","Rainfall","TotolCloud");
    $value_Weather3Hours = array();
    $count =0;
    for ($i=0; $i <count($obj->Stations) ; $i++) 
    { 
        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->StationNameTh  ; $count++;
        //echo $obj->Stations[$i]->StationNameTh  ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Province   ; $count++;
        //echo $obj->Stations[$i]->Province ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->Time  ; $count++;
        //echo $obj->Stations[$i]->Observe->Time ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->Temperature->Value." ".$obj->Stations[$i]->Observe->Temperature->Unit ; $count++;
        //echo $obj->Stations[$i]->Observe->Temperature->Value." ".$obj->Stations[$i]->Observe->Temperature->Unit  ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->StationPressure->Value." ".$obj->Stations[$i]->Observe->StationPressure->Unit  ; $count++;
        //echo $obj->Stations[$i]->Observe->StationPressure->Value." ".$obj->Stations[$i]->Observe->StationPressure->Unit  ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->RelativeHumidity->Value." ".$obj->Stations[$i]->Observe->RelativeHumidity->Unit ; $count++;
        //echo $obj->Stations[$i]->Observe->RelativeHumidity->Value." ".$obj->Stations[$i]->Observe->RelativeHumidity->Unit  ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->WindSpeed->Value." ".$obj->Stations[$i]->Observe->WindSpeed->Unit  ; $count++;
        //echo $obj->Stations[$i]->Observe->WindSpeed->Value." ".$obj->Stations[$i]->Observe->WindSpeed->Unit  ;

        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->Rainfall->Value." ".$obj->Stations[$i]->Observe->Rainfall->Unit  ; $count++;
        //echo $obj->Stations[$i]->Observe->Rainfall->Value." ".$obj->Stations[$i]->Observe->Rainfall->Unit  ;
        
        $value_Weather3Hours[$i][$count] = $obj->Stations[$i]->Observe->TotolCloud ; $count++;
        //echo $obj->Stations[$i]->Observe->TotolCloud ;
       }   
    
?>
<br>
<div class="row border-bottom">
    <div class="col-6" style="padding: 30px 0px 10px 15px">
        <span class="h3">Show WebService</span>
    </div>
    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
        <a  href="{{action('CompanyController@Add_service')}}" class="btn btn-success btn-radius">
            <i class="fa fa-plus"></i>
            Add Service
        </a>
    </div>
</div>  
<br>
<h5>NameService : <?php echo $_SESSION["NameService"]; ?></h5>
<br>
<table id="example3"  class=" table table-striped table-bordered table-hover  display nowrap"  style="width:100%">
        <thead>
            <tr>
            <?php 
                for ($i=0; $i <count($Weather3Hours) ; $i++) { 
                    echo "<th>".$Weather3Hours[$i]."</th>";
                }
            ?>
               
            </tr>
        </thead>
        <tbody>

            <?php             
               foreach($value_Weather3Hours as $land => $data)
               {
                    echo "<tr>";
                    foreach($data as $detail => $value)
                    {
                        echo "<td>". $value ."</td>" ;
                    }
                    echo "</tr>";
               }
            ?>            
            
        </tbody>
    </table>
</body>
</html>

<script>
$(document).ready(function() {
    $('#example3').DataTable( {
        "scrollY": 300,
        "scrollX": true
    } );
} );

</script>


@endsection
