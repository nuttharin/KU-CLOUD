@extends('layouts.mainCompany') 
@section('title','Admin | Company') 
@section('content')

<link href="{{url('css/Infographic.css')}}" rel="stylesheet">
<link href="{{url('css/loading-text.css')}}" rel="stylesheet" />
<link href="{{url('css/animate.css')}}" rel="stylesheet">

<!-- Hidden Value -->
<input type="hidden" id="pathImg" value="{{url('imagemenu')}}" />
<input type="hidden" id="infoID" value="{{$id}}" />

<div class="row border-bottom">
    <div class="col-4 text-left" style="padding: 30px 0px 10px 15px">
        <span class="h4">Custom Infographic</span>
        <button class="btn btn-success btn-sm btn-radius" id="btn-add-datasource"><i class="fas fa-plus"></i> Add Datasource</button>
    </div>
    <div class="col-8 text-right">
        <button type="button" id="btn_fullscreen" class="btn btn-default btn-md" style="margin: 20px;">Preview</button>
        <button type="button" id="btn_download" class="btn btn-primary btn-md">Download</button>
        <button type="button" id="btn_save" class="btn btn-success btn-md">Save</button>
    </div>
</div>
<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-3">
        <div class="row">
            <div class="col-4 vertical-menu">
                <a href="#" id="btnGraph"><i class="fas fa-chart-line fa-2x"></i></a>
                <a href="#" id="btnMap"><i class="fas fa-map-marker-alt fa-2x"></i></a>
                <a href="#" id="btnFont"><i class="fas fa-font fa-2x"></i></a>
                <a href="#" id="btnImage"><i class="far fa-image fa-2x"></i></a>
                <a href="#" id="btnShapes"><i class="fab fa-microsoft fa-2x"></i></a>
            </div>
            <div class="col-8 select-menu-2" id="selectMenu" style="display:none">
            </div>
        </div>
    </div>
    <div class="col-6" id="workfull">
        <!-- A4 Size -->
        <page size="A4" id="workspace">
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
        var ii = 5;
        testnaja(ii);

        console.log(ii);
        });

        function testnaja(inttest)
        {
            inttest = inttest + 2;
        }
    </script>
@endsection