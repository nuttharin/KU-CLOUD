@extends('layouts.mainCompany') 
@section('title','Admin | Company') 
@section('content')

<link href="{{url('css/Infographic.css')}}" rel="stylesheet">
<link href="{{url('css/loading-text.css')}}" rel="stylesheet" />
<link href="{{url('css/animate.css')}}" rel="stylesheet">

<!-- Hidden Value -->
<input type="hidden" id="pathImg" value="{{url('imagemenu')}}" />
<input type="hidden" id="infoID" value="{{$id}}" />
<input type="hidden" id="infoName" value="{{$keyfilename}}" />

<div class="row border-bottom">
    <div class="col-4 text-left" style="padding: 30px 0px 10px 15px">
        <span class="h4">Custom Infographic</span>
        <button class="btn btn-success btn-sm btn-radius" id="btn-add-datasource"><i class="fas fa-plus"></i> Add Datasource</button>
    </div>
    <div class="col-8 text-right">
        <button type="button" id="btn_fullscreen" class="btn btn-default btn-md" style="margin: 20px;">Preview</button>
        <div class="btn-group">
        <button type="button" class="btn btn-primary btn-md dropdown-toggle" data-toggle="dropdown">Download <span class="caret"></span></button>
            <ul class="dropdown-menu" id="btn_download_list" role="menu">
                <a class="dropdown-item" href="#" valuetype="pdf"><i class="far fa-file-pdf" style="margin-right:10px"></i>Save as PDF</a>
                <a class="dropdown-item" href="#" valuetype="image"><i class="far fa-image" style="margin-right:10px"></i>Save as image</a>
            </ul>
        </div>
        <button type="button" id="btn_save" class="btn btn-success btn-md">Save</button>
    </div>
</div>
<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-3">
        <div class="row">
            <div class="col-4" style="max-height:max-content;">
                <!-- <div class="row  justify-content-center">
                    <div class="d-menu">
                        <div class="row main-menu">
                            <i class="fas fa-paint-brush fa-2x"></i>
                        </div>
                        <div class="row child-menu">
                            <i class="fas fa-paint-brush fa-2x"></i>
                        </div>
                    </div>

                    <div class="d-line">
                        <div class="line-menu"></div>
                    </div>

                </div> -->
                <div class=" vertical-menu">
                    <a href="#" id="btnGraph"><i class="fas fa-chart-line fa-2x"></i></a>
                    <a href="#" id="btnMap"><i class="fas fa-map-marker-alt fa-2x"></i></a>
                    <a href="#" id="btnFont"><i class="fas fa-font fa-2x"></i></a>
                    <a href="#" id="btnImage"><i class="far fa-image fa-2x"></i></a>
                    <a href="#" id="btnShapes"><i class="fab fa-microsoft fa-2x"></i></a>
                </div>
            </div>
            <div class="col-8 select-menu-2" id="selectMenu" style="display:none">
            </div>
        </div>
    </div>
    <div class="col-6" id="workfull">
        <!-- A4 Size -->
        <page size="A4DEMO" id="workspace">
        </page>
    </div>
    <div class="col-3">
        <div class="row" id="propertySpace">
            <!--Comment-->
            <!-- <div class="propertyMenu-2">
                <div class="propertyMenu-2-context">
                    <div class="container">
                        <div class="row row-block border-bottom-only">
                            <div class="col-2">
                                <button type="button" class="btn btn-default"><i class="far fa-caret-square-down"></i></button>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-default"><i class="far fa-caret-square-up"></i></button>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-default"><i class="fas fa-align-left"></i></button>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-default"><i class="fas fa-align-center"></i></button>
                            </div>
                            <div class="col-2">         
                                <button type="button" class="btn btn-default"><i class="fas fa-align-right"></i></button>
                            </div>
                        </div>
                        <div class="row row-block">
                            <div class="col-7">
                                <button type="button" class="btn btn-default form-control">Download</button>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-default" ><i class="fas fa-desktop"></i></button>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-default" ><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="propertyMenu-2-paper">
                    <div class="propertyMenu-2-block">
                        <button type="button" class="btn btn-default form-control button-width">Edit data</button>     
                    </div>
                    <div class="propertyMenu-2-block">
                        <button type="button" class="btn btn-default form-control button-width">Import data</button>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <button type="button" class="btn btn-default form-control button-width">Crop image</button>     
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Text change</span>
                            </div>
                            <div class="row row-block">
                                <input type="text" class="form-control"/>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>New column name</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-7">
                                    <input type="text" class="form-control"/>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-default" ><i class="fas fa-angle-right"></i></button>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-default" ><i class="fas fa-angle-down"></i></button>
                                </div>
                            </div>
                            <div class="row-block">
                                <button type="button" class="btn btn-default form-control button-width">Delete column</button>
                            </div>
                            <div class="row-block">
                                <button type="button" class="btn btn-default form-control button-width">Delete row</button>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Themes</span>
                            </div>
                            <div class="row row-block">
                                <select type="text" class="form-control">
                                    <option>test</option>
                                </select>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <div class="col-6">
                                    <span>Width (px)</span>
                                </div>
                                <div class="col-6">
                                    <span>Height (px)</span>
                                </div>
                            </div>
                            <div class="row row-block">
                                <div class="col-6">
                                    <input type="text" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <div class="col-6 text-align-left">
                                    <span>Color</span>
                                </div>
                                <div class="col-6 text-align-left">
                                    <span>Font</span>
                                </div>
                            </div>
                            <div class="row row-block">
                                <div class="col-6">
                                    <input type="color" class="form-control" value="#f6b73c">
                                </div>
                                <div class="col-6">
                                    <select type="text" class="form-control">
                                        <option>test</option>
                                    </select>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Color</span>
                            </div>
                            <div class="row row-block">
                                <input type="color" class="form-control" value="#f6b73c">
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <div class="col-4">
                                    <button type="button" class="btn btn-default" ><i class="fas fa-minus"></i></button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-default" ><i class="fas fa-ellipsis-h"></i></button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-default" ><i class="fas fa-equals"></i></button>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Font size (pt)</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-8" style="padding-left:0px;">
                                    <input type="range" min="9" max="120" value="9" class="slider" />
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Rotation</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-8" style="padding-left:0px;">
                                    <input type="range" min="0" max="360" value="0" class="slider" />
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Transparency (%)</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-8" style="padding-left:0px;">
                                    <input type="range" min="0" max="100" value="0" class="slider" />
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Border radius (%)</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-8" style="padding-left:0px;">
                                    <input type="range" min="0" max="50" value="0" class="slider" />
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Border width (px)</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-8" style="padding-left:0px;">
                                    <input type="range" min="5" max="20" value="0" class="slider" />
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="propertyMenu-2-block">
                        <div class="container">
                            <div class="row row-block">
                                <span>Chart properties</span>
                            </div>
                            <div class="row row-block">
                                <div class="col-4">
                                    <input type="color" class="form-control" value="#f6b73c">
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="row row-block">
                                <div class="col-4">
                                    <input type="color" class="form-control" value="#f6b73c">
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div> -->
            <!--Comment-->
            <!-- <input type="text" list="testinput" id="testvalue" class="form-control" />
            <datalist id="testinput">
                <option id="0" value="Internet Explorer">IE</option>
                <option id="1" value="Firefox">FF</option>
                <option id="2" value="Chrome">CH</option>
                <option id="3" value="Opera">OP</option>
                <option id="4" value="Safari">SA</option>
            </datalist>  -->
            <span id="testvalue"></span>
        </div>
    </div>
