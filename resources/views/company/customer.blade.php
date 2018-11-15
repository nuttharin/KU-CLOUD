@extends('layouts.mainCompany') 
@section('title','Customer | Company') 
@section('content')
<style>
    table {
        font-size: 14px;
    }

    .dataTables_wrapper {
        font-size: 12px;
    }

    }
</style>

<link href="{{url('css/loading-text.css')}}" rel="stylesheet" />
<link href="{{url('css/animate.css')}}" rel="stylesheet">

<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Customer</span>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn-add-user">
                            <i class="fa fa-plus"></i>
                            Create
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card card-statistics bg-primary text-white">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <i class="mdi mdi-account-multiple icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <div class="text-loading">
                                            <div class="text-line md"></div>
                                            <div class="text-line lg ml-auto" style="width:100px"></div>
                                        </div>
                                        <div class="text-static animated fadeIn" style="display:none">
                                            <p class="mb-0 text-right">Total User</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0" id="total-user">0 User</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card card-statistics bg-success text-white">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <i class="mdi mdi-account-multiple icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <div class="text-loading">
                                            <div class="text-line md"></div>
                                            <div class="text-line lg ml-auto" style="width:100px"></div>
                                        </div>
                                        <div class="text-static animated fadeIn" style="display:none">
                                            <p class="mb-0 text-right">Total User Online</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0" id="total-user-online">0 User</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card card-statistics bg-secondary text-white">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <i class="mdi mdi-account-multiple icon-lg"></i>
                                    </div>
                                    <div class="float-right">
                                        <div class="text-loading">
                                            <div class="text-line md"></div>
                                            <div class="text-line lg ml-auto" style="width:100px"></div>
                                        </div>
                                        <div class="text-static animated fadeIn" style="display:none">
                                            <p class="mb-0 text-right">Total User Offline</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0" id="total-user-offline">0 User</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row" style="padding: 30px 0px 10px 0px">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table style="width: 100%;display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Active</th>
                            <th>Status</th>
                            <th>Action</th>
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

<div class="modal fade" id="addUser">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create User Customer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="form-add-user">
                    <div class="row">
                        <div class="col-6">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="add_email_val" />
                            <label for="">Firstname</label>
                            <input type="text" class="form-control" id="add_fname_val" />
                            <label for="">Phone</label>
                            <input type="text" class="form-control" id="add_phone_val" />
                        </div>
                        <div class="col-6">
                            <label for="">Password</label>
                            <input type="text" class="form-control" id="add_pwd_val" />
                            <label for="">Lastname</label>
                            <input type="text" class="form-control" id="add_lname_val" />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btn-save-add-user" class="btn btn-success btn-block">Save</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="{{mix('js/company/customer/customer.min.js')}}"></script>
@endsection