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

    .select2-search__field {
        width: 100% !important;
        padding: 0;
    }

    .input-data {
        padding: 20px;
        padding-top: 0px;
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
                        <h3>Customer</h3>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn-add-user">
                            <i class="fa fa-plus"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-warning btn-radius" id="btn_bind_user">
                            <i class="fas fa-link"></i>
                            Bind
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card card-statistics bg-primary text-white  grow grow-sm">
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
                                                <h2 class="font-weight-medium text-right mb-0" id="total-user">0 User</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card card-statistics bg-success text-white  grow grow-sm">
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
                                                <h2 class="font-weight-medium text-right mb-0" id="total-user-online">0
                                                    User</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card card-statistics bg-secondary text-white  grow grow-sm">
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
                                                <h2 class="font-weight-medium text-right mb-0" id="total-user-offline">0
                                                    User</h2>
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
            <div class="card-body" id="card_table">
                <table style="width: 100%;display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap"
                    id="example">
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUser">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form-add-user">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <label for="">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="add_username" />
                                <div class="messages-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-12 mt-2">
                                <label for="">Firstname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstname" id="add_fname_val" />
                                <div class="messages-error"></div>
                            </div>
                            <div class="col-xl-6 col-12 mt-2">
                                <label for="">Lastname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="lastname" id="add_lname_val" />
                                <div class="messages-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-12 mt-2">
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" id="add_email_val" placeholder="example@domain.com"/>
                                <div class="messages-error"></div>
                            </div>
                            <div class="col-xl-6 col-12 mt-2">
                                <label for="">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone"  id="add_phone_val" />
                                <div class="messages-error"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn-save-add-user" class="btn btn-success btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Save</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="bindUser">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Bind user customer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_bind_user">
                    <select multiple name="email" id="input_bind_email" placeholder="Choose email address">

                    </select>
                    <small class="messages-error"></small>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn_save_bind_user" class="btn btn-success btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Save</button>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="{{asset('js/fastsearch/fastsearch.css')}}">
<script src="{{asset('js/fastsearch/fastsearch.min.js')}}"></script>

<script type="text/javascript" src="{{mix('js/company/customer/customer.min.js')}}"></script>
@endsection
