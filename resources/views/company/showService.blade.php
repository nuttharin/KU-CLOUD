@extends('layouts.mainCompany')
@section('title','Show WebService | Company')
@section('content')
<?php
    $json = file_get_contents('http://data.tmd.go.th/api/Weather3Hours/V1/?type=json');
    $obj = json_decode($json);
    $_SESSION["NameService"] = $obj->Header->Title ;
    $Weather3Hours = array("StationNameTh","Province","Observe","Temperature","StationPressure",
    "MeanSeaLevelPressure","DewPoint","RelativeHumidity","VaporPressure","WindDirection","Rainfall","TotolCloud");
    
    
?>
<br>
<h2>  Show WebService   </h2>

<br>
<h3>NameService : <?php echo $_SESSION["NameService"]; ?></h3>

<div class="row" style="padding: 010px 0px 10px 0px">
    <div class="col-12">
        <div class="panel-body">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                <thead>
                    <tr> 
                    <?php          
                        
                        for ($i=0; $i < count($Weather3Hours); $i++) 
                        { 
                            echo "<th>" ;
                            echo $Weather3Hours[$i] ; 
                            echo "</th>" ;
                  
                        }
                    ?>
                        
                        
                    </tr>
                </thead>
                <tbody>
                   <?php 

                   for ($i=0; $i < count($obj->Stations) ; $i++) 
                   { 
                    ?> 
                    <tr> 
                    <?php
                        for ($j=0; $j < 2 ; $j++) 
                        { 
                            $temp = $Weather3Hours[$j] ;
                    ?>
                    <td><?php  echo $obj->Stations[$i]->$temp ; ?></td>
                    <?php
                        }
                    echo  "</tr>";                           
                   }

                   ?>
                   
                    
                        
                   
                   
                  
                    
                   
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
