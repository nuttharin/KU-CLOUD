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
        background-color: #E6E6FA  ;
        /* padding-left: 2%; */
        /* border-color: black; */
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
    #summary_table,#table_DW
    {
        width:100%;
        height:100%
    }
    p.solid 
    {
        border-style: solid;
    }
    #show_detail_tryit
    {
        padding-top:10px;
    }

    
</style>

<br>
<h2>Output service</h2><hr>
<br>
<div class="container">
    <h4>Web Service</h4>
</div>
<br/>
<div class="container " >
    <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse1">
            <h4 class="panel-title collap-output">
            <div class="row" id='header-output'>
                <div class="col-sm-2" >
                    <button type="button" style="width:70%" class="btn btn-primary">GET</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h6 style="color:black">Get data max</h6>
                </div>
                <div class="col-sm-8" id='header-detail'>
                    <h6 style="color:gray">/webService/GetAlldata</h6>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse1" class="panel-collapse collapse list-output">
            <ul class="list-group">
            <br/>
            <h6 style="color:black;padding-left:10px">This method allows you to retrieve data records from a resource</h6><br/>
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
    <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse2">
            <h4 class="panel-title collap-output">
            <div class="row" id='header-output'>
                <div class="col-sm-2" >
                    <button type="button" style="width:70%" class="btn btn-success">POST</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h6 style="color:black">Get All Data</h6>
                </div>
                <div class="col-sm-8" id='header-detail'>
                    <h6 style="color:gray">/webService/GetAlldata</h6>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse2" class="panel-collapse collapse list-output">
            <ul class="list-group">
            <br/>
            <h6 style="color:black;padding-left:10px">This method allows you to retrieve data records from a resource</h6><br/>
            <table id="paramater">
            <tr>
                <th>Parameter</th>
                <th>Value</th>
                <th>Location</th>
                <th>Description</th>
            </tr>
            
            <tr>
                <form>
                <div class="form-group">
                <td>Data</td>
                <td>
                    <div class="row">
                        <div class="col-sm-6" >
                            Table name (DW): 
                        </div>
                        <div class="col-sm-6 " >
                            <select class="form-control" id="table_DW">
                            </select>
                        </div>
                    </div>
                <br/>
                    <div class="row">
                        <div class="col-sm-6" >
                            Summary Table: 
                        </div>
                        <div class="col-sm-6 " >
                            <select class="form-control" id="summary_table">
                                <option value="Day">Day</option>
                                <option value="Month">Month</option>
                                <option value="Year">Year</option>
                            </select>
                        </div>
                    </div>
                </div>    
                </form>
                </td>
                <td>body</td>
                <td>Data to be written to the given resource</td>
                </div>
            </tr>
            </table>
            </ul>
            <hr>
            <button type="submit" id="try_it" class="btn btn-info">Try it</button>
            <a href='#' style="color:red" id="clear_result"></a>
            <div id="show_detail_tryit">
                <div id="call">
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<br/>
<div class="container" >
    <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse3">
            <h4 class="panel-title collap-output">
            <div class="row " id='header-output'>
                <div class="col-sm-2" >
                    <button type="button" style="width:70%" class="btn btn-danger">DELETE</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h6 style="color:black">Get data max</h6>
                </div>
                <div class="col-sm-8" id='header-detail'>
                    <h6 style="color:gray">/webService/GetAlldata</h6>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse3" class="panel-collapse collapse list-output">
            <ul class="list-group">
            <br/>
            <h6 style="color:black;padding-left:10px">This method allows you to retrieve data records from a resource</h6><br/>
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
<div class="container">
    <h4>IOT Service</h4>
</div>
<br/>
<div class="container " >
    <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
        <a data-toggle="collapse" href="#collapse1">
            <h4 class="panel-title collap-output">
            <div class="row" id='header-output'>
                <div class="col-sm-2" >
                    <button type="button" style="width:70%" class="btn btn-primary">GET</button>
                </div>
                <div class="col-sm-2" id='header-detail' >
                    <h6 style="color:black">Get data max</h6>
                </div>
                <div class="col-sm-8" id='header-detail'>
                    <h6 style="color:gray">/webService/GetAlldata</h6>
                </div>
            </div>
            </h4>
        </a>
        </div>
        <div id="collapse1" class="panel-collapse collapse list-output">
            <ul class="list-group">
            <br/>
            <h6 style="color:black;padding-left:10px">This method allows you to retrieve data records from a resource</h6><br/>
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
<script type="text/javascript" src="{{url('js/company/outputservice/outputservice.js')}}"></script>
@endsection
