@extends('layouts.main') 
@section('title','Web Service | Admin') 
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
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">WebService</span>
                        <div class="text-loading">
                            <div class="text-line md"></div>
                        </div>
                        <h6>
                            <p id="total-webservice"></p>
                        </h6>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <a href="{{action('AdminController@Add_service')}}" class="btn btn-success btn-radius">
                            <i class="fa fa-plus"></i>
                            Add Service
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="datatable-webservice">
                    <thead>
                        <tr>
                            <th>NameService(EN)</th>
                            <th>Alias</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="lds-roller text-center">
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
        </div>
    </div>
</div>

<script type="text/javascript" src="{{url('js/admin/services/service.js')}}"></script>

<script>
    $(document).ready(function () {
    });

</script>
@endsection