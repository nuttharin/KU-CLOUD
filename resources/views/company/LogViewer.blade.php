@extends('layouts.mainCompany')
@section('title','Company | LogViewer')
@section('content')
    <style>
        table {
            font-size: 14px;
        }

        .dataTables_wrapper {
            font-size: 12px;
        }

        .text-wrap {
            white-space: normal;
        }

        .width-200 {
            width: 600px;
        }
    </style>
    <link href="{{url('css/loading-text.css')}}" rel="stylesheet" />
    <link href="{{url('css/animate.css')}}" rel="stylesheet">
    <div class="container-fluid">

        <div class="file-log-viewer">
            <div class="card bg-white" style="margin-top:30px;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-6" style="padding: 30px 0px 10px 15px">
                            <h3>Log files</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover" id="table-file-log" style="display: none">
                                <thead>
                                <th>File</th>
                                <th>Size</th>
                                <th>Action</th>
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
        </div>

        <div class="log-viewer" style="display:none">
            <div class="card bg-white" style="margin-top:30px;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-6">
                            <div class="mr-auto">
                                <i class="fas fa-chevron-left"></i> <span style="cursor:pointer" id="btn-back">Back To Folder Log</span>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <div class="mr-auto">
                                <button class="btn btn-success btn-radius" id="btn-download-file"><i class="fas fa-arrow-down"></i></button>
                                <button class="btn btn-danger btn-radius"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3>Log</h3>
                            {{--
                            <div class="text-loading">
                                <div class="text-line md"></div>
                            </div>
                            <div class="text-loading">
                                <div class="text-line md" style="200px"></div>
                            </div> --}}
                            <p><i class="fas fa-folder-open text-warning"></i> <span id="path-file"></span></p>
                            <p>Size : <span id="file-size"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="table-log">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Date</th>
                                    <th>Content</th>
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
        </div>
    </div>
    <script type="text/javascript" src="{{url('js/company/Logs/databaseLogs.js')}}"></script>
@endsection