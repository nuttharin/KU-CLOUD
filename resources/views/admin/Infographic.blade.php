@extends('layouts.main') 
@section('title','Admin | Company') 
@section('content')

<style>
</style>

<link href="{{url('css/Infographic.css')}}" rel="stylesheet">
<link href="{{url('css/loading-text.css')}}" rel="stylesheet" />
<link href="{{url('css/animate.css')}}" rel="stylesheet">

<div class="row border-bottom">
    <div class="col-4 text-left" style="padding: 30px 0px 10px 15px">
        <span class="h4">Create Infogarphic</span>
    </div>
    <div class="col-8 text-right">
        <button type="button" class="btn btn-default btn-md" style="margin: 20px;"><i class="fas fa-desktop"></i></button>
        <button type="button" class="btn btn-primary btn-md">Download</button>
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
            <div class="col-8 select-menu" id="selectMenu" style="display:none">
                <input type="hidden" id="pathImg" value="{{url('img_test.png')}}" />
            </div>
        </div>
    </div>
    <div class="col-6">
        <!-- A4 Size -->
        <page size="A4_115" id="workspace">

        </page>        
    </div>
    <div class="col-3">
        <div class="row" id="propertySpace">
            <!--<div class="propertyMenu">
                <div class="Editdatacrispy">
                    <button type="button" class="btn btn-default Editdata" >Edit data</button>
                    <button type="button" class="btn btn-default" ><i class="fas fa-trash-alt"></i></button>
                </div>
                <div class="Scaling">
                    <div class="row">
                        <div class="col-8 rotates">
                            <span>Chart type</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="bgbright"><img src="{{url('img_test.png')}}" style="width:70%; height:70%;" />
                                <title>Line</title>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Scaling">
                    <div class="row">
                        <div class="col-8 rotates">
                            <span>Text change</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control crispyText"/>
                            <button type="button" class="btn btn-default" ><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="Scaling">
                    <div class="row">
                        <div class="col-6">
                            <span>Width (px)</span>
                            <input type="text" class="form-control crispy" />
                        </div>
                        <div class="col-6">
                            <span>Height (px)</span>
                            <input type="text" class="form-control crispy" />
                        </div>
                    </div>
                </div>
                <div class="Scaling">
                    <div class="row fontalign">
                        <div class="col-4">
                            <span>Color</span>
                        </div>
                        <div class="col-8">
                            <span>Font</span>
                        </div>
                    </div>
                    <div class="row inputalign">
                        <div class="col-4">
                            <input type="color" class="colorSP" value="#f6b73c">
                        </div>
                        <div class="col-8">
                            <select type="text" class="form-control">
                                <option>test</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="Scaling">
                    <div class="row">
                        <div class="col-8 rotates">
                            <span>Font size (pt)</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <input type="range" min="9" max="120" value="9" class="slider" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control crispysilde" />
                        </div>
                    </div>
                </div>
                <div class="Scaling">
                    <div class="row">
                        <div class="col-8 rotates">
                            <span>Rotation</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <input type="range" min="0" max="360" value="0" class="slider" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control crispysilde" />
                        </div>
                    </div>
                </div>
                <div class="Scaling">
                    <div class="row">
                        <div class="col-8 rotates">
                            <span>Transparency (%)</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <input type="range" min="0" max="100" value="0" class="slider" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control crispysilde" />
                        </div>
                    </div>
                </div>
                <div class="Grouping">
                    <div class="GroupTitle" data-toggle="collapse" data-target="#demo">
                        <i class="far fa-chart-bar"></i><span>Chart properties</span>
                    </div>
                    <div class="GroupBody" id="demo" class="collapse">
                        Lorem ipsum
                    </div>
                </div>
                <div class="Grouping">
                    <div class="GroupTitle" data-toggle="collapse" data-target="#demox">
                        <i class="fas fa-palette"></i><span>Color</span>
                    </div>
                    <div class="GroupBody" id="demox" class="collapse">
                        Lorem ipsum
                    </div>
                </div>
                <div class="Grouping">
                    <div class="GroupTitle" data-toggle="collapse" data-target="#demox">
                        <i class="fas fa-list-ul"></i><span>Legend</span>
                    </div>
                    <div class="GroupBody" id="demox" class="collapse">
                        Lorem ipsum
                    </div>
                </div>
                <div class="Grouping">
                    <div class="GroupTitle" data-toggle="collapse" data-target="#demox">
                        <i class="fas fa-comment"></i><span>Tooltips</span>
                    </div>
                    <div class="GroupBody" id="demox" class="collapse">
                        Lorem ipsum
                    </div>
                </div>             
            </div>
        </div>-->
    </div>     
</div>

<script type="text/javascript" src="{{url('js/admin/Infographic/WidgetObject.js')}}"></script>
<script type="text/javascript" src="{{url('js/admin/Infographic/Infographic.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#sidebarCollapse").click();
        $("#selectMenu").hide();
    });

</script>
@endsection