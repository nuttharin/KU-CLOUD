@extends('layouts.mainCompany') 
@section('title','Static | Company') 
@section('content')

<script src="{{url('js/justgage-1.2.2/raphael-2.1.4.min.js')}}"></script>
<script src="{{url('js/justgage-1.2.2/justgage.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

<script src="{{url('js/Leaflet.heat-gh-pages/dist/leaflet-heat.js')}}"></script>

<style type="text/css">
    .grid-stack-item {}

    .grid-stack-item-content {
        color: #2c3e50;
        text-align: center;
        background-color: #FFFFFF;
        box-shadow: 1px 1px 10px 1px #aaaaaa;
    }

    element.style {
        width: 100% !important;
    }

    .modal-lg {
        max-width: 1100px !important;
    }
</style>

<div class="row border-bottom">
    <div class="col-6" style="padding: 30px 0px 10px 15px">
        <span class="h3">Static</span>
    </div>
    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px">
        <button class="btn btn-success btn-radius" id="addW" style="display:none"><i class="fa fa-plus"></i> Add Widget</button>
        <button class="btn btn-warning btn-radius" id="settingW"><i class="fas fa-cog"></i></button>
        <button class="btn btn-info btn-radius" id="saveW" style="display:none"><i class="fas fa-save"></i></button>
    </div>
</div>
<br />

<div class="contrainner">
    <div class="grid-stack"></div>
    <!-- <textarea id="saved-data" cols="100" rows="20" readonly="readonly"></textarea> -->

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add Widget</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <label>Title</label>
                            <input type="text" name="title-name" id="title-name" class="form-control">
                        </div>
                        <div class="col-6">
                            <label>Widget Type</label>
                            <select class="form-control" id="widget_type">
                            <option value="">--Select Widget Type--</option>
                            <option value="MutiLine">MutiLine</option>
                            <option value="Gauges">Gauges</option>
                            <option value="Map">Map</option>
                            <option value="Half Circle">Half Circle</option>
                            <option value="text">Text</option>
                            <option value="text-line">Text Line</option>
                        </select>
                        </div>
                    </div>

                    <div id="text-box" class="value_widget" style="display:none;">
                        <label>Text</label>
                        <input type="text" id="text-custom" class="form-control" />
                    </div>

                    <div id="MutiLine" class="value_widget" style="display:none;">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Set time interval</label>
                                <input type="number" id="time-interval" class="form-control">
                            </div>
                        </div>

                        <br />
                        <h5>Select Value Of Y</h5>
                        <button class="btn btn-primary btn-sm btn-radius" id="btn-add-value-Mutiline">
                            <i class="fa fa-plus"></i> 
                            Add Line Value Of Y
                        </button>
                        <div>
                            <div class="row" id="Mutiline_value">
                                <div class="col-3">
                                    <label for="">Channel</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="">Resource</label>
                                    <select name="" id="" class="form-control value-y-chart-line"></select>
                                </div>
                                <div class="col-3">
                                    <label for="">Label</label>
                                    <input type="text" class="form-control label-y-chart-line">
                                </div>
                                <div class="col-3">
                                    <label for="">RGB</label>
                                    <input type="text" id="rgb" class="form-control demo rgb-chart-line" data-format="rgb" value="rgb(33, 147, 58)">
                                </div>
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
                        <div class="row" id="value-text-line">
                            <div class="col-4">
                                <label for="">Channel</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="">Resource</label>
                                <select name="" id="" class="form-control value-y-chart-line"></select>
                            </div>
                            <div class="col-4">
                                <label for="">RGB</label>
                                <input type="text" id="rgb" class="form-control demo rgb-chart-line" data-format="rgb" value="rgb(33, 147, 58)">
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
</div>

<div id="line_value_layout" hidden>
    <div class="col-3">
        <label for="">Channel</label>
        <input type="text" class="form-control">
    </div>
    <div class="col-3">
        <label for="">Resource</label>
        <select name="" id="" class="form-control value-y-chart-line"></select>
    </div>
    <div class="col-3">
        <label for="">Label</label>
        <input type="text" class="form-control label-y-chart-line">
    </div>
    <div class="col-3">
        <label for="">RGB</label>
        <input type="text" id="rgb" class="form-control demo rgb-chart-line" data-format="rgb" value="rgb(33, 147, 58)">
    </div>
</div>

<div id="layout-widget" hidden>
    <div>
        <div class="panel grid-stack-item-content" id="div_id" data="((data_widget))">
            <div class="panel__header__min ml-auto edit-widget">
                <i class="fas fa-cog"></i>
                <i class="fas fa-trash-alt btn-delete-wi" item="div_id"></i>
            </div>
            <header class="panel__header__min">
                <h5>((title_name))</h5>
            </header>
            <div class="panel__content">((wi))</div>
        </div>
    </div>
</div>

{{--
<script src="{{url('js/company/widget.js')}}"></script> --}}
<script src="{{url('js/company/static/dashboard.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function () {

    });

</script>
@endsection