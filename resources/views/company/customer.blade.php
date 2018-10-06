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

<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Customer</span>
                        <h6>Total Customer 6</h6>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn-add-customer">
                            <i class="fa fa-plus"></i>
                            Create
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white">
                <table style="width: 100%;display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
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

<script type="text/javascript" src="{{url('js/company/customer/customer.js')}}"></script>
@endsection