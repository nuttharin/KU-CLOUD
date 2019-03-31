@extends('layouts.mainCompany') 
@section('title','Admin | Company') 
@section('content')

<style>
    table {
        font-size: 14px;
    }

    .dataTables_wrapper {
        font-size: 12px;
    }
</style>

<div class="card bg-white" style="margin-top:30px;">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-6" style="padding: 30px 0px 10px 15px">
                <span class="h3">Infographic</span>
            </div>
            <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                <button type="button" class="btn btn-success btn-radius" id="btn-add-info">
                    <i class="fa fa-plus"></i>
                    Create
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row" style="">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs tab-basic" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="company-tab" name="nav_link_item" data-toggle="tab" href="#company" role="tab"
                            aria-controls="company" aria-selected="true">Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="customer-tab" name="nav_link_item" data-toggle="tab" href="#customer" role="tab"
                            aria-controls="customer" aria-selected="true">Customer</a>
                    </li>
                </ul>
                <table style="width: 100%; display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Create By</th>
                            <th>Update By</th>
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

<div class="modal fade" id="addInfo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Infographic</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-info">
                    <div class="row">
                        <div class="col-12">
                            <label>Name</label>
                            <input type="text" name="infoname" id="info-name" class="form-control">
                            <small class="messages-error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-save-add-info" class="btn btn-success btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">
                    Save                
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('/js/admin/Infographic/infographicDataTable.min.js') }}"></script>
@endsection