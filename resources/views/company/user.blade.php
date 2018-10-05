@extends('layouts.mainCompany')
@section('title','User | Company')
@section('content')

<style>
    table{
        font-size:14px; 
    }
    .dataTables_wrapper {
    font-size: 12px;
    }
</style>

<div class="card bg-white" style="margin-top:30px;">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-6" style="padding: 30px 0px 10px 15px">
                <span class="h3">User</span>
            </div>
            <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                <button type="button" class="btn btn-success btn-radius" id="btn-add-user">
                    <i class="fa fa-plus"></i>
                    Create
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-account-multiple text-primary icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total User</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">6 User</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-account-multiple text-success icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total User Online</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">5 User</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-account-multiple text-warning icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total User Offline</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">1 User</h3>
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
                <div class="lds-roller text-center"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                <table style="width: 100%; display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap"  id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
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

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create User Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="form-add-user">
                    <div class="row">
                        <div class="col-6">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="add_email_val"  />
                            <label for="">Firstname</label>
                            <input type="text" class="form-control" id="add_fname_val" />
                            <label for="">Phone</label>
                            <input type="text" class="form-control" id="add_phone_val"/>
                        </div>
                        <div class="col-6">
                            <label for="">Password</label>
                            <input type="text" class="form-control" id="add_pwd_val" />
                            <label for="">Lastname</label>
                            <input type="text" class="form-control" id="add_lname_val" />
                            <label for="">Type User</label>
                            <select id="add_type_user_val" class="form-control">
                                <option>ADMIN</option>
                                <option selected>NORMAL</option>
                            </select>
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

<div id="add_phone_form" hidden>
    <div class="input-group mb-2">
        <input type="text" class="add_phone_val form-control mt-1" >
        <div class="input-group-append">
            <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
        </div>
    </div>
</div>

<div id="add_email_form" hidden>
    <div class="input-group mb-2">
        <input type="text" class="add_email_val form-control mt-1" >
        <div class="input-group-append">
            <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
        </div>
    </div>
</div>

<script type="text/javascript" src="{{url('js/company/users/users.js')}}"></script>

<script>

    $(document).ready(function () {
        $("#btn-add-user").click(() => {
            $("#addUser").modal('show');
        })

        $("#btn-add-phone").click(function() {
            event.preventDefault();
            let html = $("#add_phone_form").html();
            $("#phone-other").append(html)
        })

        $("#btn-add-email").click(function() {
            event.preventDefault();
            let html = $("#add_email_form").html();
            $("#email-other").append(html)
        })

        $(document).on('click',".btn-delete-email ,.btn-delete-phone",function(){
            $(this).parent().parent().remove();
        })

    });


</script>
@endsection