</div>

    <script src="{{ mix('/js/admin/Infographic/WidgetObject.min.js') }}"></script>
    <script src="{{ mix('/js/admin/Infographic/DataSource.min.js') }}"></script>
    <script src="{{ mix('/js/admin/Infographic/Infographic.min.js') }}"></script>
    <script>
        $(document).ready(function () {
        $("#sidebarCollapse").click();
        $("#selectMenu").hide();
        // $("#testvalue").val("Firefox");
        // console.log(document.getElementById('testinput'));

        // $("#testvalue").change( function(){

        //     console.log($("#testvalue").val());
        //     console.log($("#testinput option:selected").attr('id'));
        // });

        var data = `[{"Vehicle":"BMW","Date":"30, Jul 2013 09:24 AM","Location":"Hauz Khas, Enclave, New Delhi, Delhi, India","Speed":42},{"Vehicle":"Honda CBR","Date":"30, Jul 2013 12:00 AM","Location":"Military Road,  West Bengal 734013,  India","Speed":0},{"Vehicle":"Supra","Date":"30, Jul 2013 07:53 AM","Location":"Sec-45, St. Angel's School, Gurgaon, Haryana, India","Speed":58},{"Vehicle":"Land Cruiser","Date":"30, Jul 2013 09:35 AM","Location":"DLF Phase I, Marble Market, Gurgaon, Haryana, India","Speed":83},{"Vehicle":"Suzuki Swift","Date":"30, Jul 2013 12:02 AM","Location":"Behind Central Bank RO, Ram Krishna Rd by-lane, Siliguri, West Bengal, India","Speed":0},{"Vehicle":"Honda Civic","Date":"30, Jul 2013 12:00 AM","Location":"Behind Central Bank RO, Ram Krishna Rd by-lane, Siliguri, West Bengal, India","Speed":0},{"Vehicle":"Honda Accord","Date":"30, Jul 2013 11:05 AM","Location":"DLF Phase IV, Super Mart 1, Gurgaon, Haryana, India","Speed":71}]`;
        
        // JSONToCSVConvertor(data, "Vehicle Report", true);
        });


        function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


    </script>
@endsection