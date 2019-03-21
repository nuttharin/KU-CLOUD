@extends('layouts.home')
@section('title','Dashboards')
@section('content') 

<!-- gridstack -->
<link rel="stylesheet" href="{{asset('js/gridstack/gridstack.css')}}">
<link rel="stylesheet" href="{{asset('js/gridstack/css/index.css')}}">

<!-- Leaflet -->
<link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}}" />
<link rel="stylesheet" href="{{asset('mappadcontrol/L.Control.Pan.css')}}" />
<script src="{{asset('leaflet/leaflet.js')}}"></script>
<script src="{{asset('leaflet/BoundaryCanvas.js')}}"></script>
<script src="{{asset('mappadcontrol/L.Control.Pan.js')}}"></script>
<script src="{{asset('mappadcontrol/leaflet-tilejson.js')}}"></script>
<script src="{{asset('leaflet/BoundaryCanvas.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

<script src="{{url('js/justgage-1.2.2/raphael-2.1.4.min.js')}}"></script>
<script src="{{url('js/justgage-1.2.2/justgage.js')}}"></script> 


<script src="{{asset( 'js/Leaflet.heat-gh-pages/dist/leaflet-heat.js')}} "></script>


<style type="text/css">
     body{
         background-color: #f2f8f9;
     }
     
    .grid-stack-item {}

    .grid-stack-item-content {
        color: #2c3e50;
        text-align: center;
        background-color: #FFFFFF;
        box-shadow: 1px 1px 10px 1px #aaaaaa;
    }

    /* .modal-lg {
        max-width: 1100px !important;
    } */

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

    .data-list {
        height: 200px;
        position: absolute;
        padding: 0;
        margin: 0;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 50;
    }

    .value-datasource:focus {}

    .list-group-item {
        transition: .2s;
    }

    .list-group-item:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;

    }

    .remove-value,
    .remove-param,
    .remove-datasource {
        transition: all 0.3s;
        cursor: pointer;
    }

    .remove-value:hover,
    .remove-param:hover,
    .remove-datasource:hover {
        transform: scale(1.1);
        color: #e65251
    }

    .activeApi {
        color: #00a855
    }

    .unActiveApi {
        color: #e65251
    }

    .edit-datasource:hover {
        font-weight: bold;
        color: #007bff;
    }

    .form-radar-value {
        padding: 20px;
        border: 2px solid #308ee0;
        border-radius: 27px;
        margin-bottom: 10px;
    }

    .remove-datasource-radar {
        cursor: pointer;
    }

    .remove-datasource-radar:hover {
        transition: all 0.3s;
        color: #e65251
    }

    .widget-type-data:hover {
        transition: 0.3s;
        opacity: 0.8;
    }

    .widget-type-data {
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #FFFF;
        height: 50px;
        width: 200px;
        padding: 50px;
        margin: 30px;
        border-radius: 5px;
    }

    .grid-stack>.grid-stack-item>.grid-stack-item-content {
        z-index: unset;
    }

    .btn-download {
        cursor: pointer;
    }

    icon-container {
        position: absolute;
        right: 10px;
        top: calc(50% - 10px);
    }

    .loader {
        position: relative;
        height: 20px;
        width: 20px;
        display: inline-block;
        animation: around 5.4s infinite;
    }

    @keyframes around {
        0% {
            transform: rotate(0deg)
        }

        100% {
            transform: rotate(360deg)
        }
    }

    .loader::after,
    .loader::before {
        content: "";
        background: white;
        position: absolute;
        display: inline-block;
        width: 100%;
        height: 100%;
        border-width: 2px;
        border-color: #333 #333 transparent transparent;
        border-style: solid;
        border-radius: 20px;
        box-sizing: border-box;
        top: 0;
        left: 0;
        animation: around 0.7s ease-in-out infinite;
    }

    .loader::after {
        animation: around 0.7s ease-in-out 0.1s infinite;
        background: transparent;
    }

</style>



<div id="layout-full-screen">
    <div class="modal fade" id="modal_full_screen">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h3>Time series</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" id="body-full-screen">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success btn-block">Append</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="contrainner" style="margin: 107px;">

    <div class="d-flex flex-wrap align-content-center" id="loading" style="height: 100vh">
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

</div>



<div id="layout-widget-static" hidden>
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
                <div class="static-mm">
                    <i class="far fa-clock btn-edit-time grow" title="Time" style="cursor:pointer" item="div_id"></i>
                    <i class="fas fa-arrow-down btn-download grow" title="Download" style="cursor:pointer"
                        item="div_id"></i>
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

