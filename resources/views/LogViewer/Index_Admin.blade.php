@extends('layouts.mainCompany') 
@section('title','Admin | LogViewer') 
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
    <div class="folder-log-viewer">
        <div class="card bg-white" style="margin-top:30px;">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <h3>Folder Log</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table style="width: 100% ;display: none" class="table table-striped table-bordered table-hover dt-responsive " id="datatable-folder-log">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Folder</th>
                                    <th>Size</th>
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
                            <button class="btn btn-danger btn-radius" id="btn-delete-file"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>Log</h3>
                       
                        <!-- <div class="text-loading">
                            <div class="text-line md"></div>
                        </div>
                        <div class="text-loading">
                            <div class="text-line md" style="200px"></div>
                        </div>  -->
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

    {{--
    <div class="card bg-white" style="margin-top:30px;">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col-6" style="padding: 30px 0px 10px 15px">
                    <h3>Log</h3>
                    <p><i class="fas fa-folder-open text-warning"></i> {{$data['current_folder']}}/{{$data['current_file']}}</p>
                    --
                    <p>File Size : {{$data['logs'][0]['size']}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table style="width: 100%" class="table table-striped table-bordered table-hover dt-responsive " id="table-log">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Date</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data['logs'] as $key => $log)
                            <tr>
                                <td class="nowrap">
                                    <i class="{{$log['level_img']}}" style="color:{{$log['level_color']}}"></i><span class="text-{{$log['level_class']}}"> {{$log['level']}}</span>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-{{$log['level_class']}}">{{$log['date']}}</span>
                                </td>
                                <td class="text" style="font-size: 12px">
                                    <!-- {{$log['text']}} -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>
<script type="text/javascript" src="{{url('js/admin/Logs/databaseLogs.js')}}"></script>
<script>
    // $(document).ready(function(){
    //         $('#table-log').dataTable({
    //             "columnDefs": [
    //                 { "width": "40%", "targets": 0 }
    //             ]
    //         });
    //         $('#sidebarCollapse').click();
    //     });

</script>
@endsection