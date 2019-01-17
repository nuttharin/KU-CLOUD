@extends('layouts.mainCompany') 
@section('title','Output Service | Company') 
@section('content')


<style>
    /* collap */
    .collap-output {
    background-color: #E6E6FA  ; 
    /* background-image:linear-gradient(120deg, #556cdc, #128bfc, #18bef1); */
    color: white;
    cursor: pointer;
    /* padding: 18px; */
    width: 100%;
    border-radius: 5px;
    border-color: black;
    /* font-size: 15px; */
    }

    .list-output {
        background-color: #FFFAFA  ;
        padding-left: 2%;
        border-color: black;
    }
    
    #header-detail {
        padding-top: 6px;

    }

    /* table */
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

    #btn-try {
        width: 6%;
        height:1%;
        border-radius: 5px;
        border: 2px solid;
    }
    

    
</style>
<br>
<h4>Output service</h4><hr>

<br>
<div class="container" >
    <div class="panel-group collap-output">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse1">
            <h4 class="panel-title">
            <div class="row" id='header-output'>
                <div class="col-sm-1" >
                    <button type="button" class="btn btn-primary">GET</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h5 style="color:black">Get data max</h5>
                </div>
                <div class="col-sm-9" id='header-detail'>
                    <h5 style="color:gray">/webService/GetAlldata</h5>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <ul class="list-group">
            <br/>
            <h5 style="color:black">This method allows you to retrieve data records from a resource</h5><br/>
            <table id="paramater">
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>Value</td>
                <td>column</td>
                <td>Germany</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Giovanni Rovelli</td>
                <td>Italy</td>
            </tr>
        </table>
            </ul>
            <hr style='width:98%;align=center;'>
            <button type="button" class="" id='btn-try'>Try it</button>
        </div>
    </div>
  </div>
</div>
<br>
<div class="container" >
    <div class="panel-group collap-output">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse2">
            <h4 class="panel-title">
            <div class="row" id='header-output'>
                <div class="col-sm-1" >
                    <button type="button" class="btn btn-success">POST</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h5 style="color:black">Get data max</h5>
                </div>
                <div class="col-sm-9" id='header-detail'>
                    <h5 style="color:gray">/webService/GetAlldata</h5>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
            <ul class="list-group">
            <br/>
            <h5 style="color:black">This method allows you to retrieve data records from a resource</h5><br/>
            <table id="paramater">
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>Value</td>
                <td>column</td>
                <td>Germany</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Giovanni Rovelli</td>
                <td>Italy</td>
            </tr>
        </table>
            </ul>
            <hr style='width:98%;align=center;'>
            <button type="button" class="" id='btn-try'>Try it</button>
        </div>
    </div>
  </div>
</div>
<br/>
<div class="container" >
    <div class="panel-group collap-output">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse3">
            <h4 class="panel-title">
            <div class="row" id='header-output'>
                <div class="col-sm-1" >
                    <button type="button" class="btn btn-danger">DELETE</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h5 style="color:black">Get data max</h5>
                </div>
                <div class="col-sm-9" id='header-detail'>
                    <h5 style="color:gray">/webService/GetAlldata</h5>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse3" class="panel-collapse collapse">
            <ul class="list-group">
            <br/>
            <h5 style="color:black">This method allows you to retrieve data records from a resource</h5><br/>
            <table id="paramater">
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>Value</td>
                <td>column</td>
                <td>Germany</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Giovanni Rovelli</td>
                <td>Italy</td>
            </tr>
        </table>
            </ul>
            <hr style='width:98%;align=center;'>
            <button type="button" class="" id='btn-try'>Try it</button>
        </div>
    </div>
  </div>
</div>
<br>

<!-- <div href="#demo1" class="collap-output" data-toggle="collapse" >    

    <div class="row" id='header-output'>
        <div class="col-sm-1" >
            <button type="button" class="btn btn-primary" style='width: 100%;' >GET</button>
        </div>
        <div class="col-sm-2" id='header-detail' >
            Get data max
        </div>
        <div class="col-sm-3" id='header-detail'>
            /webService/GetAlldata
        </div>
    </div>
    
    <div id="demo1" class="collapse list-output">
        <br>
        This method allows you to retrieve data records from a resource 
        <br>
        <table id="paramater">
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>Value</td>
                <td>column</td>
                <td>Germany</td>
            </tr>
            
            <tr>
                <td>Description</td>
                <td>Giovanni Rovelli</td>
                <td>Italy</td>
            </tr>
        </table>
        
        
        <br>
        <hr style='width:98%;align=center;'>
        <button type="button" class="" id='btn-try'  >Try it</button>

    </div>
</div>

<br>


<div href="#demo2" class="collap-output" data-toggle="collapse" >    

    <div class="row" id='header-output'>
        <div class="col-sm-1" >
            <button type="button" class="btn btn-danger" style='width: 100%;' >POST</button>
        </div>
        <div class="col-sm-2" id='header-detail' >
            Get data max
        </div>
        <div class="col-sm-3" id='header-detail'>
            /webService/GetAlldata
        </div>
    </div>
    
    <div id="demo2" class="collapse list-output">
        <br>
        This method allows you to retrieve data records from a resource 
        <br>
        <table id="paramater">
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>Value</td>
                <td>column</td>
                <td>Germany</td>
            </tr>
            
            <tr>
                <td>Description</td>
                <td>Giovanni Rovelli</td>
                <td>Italy</td>
            </tr>
        </table>
        
        
        <br>
        <hr style='width:98%;align=center;'>
        <button type="button" class="" id='btn-try'  >Try it</button>

    </div>
</div> -->
@endsection