<div id="layout-widget" hidden>
    <div>
        <div class="panel grid-stack-item-content " id="div_id" data="((data_widget))">

            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5><span class="title-widget">((title_name))</span> <span
                            class="badge badge-pill badge-success">Realtime</span></h5>
                    {{-- <span class="switch switch-sm">
                        <input type="checkbox" class="switch" id="<<switch>>">
                        <label for="<<switch>>">Realtime</label>
                    </span> --}}
                </div>
                <div class="edit-widget" style="display:none">
                    <i class="fas fa-cog btn-edit-wi grow" title="Edit widget" item="div_id"></i>
                    <i class="fas fa-trash-alt btn-delete-wi grow" title="Delete widget" item="div_id"></i>
                </div>

                <div class="download" style="display: none">
                    <div class="dropdown">
                        <i class="fas fa-arrow-down grow" data-toggle="dropdown" title="Download"
                            style="cursor:pointer"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <span class="dropdown-item btn-download" item="div_id"><i class="fas fa-image"></i>
                                Download images</span>
                            <span class="dropdown-item btn-download btn-download-excel" item="div_id"><i
                                    class="fas fa-file-excel"></i>
                                Download excel</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body" style="overflow:hidden">
                ((wi))
            </div>
            <div class="card-footer" style="background-color:#FFFF;border-top:0">
                <div class="text-right">
                    <span> <i class="fas fa-history btn-time-series grow" title="Time series" style="cursor:pointer"
                            item="div_id"></i> <span id="{last_update}">00:00:00</span></span>
                </div>
                <div class="time-series-static row text-left" style=" display: none">
                    <div class="col-12 col-md-4">
                        <label for="period">Period:</label>
                        <select name="period" class="form-control period" item="div_id">
                            <option value="Today">Today</option>
                            <option value="Yesterday">Yesterday</option>
                            <option value="Current Week">Current Week</option>
                            <option value="1 Week">1 Week</option>
                            <option value="2 Week">2 Week</option>
                            <option value="4 Week">4 Week</option>
                            <option value="Current Month">Current Month</option>
                            <option value="Last Month">Last Month</option>
                            <option value="3 Month">3 Month</option>
                            <option value="6 Month">6 Month</option>
                            <option value="12 Month">12 Month</option>
                            <option value="Custom">Custom</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4 period-custom" style="display:none">
                        <label for="start_date">Start date</label>
                        <input type="date" name="start_date" item="div_id" class="form-control start_date">
                    </div>
                    <div class="col-12 col-md-4 period-custom" style="display:none">
                        <label for="end_date">End date</label>
                        <input type="date" name="end_date" item="div_id" class="form-control end_date">
                    </div>
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
                    <h5><span class="title-widget">((title_name))</span> <span
                            class="badge badge-pill badge-success">Realtime</span></h5>
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

            <div class="card-body d-flex align-items-center align-content-center justify-content-center"
                style="overflow:hidden">
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


<div id="layout_widget_static" hidden>
    <div>
        <div class="panel grid-stack-item-content " id="div_id" data="((data_widget))">

            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5><span class="title-widget">((title_name))</span> <span
                            class="badge badge-pill badge-primary">Static</span></h5>
                </div>
                <div class="edit-widget" style="display:none">
                    <i class="fas fa-file-excel grow" title="Download excel" style="cursor:pointer" item="div_id"></i>
                    <i class="fas fa-arrow-down btn-download grow" title="Download" style="cursor:pointer"
                        item="div_id"></i>
                    <i class="fas fa-cog btn-edit-wi grow" title="Edit widget" item="div_id"></i>
                    <i class="fas fa-trash-alt btn-delete-wi grow" title="Delete widget" item="div_id"></i>
                </div>

            </div>

            <div class="card-body" style="overflow:hidden">
                ((wi))
            </div>
            <div class="card-footer" style="background-color:#FFFF;border-top:0">
                <div class="form-group">
                    <select name="type_report" id="type_report" class="form-control form-control-sm" style="width:20%"
                        item="div_id">
                        <option value="daily">Daily</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <div class="form-inline daily">
                    <label for="start_day" class="mr-sm-2 ">Start day</label>
                    <input type="date" class="form-control form-control-sm mb-2 mr-sm-2 " id="start_day" item="div_id">
                    <label for="end_day " class="mr-sm-2 ">End day</label>
                    <input type="date" class="form-control form-control-sm mb-2 mr-sm-2 " id="end_day" item="div_id">
                </div>
                <div class="form-inline monthly " style="display: none">
                    <label for="start_month " class="mr-sm-2 ">Start month</label>
                    <select name="start_month" id="start_month" class="form-control form-control-sm mb-2 mr-sm-2"
                        item="div_id">
                        <option value="0">-- Select month --</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <label for="end_month" class="mr-sm-2 ">End month</label>
                    <select name="end_month" id="end_month" class="form-control form-control-sm mb-2 mr-sm-2"
                        item="div_id">
                        <option value="0">-- Select month --</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="form-inline yearly" style="display: none">
                    <label for="start_year" class="mr-sm-2 ">Start year</label>
                    <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" id="start_year"
                        item="div_id">
                    <label for="end_year" class="mr-sm-2 ">End year</label>
                    <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" id="end_year" item="div_id">
                </div>
            </div>

        </div>
    </div>
</div>

<span id="static_id" hidden>{{$id}}</span>



<!-- moment  -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>

<script src="{{asset( 'js/Leaflet.heat-gh-pages/dist/leaflet-heat.js')}} "></script>

<script src="{{asset( 'js/company/gauge/gauge.min.js')}} "></script>

<script src="{{asset( 'js/canvas-toBlob/canvas-toBlob.js')}} "></script>

<script type="text/javascript " src="{{asset( 'js/gridstack/gridstack.js')}} "></script>
<script type="text/javascript " src="{{asset( 'js/gridstack/gridstack.jQueryUI.js')}} "></script>

<script src="{{ mix( '/js/dashboards/DashboardPublic.min.js') }} "></script>

<script src="{{ asset( '/js/justgage-1.2.2/justgage.js') }} "></script>
<script src="{{ asset( '/js/justgage-1.2.2/raphael-2.1.4.min.js') }} "></script>


<script type="text/javascript " src="{{asset( 'js/sweetalert/sweetalert.min.js')}} "></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js "></script>

@endsection
