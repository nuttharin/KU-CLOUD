@extends('layouts.mainCompany') 
@section('title','Output Service | Company') 
@section('content')


<style>
    /* collap */
    .collap-output {
    background-color: #7FB3D5  ; 
    /* background-image:linear-gradient(120deg, #556cdc, #128bfc, #18bef1); */
    color: white;
    cursor: pointer;
    /* padding: 18px; */
    width: 100%;
    border-radius: 5px;
    /* font-size: 15px; */
    }

    .list-output {
        background-color: #7FB3D5  ;
        padding-left: 2%;
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
        border: 1px solid #ddd;
        padding: 8px;
    }

    /* #paramater tr:nth-child(even){background-color: #f2f2f2;} */

    #paramater tr:hover {background-color: #ddd;}

    #paramater th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #D1F2EB;
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


<div href="#demo1" class="collap-output" data-toggle="collapse" >    

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
    
  <!-- <a href="#demo1" class="btn btn-primary" data-toggle="collapse">Simple collapsible</a> -->
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
    
  <!-- <a href="#demo1" class="btn btn-primary" data-toggle="collapse">Simple collapsible</a> -->
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
</div>


@endsection