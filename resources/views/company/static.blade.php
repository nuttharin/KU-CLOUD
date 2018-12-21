@extends('layouts.mainCompany') 
@section('title','Static | Company') 
@section('content') {{--
<script src="{{url('js/justgage-1.2.2/raphael-2.1.4.min.js')}}"></script>
<script src="{{url('js/justgage-1.2.2/justgage.js')}}"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

<script src="{{url('js/Leaflet.heat-gh-pages/dist/leaflet-heat.js')}}"></script>

<script src="{{url('js/company/gauge/gauge.min.js')}}"></script>

<script src="{{url('js/canvas-toBlob/canvas-toBlob.js')}}"></script>


<style type="text/css">
    .grid-stack-item {}

    .grid-stack-item-content {
        color: #2c3e50;
        text-align: center;
        background-color: #FFFFFF;
        box-shadow: 1px 1px 10px 1px #aaaaaa;
    }

    .modal-lg {
        max-width: 1100px !important;
    }

    .modal-header-custom {
        border-bottom: 0;
    }

    .card {
        box-shadow: none;
    }

    #btn-detail-toggle {
        -moz-transition: transform 0.3s;
        -webkit-transition: transform 0.3s;
        transition: transform 0.3s;
    }

    .flip {
        transform: rotate(180deg);
    }

    #data-list {
        height: 200px;
        position: absolute;
        padding: 0;
        margin: 0;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 50;
    }

    .list-group-item:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .remove-value {
        cursor: pointer;
    }

    .remove-value:hover {
        transition: all 0.3s;
        color: #e65251
    }

    .activeApi {
        color: #00a855
    }

    .unActiveApi {
        color: #e65251
    }

    .grow:hover {
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
    }

    .edit-datasource:hover {
        font-weight: bold;
        color: #007bff;
    }
</style>

<div id="layout-full-screen">
    <div class="modal fade" id="modal-full-screen">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" id="body-full-screen">
                    <div>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control">
                                    <option>รายวัน</option>
                                    <option>รายเดือน</option>
                                    <option>รายปี</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="content-widget" style="height:450px;width:auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row border-bottom" style="padding: 30px 0px 10px 15px">
    <div class="row" style="width:100%" id="top-header">
        <div class="col-6 d-flex align-content-center">
            <h3 class="mr-2">Static</h3>
            <button class="btn btn-success btn-sm btn-radius" id="btn-add-datasource"><i class="fas fa-plus"></i> Add Datasource</button>
        </div>
        <div class="col-6 text-right">
            <button class="btn btn-success btn-radius" id="addW" style="display:none"><i class="fa fa-plus"></i> Add Widget</button>
            <button class="btn btn-warning btn-radius" id="settingW"><i class="fas fa-cog"></i></button>
            <button class="btn btn-primary btn-radius" id="saveW" style="display:none"><i class="fas fa-save"></i></button>
            <button class="btn btn-danger btn-radius" id="cancelW" style="display:none"><i class="fas fa-times"></i></button>
        </div>
        <div class="col-12" id="list-datasource">

        </div>
    </div>

    <div class="col-12 d-flex justify-content-center">
        <i class="fas fa-angle-up fa-lg" id="btn-detail-toggle" style="cursor:pointer"></i>
    </div>

</div>
<br />

