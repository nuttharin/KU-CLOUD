@extends('layouts.mainCompany')
@section('title','User | PrepareData')
@section('content')
<style>
    table {
        font-size: 14px;
    }

    .dataTables_wrapper {
        font-size: 12px;
    }

    td.checkbox,
    th.checkbox {
        text-align: center;
        vertical-align: middle;
    }

    #list_value {
        height: 300px !important;
        overflow-y: scroll;
    }

</style>
<link rel="stylesheet" href="{{asset('css/file.css')}}">
<div class="row" style="margin-top:30px;">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Data for analysis </span>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn_add">
                            <i class="fa fa-plus"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-primary btn-radius" id="btn_upload_file">
                            <i class="fas fa-upload"></i>
                            Upload file
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h3><i class="fas fa-sync grow" style="cursor: pointer;" data-toggle="tooltip" data-placement="top"
                        title="Refresh" id="refreshData"></i></h3>
                <table style="width: 100%; display:none"
                    class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Create by</th>
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

<div class="modal fade" id="addDataAnalysis">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">Create Data for analysis</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="form_create_data">
                <div class="row">
                    <div class="col-12">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" id="data_name" name="name" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                </div>
                <div class="row mt-2">
                    <!-- <div class="col-12 form-inline">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="webservice" name="service" value="webservice"
                                checked>
                            <label class="custom-control-label  mr-3" for="webservice">Web service</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="iot" name="service" value="iot">
                            <label class="custom-control-label" for="iot">Iot</label>
                        </div>
                    </div> -->
                    <div class="col-12">
                        <label for="datasource">Datasource <span class="text-danger">*</span></label>
                        <select name="datasource" id="datasource" class="form-control"></select>
                        <small class="messages-error"></small>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <label>Period</label>
                    </div>
                    <div class="col-12  form-inline">
                        <div class="custom-control  custom-radio mr-2">
                            <input type="radio" class="custom-control-input" id="chcekBoxDay" name="typeTime"
                                value="typeDay" checked>
                            <label class="custom-control-label" for="chcekBoxDay">Day</label>
                        </div>
                        <div class="custom-control  custom-radio mr-2">
                            <input type="radio" class="custom-control-input" id="chcekBoxMonth" name="typeTime"
                                value="typeMonth">
                            <label class="custom-control-label" for="chcekBoxMonth">Month</label>
                        </div>
                        <div class="custom-control  custom-radio mr-2">
                            <input type="radio" class="custom-control-input" id="chcekBoxYear" name="typeTime"
                                value="typeYear">
                            <label class="custom-control-label" for="chcekBoxYear">Year</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 typeTime" id="typeDay">
                    <div class="col-12 col-md-4">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                </div>
                <div class="row mt-2 typeTime" id="typeMonth" style="display:none">
                    <div class="col-12 col-md-6">
                        <label>Start month <span class="text-danger">*</span></label>
                        <input type="month" name="start_month" id="start_month" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>End month <span class="text-danger">*</span></label>
                        <input type="month" name="end_month" id="end_month" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                </div>
                <div class="row mt-2 typeTime" id="typeYear" style="display:none">
                    <div class="col-12 col-md-4">
                        <label>Year <span class="text-danger">*</span></label>
                        <input type="number" name="year" id="year" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <small class="messages-error" id="message_date_error"></small>
                    </div>

                </div>
                <!-- <div class="row mt-2">
                    <div class="col-6">
                        <label for="start_date">Start date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                    <div class="col-6">
                        <label for="end_date">End date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                        <small class="messages-error"></small>
                    </div>
                </div> -->
                <div class="row mt-2">
                    <div class="col-6">
                        <button class="btn btn-primary btn-sm btn-radius" id="btn_show_values">Show values</button>
                    </div>
                    <div class="col-12">
                        <div class="lds-roller text-center mt-3 ld" style="display:none">
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
                    <div class="col-12 mt-2 " id="list_value" style="display: none">
                        <table class="table table-bordered table-striped bg-white">
                            <thead>
                                <tr>
                                    <th class="checkbox">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" name="checkAll"
                                                id="checkAll" checked>
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th>Column</th>
                                    <th>Example value</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_values">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn_save" class="btn btn-success btn-block"
                    data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="uploadFile">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">Upload file</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" id="form_upload" enctype="multipart/form-data">
                            <div class="form-group files">

                                <input type="file" id="file_upload" name="file_upload" class="form-control" multiple>
                            </div>
                        </form>


                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn_submit_upload" class="btn btn-success btn-block"
                    data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Uploading . . .">
                    Upload
                </button>
            </div>

        </div>
    </div>
</div>

<div class="process-zip-file" style="display:none">
    <div class="row">
        <div class="col-12">Processing compress file</div>
        <div class="col-12 mt-2" id="file_name"></div>
        <div class="col-12 mt-2">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/company/analysis/DataAnalysis.min.js')}}"></script>
@endsection
