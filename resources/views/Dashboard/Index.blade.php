@extends('layouts.mainCompany')
@section('title','Dashboards')
@section('content')
<?php $user = session('user') ?>
<style>
    table {
        font-size: 14px;
    }

    .dataTables_wrapper {
        font-size: 12px;
    }
</style>



<div class="row" style="margin-top:30px;">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Dashboards</span>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn-add-static">
                            <i class="fa fa-plus"></i>
                            Create
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table style="width: 100%; display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap"
                    id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Create by</th>
                            <th>Description</th>
                            @if ($user->type_user == 'ADMIN')
                            <th>Status share</th>
                            @endif
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

<div class="modal fade" id="addStatic">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">Create Static Dashboard</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Name</label>
                        <input type="text" id="static-name" class="form-control">
                    </div>
                    <div class="col-12">
                        <label>Description</label>
                        <textarea name="desc" id="desc" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    @if ($user->type_user == 'ADMIN')
                    <div class="col-12 form-inline mt-2">
                        <label class="mr-2">Status Share</label>
                        <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="add_statusPrivate" name="add_statusShare" value="0" checked>
                                <label class="custom-control-label mr-3" for="add_statusPrivate">Private</label>
                        </div> 
                        <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="add_statusPublic" name="add_statusShare" value="1" >
                                <label class="custom-control-label" for="add_statusPublic">Public</label>
                        </div> 
                    </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn-save-add-static" class="btn btn-success btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

@if ($user->type_user == 'COMPANY')
<script src="{{ mix('/js/company/dashboards/dashboardDataTable.min.js') }}"></script>
@endif
@if ($user->type_user == 'ADMIN')
<script src="{{ mix('/js/admin/dashboards/dashboardDataTable.min.js') }}"></script>
@endif
@endsection
