@extends('layouts.main') 
@section('title','Admin | Static') 
@section('content') {{--
<script src="{{url('js/justgage-1.2.2/raphael-2.1.4.min.js')}}"></script>
<script src="{{url('js/justgage-1.2.2/justgage.js')}}"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

<script src="{{url('js/Leaflet.heat-gh-pages/dist/leaflet-heat.js')}}"></script>

<script src="{{url('js/company/gauge/gauge.min.js')}}"></script>

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
<div class="row border-bottom">
  <div class="col-6" style="padding: 30px 0px 10px 15px">
    <span class="h3">Static</span>
  </div>
  <div class="col-6 text-right" style="padding: 30px 15px 10px 0px">
    <button class="btn btn-success btn-radius" id="addW" style="display:none"><i class="fa fa-plus"></i> Add Widget</button>
    <button class="btn btn-warning btn-radius" id="settingW"><i class="fas fa-cog"></i></button>
    <button class="btn btn-primary btn-radius" id="saveW" style="display:none"><i class="fas fa-save"></i></button>
    <button class="btn btn-danger btn-radius" id="cancelW" style="display:none"><i class="fas fa-times"></i></button>
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

  <div class="modal fade" id="myModal">
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
                            <option value="text-line">Text Line</option>
                            <option value="Gauges">Gauges</option>
                            <option value="Map">Map</option>
                            <option value="TextBox">TextBox</option>
                            {{-- <option value="Half Circle">Half Circle</option> --}}   
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
                <input id="rgb" type="color" class="form-control  rgb-chart-line" value="#f6b73c">
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
    <input type="color" class="form-control  rgb-chart-line" value="#f6b73c">
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
          <h5>((title_name))</h5>
        </div>
        <div class="edit-widget" style="display:none">
          <i class="fas fa-cog btn-edit-wi" title="Edit widget" item="div_id"></i>
          <i class="fas fa-trash-alt btn-delete-wi" title="Delete widget" item="div_id"></i>
        </div>
        <div class="full-screen">
          <i class="fas fa-expand btn-full-screen" title="Full screen" style="cursor:pointer" item="div_id"></i>
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
        <i class="fas fa-cog btn-edit-wi" item="div_id"></i>
        <i class="fas fa-trash-alt btn-delete-wi" item="div_id"></i>
      </div>
      <div class="panel__content d-flex align-items-center align-content-center">
        ((wi))
      </div>
    </div>
  </div>
</div>

{{--
<script src="{{url('js/company/widget.js')}}"></script> --}} {{--
<script src="{{url('js/test1234.js')}}"></script> --}}
<script src="{{ mix('/js/company/static/dashboard.min.js') }}"></script>
{{--
<script src="{{url('js/company/static/dashboard.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script>
  $(document).ready(function(){
        // $.ajax({
        //         url: "http://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/region?region=C&fields=tc,rh&date=2018-10-25",
        //         headers: { 
        //             'Content-Type': 'application/json', 
        //             'authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU3Njk5YzY5ZDY0YjVkNDUzNGFiOGUyM2QyMmY0MTdmMjA0NTQ2ZGU5N2Q2OGZjOGU3MTFjNWRjYjJlZTk0NDE0OWNmMjBiZDIzYmIwMmZlIn0.eyJhdWQiOiIyIiwianRpIjoiZTc2OTljNjlkNjRiNWQ0NTM0YWI4ZTIzZDIyZjQxN2YyMDQ1NDZkZTk3ZDY4ZmM4ZTcxMWM1ZGNiMmVlOTQ0MTQ5Y2YyMGJkMjNiYjAyZmUiLCJpYXQiOjE1MzY5MzA1OTQsIm5iZiI6MTUzNjkzMDU5NCwiZXhwIjoxNTY4NDY2NTk0LCJzdWIiOiIyNjUiLCJzY29wZXMiOltdfQ.YpNDR_qqohsKFikhEl1Ghc06yK7E6Aqeg8khUInXuNPKSw6X7_isXZgb3CYZFY9rYLt28VGrHmvqJMUM3Qz13vdI0G2BtEjtvAmoKVgaTWOGkT34igx68AyIDrzw2g-dD6aFlo50KCMMnAP8u7dwqBX9VU4yKc3dsMAIkGu9-lkmuJKL0_Tfx_DiNfIr5AOZAX_ME6R5zjVoiCFnGtX6frVoLc8WH6N5AK2yQrN-gjJwnLYFCS7lkmEtTSxavf-MigVijYRDtjAeO5vqd_uADCjyWsLMQ2BX27pnq09srvfgrhrUGq7w9Qm4IhYRUMHqKouQT9AyGC9nQm_EBHAovtXkjWMObw87ucewTK2BXDhaV3zOe9Ww_Nv2kVMvf5mIl4zMZKp-BjRY0RKBoDg1xfm11IdVzwaiHYSRnMhMDgXcAYRBgxdTNjWLlGlVrapA6GgYatG6-Mie1iuuuhJfah2EzYwTwEuXqwh3cctl5FSxC0JsDtAo8DOYCq_Esbth0nPc4cpFL9YFHaE-vO1Sj-qNBA4b6x8EOGh_rdkOnqEOAVqxKe9lio9jM1N8EOenOlTpmUDB95w8hfI1j_KdpqQqy1zgGRn_BgrHnZJxDeOXKNMfgBtMfD3aQreU75InECJ8_5uCmgtSeYF0bjgAmBYd37yJo9zprO0MNBeEGLk'
        //         },
        //         crossDomain: true,
        //         success: (res) => {
        //             console.log(res);
        //         },
        //         error: (res) => {
        //             console.log(res);
        //         }
        //     });

        //     $.ajax({
        //     url: "http://localhost:8081/Weather3Hours/get_all",
        //     success: (res) => {
        //         console.log(res);
        //     },
        //     error: (res) => {
        //         console.log(res);
        //     }
        // });
    })

</script>
@endsection