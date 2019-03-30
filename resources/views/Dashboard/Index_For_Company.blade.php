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
                <ul class="nav nav-tabs tab-basic" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="company-tab" data-toggle="tab" href="#company" role="tab"
                            aria-controls="company" aria-selected="true">Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="customer-tab" data-toggle="tab" href="#customer" role="tab"
                            aria-controls="customer" aria-selected="false">Customer</a>
                    </li>
                </ul>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade active show" id="company" role="tabpanel" aria-labelledby="company-tab">
                        <table style="width: 100%; display:none"
                            class="table table-striped table-bordered table-hover dt-responsive nowrap" id="companyTable">
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
                    </div>
                    <div class="tab-pane fade " id="customer" role="tabpanel" aria-labelledby="customer-tab">
                        <table style="width: 100%; display:none"
                        class="table table-striped table-bordered table-hover dt-responsive nowrap" id="customerTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Create by</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
                
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
                <form id="create_static">
                    <div class="row">
                        <div class="col-12">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" id="static-name" name="name" class="form-control">
                            <small class="messages-error"></small>
                        </div>
                        <div class="col-12">
                            <label>Description</label>
                            <textarea name="desc" id="desc" name="description" cols="30" rows="10"
                                class="form-control"></textarea>
                            <small class="messages-error"></small>
                        </div>
                        <div class="col-12">
                            <label for="customer">Customer</label>
                            <select name="customer" id="customer" class="form-control">
                                <option value="">=</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn-save-add-static" class="btn btn-success btn-block"
                    data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<script src="{{ mix('/js/company/dashboards/dashboardDataTable.min.js') }}"></script>


@endsection
