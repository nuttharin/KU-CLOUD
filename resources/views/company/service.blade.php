@extends('layouts.mainCompany')
@section('title','Web Service | Company')
@section('content')
<style>
    table{
        font-size:14px; 
    }
    .dataTables_wrapper {
    font-size: 12px;
    }
</style>
<div class="row border-bottom">
    <div class="col-6" style="padding: 30px 0px 10px 15px">
        <span class="h3">WebService</span>
    </div>
    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
        <a href="{{action('CompanyController@Add_service')}}" class="btn btn-success btn-radius">
            <i class="fa fa-plus"></i>
            Add Service
        </a>
    </div>
</div>
<br>

<div class="row">
    <div class="col-6">
        <h6>Number of registered web services is 2 </h6>
    </div>

</div>

<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap"
                    id="example">
                    <thead>
                        <tr>
                            <th>NameService(EN)</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th></th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{url('Company/Service/ShowService')}}">Weather3Hours</a></td>
                            <td><a href="{{url('Company/Service/ShowService')}}>">สภาพอากาศทุกๆ3ชั่วโมง</a></td>
                            <td>Active</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>WeatherForecast7Days</td>
                            <td>สภาพอากาศทุกล่วงหน้า 7 วัน</td>
                            <td>Inactive</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