<div class="contrainner">
    <div class="d-flex flex-wrap align-content-center" id="loading" style="height:500px">
        <div class="lds-ring text-center mx-auto">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="grid-stack"></div>
    <!-- <textarea id="saved-data" cols="100" rows="20" readonly="readonly"></textarea> -->

    <div class="modal fade" id="addWidget">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add Widget</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <label>Widget Type</label>
                            <select class="form-control" id="widget_type">
                            <option value="">--Select Widget Type--</option>
                            <option value="MutiLine">MutiLine</option>
                            <option value="TextLine">Text Line</option>
                            <option value="Rader">Rader</option>
                            <option value="Gauges">Gauges</option>
                            <option value="Map">Map</option>
                            <option value="TextValue">TextValue</option>
                            <option value="TextBox">TextBox</option>
                        </select>
                        </div>
                    </div>

                    <div id="default-value" class="row">
                        <div class="col-6">
                            <label>Title</label>
                            <input type="text" name="title-name" id="title-name" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="">Set time interval (s)</label>
                            <input type="number" id="time-interval" class="form-control">
                        </div>
                    </div>

                    <div id="text-box" class="value_widget" style="display:none;">
                        <div class="row">
                            <div class="col-6">
                                <label>Text</label>
                                <input type="text" id="text-custom" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label>Font Size (px)</label>
                                <input type="number" id="font-size" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div id="MutiLine" class="value_widget" style="display:none;">
                        <h5>Select Value Of Y</h5>
                        <button class="btn btn-primary btn-sm btn-radius" id="btn-add-value-Mutiline">
                            <i class="fa fa-plus"></i> 
                            Add Line Value Of Y
                        </button>
                        <div id="Mutiline_value">
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Datasource</label>
                                    <select class="form-control select-datasource">
                                        
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">Value</label>
                                    <input class="form-control value-datasource">
                                    <ul id="data-list" class="list-group">
                                </div>
                                <div class="col-3">
                                    <label for="">Label</label>
                                    <input type="text" class="form-control label-y-chart-line">
                                </div>
                                <div class="col-2">
                                    <label for="">RGB</label>
                                    <input type="color" id="rgb" class="form-control rgb-chart-line" value="#f6b73c">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Gauges" class="value_widget" style="display:none;">
                        <div class="row">
                            <div class="col-4">
                                <label>limitMin</label>
                                <input type="number" name="limitMin" id="g_limitMin" class="form-control">
                            </div>

                            <div class="col-4">
                                <label>limitMax</label>
                                <input type="number" name="limitMax" id="g_limitMax" class="form-control">
                            </div>

                            <div class="col-4">
                                <label>Unit</label>
                                <input type="text" name="unit" id="unit" class="form-control">
                            </div>
                        </div>
                        <h5>Select Datasource</h5>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Datasource</label>
                                <select class="form-control select-datasource">
                                            
                                        </select>
                            </div>
                            <div class="col-6">
                                <label for="">Value</label>
                                <input class="form-control value-datasource">
                                <ul id="data-list" class="list-group">
                            </div>
                        </div>
                    </div>
                    <div id="text-line" class="value_widget" style="display:none;">
                        <div class="row">
                            <div class="col-6">
                                <label>Unit</label>
                                <input type="text" id="unit" class="form-control" />
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        <h5>Select Datasource</h5>
                        <div class="row" id="value-text-line">
                            <div class="col-4">
                                <label for="">Datasource</label>
                                <select class="form-control select-datasource">
                                            
                                        </select>
                            </div>
                            <div class="col-4">
                                <label for="">Value</label>
                                <input class="form-control value-datasource">
                                <ul id="data-list" class="list-group">
                            </div>
                            <div class="col-4">
                                <label for="">RGB</label>
                                <input id="rgb" type="color" class="form-control  rgb-chart-line" value="#f6b73c">
                            </div>
                        </div>
                    </div>
                    <div id="TextValue" class="value_widget" style="display:none;">
                        <div class="row">
                            <div class="col-6">
                                <label>Unit</label>
                                <input id="unit" type="text" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label>Color</label>
                                <input id="rgb" type="color" class="form-control" value="#f6b73c">
                            </div>
                        </div>
                        <h5>Select Datasource</h5>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Datasource</label>
                                <select class="form-control select-datasource">
                                    
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="">Value</label>
                                <input class="form-control value-datasource">
                                <ul id="data-list" class="list-group">
                            </div>
                        </div>
                    </div>
                    <div id="map" class="value_widget" style="display:none;">
                        <!--<div class="row">
                        <div class="col-6">
                            <label for="">Latitude</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="">Longitude</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>-->
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success btn-block" id="add-new-widget" href="#">Add Widget</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDatasource">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add Datasource</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Name</label>
                            <input type="text" id="name_datasource" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Channel</label>
                            <select name="" id="webservice_id" class="form-control">
                                <option value="">--Select Channel--</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="">Set time interval (s)</label>
                            <input type="number" id="add-data-time-interval" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-success btn-block" id="btn-add-new-datasource" href="#">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="line_value_layout" hidden>
    <div class="row">
        <div class="col-3">
            <label for="">Datasource</label>
            <select class="form-control select-datasource">
                    
            </select>
        </div>
        <div class="col-3">
            <label for="">Value</label>
            <input class="form-control value-datasource">
            <ul id="data-list" class="list-group">
        </div>
        <div class="col-3">
            <label for="">Label</label>
            <input type="text" class="form-control label-y-chart-line">
        </div>
        <div class="col-2">
            <label for="">RGB</label>
            <input type="color" class="form-control  rgb-chart-line" value="#f6b73c">
        </div>
        <div class="col-1 d-flex align-items-center" style="margin-top:30px">
            <i class="fas fa-trash-alt remove-value"></i>
        </div>
    </div>
