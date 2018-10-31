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

  

    .from-input-detail h6,input {
       
        font-weight: normal;

    }

    .from-input-detail input,.from-input-detail textarea{
        border: 1px solid #AED6F1 ;
    }
    
    .show-header{
        float:right;
    }

    

    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 100%;
        border-radius: 5px;
    }

    .from-treeView ul ,.from-treeView li {
        font-size: large;
        padding-left : 30px;
    }

    li , ul {
        list-style : none ;
    
    }
    .from-treeView .card ul input {
        padding-left : 50px;
    }


    
   
    
        
    


</style>
<link href="{{url('css/i-check.min.css')}}" rel="stylesheet" />
<link href="{{url('css/style.min.css')}}" rel="stylesheet" />

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
            <button type="button" class="btn btn-primary show-header">Show value</button>

                
            
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

<div class = 'from-treeView'>
    <div class="row">
        <div class="col-sm-8 card treeView-list " >
            <!-- <ul>Stations
            <div class="checkbox icheck-peterriver"><input type="checkbox" checked id="peterriver" /><label for="peterriver">WmoNumber</label></div>
            <li><input type="checkbox" checked id="peterriver" />StationNameTh</li>
            
                <li><input type="checkbox" checked id="peterriver" />sss
                    <ul>
                        <li><input type="checkbox" checked id="peterriver" />WmoNumber</li>
                        <li><input type="checkbox" checked id="peterriver" />StationNameTh</li>
                    </ul>
                </li>
            
            </ul>
            <ul>name 1
                <li><input type="checkbox" checked id="peterriver" />WmoNumber</li>
                <li><input type="checkbox" checked id="peterriver" />StationNameTh</li>
                
                    <li><input type="checkbox" checked id="peterriver" />sss
                        <ul>
                            <li><input type="checkbox" checked id="peterriver" />WmoNumber</li>
                            <li><input type="checkbox" checked id="peterriver" />StationNameTh</li>
                        </ul>
                    </li>
                
            </ul> -->
        </div>
        <div class="col-sm-4"  >
        </div>


    </div>

    
</div>
<script type="text/javascript" src="{{url('js/company/services/addservice.js')}}"></script>
<script type="text/javascript" src="{{url('jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('jquery/jstree.min.js')}}"></script>


<script>
    
</script>


@endsection
