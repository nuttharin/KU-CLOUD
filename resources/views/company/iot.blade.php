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
    
</style>


<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-7" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Internet of Things (IoT)</span>                       
                        <h6>
                            <p id="total-iotservice"></p>
                        </h6>
                    </div>
                    <div class="col-3 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <a href="{{action('CompanyController@Add_InputIot')}}" class="btn btn-success btn-radius">
                            <i class="fa fa-plus"></i>
                            Create Input IoT
                        </a>
                    </div>
                    <div class="col-2 text-right" style="padding: 30px 15px 10px 0px;width:100%">
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
                            <th>Description</th>
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

<script>
    $(document).ready(function () {
    });

</script>
@endsection