</div>
{{--
<div class="panel__header__min ml-auto edit-widget">
    <i class="fas fa-cog btn-edit-wi" item="div_id"></i>
    <i class="fas fa-trash-alt btn-delete-wi" item="div_id"></i>
</div>
<header class="panel__header__min">
    <h5>((title_name))</h5>
</header>
<div class="panel__content">
    ((wi))
</div> --}}
<div id="layout-widget" hidden>
    <div>
        <div class="panel grid-stack-item-content" id="div_id" data="((data_widget))">


            {{--
            <div class="panel__header__min ml-auto edit-widget">
                <i class="fas fa-cog btn-edit-wi" item="div_id"></i>
                <i class="fas fa-trash-alt btn-delete-wi" item="div_id"></i>
            </div>
            <header class="panel__header__min">
                <h5>((title_name))</h5>
            </header>
            <div class="panel__content">
                ((wi))
            </div>

            <div class="card-footer" style="background-color:#FFFF;border-top:0">
                <div class="text-right">
                    <span>Last Update <span id="{last_update}">00:00:00</span></span>
                </div>
            </div> --}}



            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="title-widget">((title_name))</h5>
                </div>
                <div class="edit-widget" style="display:none">
                    <i class="fas fa-cog btn-edit-wi grow" title="Edit widget" item="div_id"></i>
                    <i class="fas fa-trash-alt btn-delete-wi grow" title="Delete widget" item="div_id"></i>
                </div>
                <div class="full-screen">
                    <i class="fas fa-expand btn-full-screen grow" title="Full screen" style="cursor:pointer" item="div_id"></i>
                    <i class="fas fa-arrow-down btn-download grow" title="Download" style="cursor:pointer" item="div_id"></i>
                </div>
            </div>

            <div class="card-body" style="overflow:hidden">
                ((wi))
            </div>
            <div class="card-footer" style="background-color:#FFFF;border-top:0">
                <div class="text-right">
                    <span>{{--Last Update --}}<span id="{last_update}">00:00:00</span></span>
                </div>
            </div>


        </div>
    </div>
</div>

<div id="layout-widget-text" hidden>
    <div>
        <div class="panel grid-stack-item-content" id="div_id" data="((data_widget))">
            <div class="panel__header__min ml-auto edit-widget">
                <i class="fas fa-cog btn-edit-wi grow" item="div_id"></i>
                <i class="fas fa-trash-alt btn-delete-wi grow" item="div_id"></i>
            </div>
            <div class="panel__content d-flex align-items-center align-content-center">
                ((wi))
            </div>
        </div>
    </div>
</div>

<div id="layout-widget-text-value" hidden>
    <div>
        <div class="panel grid-stack-item-content" id="div_id" data="((data_widget))">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="title-widget">((title_name))</h5>
                </div>
                <div class="edit-widget" style="display:none">
                    <i class="fas fa-cog btn-edit-wi grow" title="Edit widget" item="div_id"></i>
                    <i class="fas fa-trash-alt btn-delete-wi grow" title="Delete widget" item="div_id"></i>
                </div>
                {{--
                <div class="full-screen">
                    <i class="fas fa-expand btn-full-screen" title="Full screen" style="cursor:pointer" item="div_id"></i>
                </div> --}}
            </div>

            <div class="card-body d-flex align-items-center align-content-center justify-content-center" style="overflow:hidden">
                ((wi))
            </div>
            <div class="card-footer" style="background-color:#FFFF;border-top:0">
                <div class="text-right">
                    <span>{{--Last Update --}}<span id="{last_update}">00:00:00</span></span>
                </div>
            </div>


        </div>
    </div>
</div>

<span id="static_id" hidden>{{$id}}</span>
<script src="{{ mix('/js/company/static/dashboard.min.js') }}"></script>

<script src="{{ url('/js/justgage-1.2.2/justgage.js') }}"></script>
<script src="{{ url('/js/justgage-1.2.2/raphael-2.1.4.min.js') }}"></script>

<script type="text/javascript" src="{{url('js/gridstack/gridstack.js')}}"></script>
<script type="text/javascript" src="{{url('js/gridstack/gridstack.jQueryUI.js')}}"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
@endsection