@extends('layouts.mainCompany') 
@section('title','IoT | Company') 
@section('content')
<style>
    table {
        font-size: 14px;
    }

    .dataTables_wrapper {
        font-size: 12px;
    }
    input{
        border-radius: 4px !important;
        border: none !important;
        padding: 5px 20px !important;
        cursor: pointer !important;
        padding: 7px !important;


    }
   
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>


<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Internet of Things (IoT)</span>                       
                        <h6>
                            <p id="total-iotservice"></p>
                        </h6>
                    </div>
                    <div class="col-3 text-right" style="padding: 30px 0px 10px 15px;width:100%">
                        <a href="{{action('CompanyController@Add_InputIot')}}" class="btn btn-success btn-radius">
                            <i class="fa fa-plus"></i>
                            Create Input IoT
                        </a>
                    </div>
                    <div class="col-3 text-left" style="padding: 30px 0px 10px 15px;width:100%">
                        <a href="{{action('CompanyController@Add_OutputIot')}}" class="btn btn-warning btn-radius">
                            <i class="fa fa-plus"></i>
                            Create Output IoT
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="datatable-iotservice">
                    <thead>
                        <tr>
                            <th>NameService(EN)</th>
                            <th>Alias</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th></th>


                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
                 <!-- <div class="lds-roller text-center">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{url('js/company/iot/iot.js')}}"></script>
<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>
@endsection