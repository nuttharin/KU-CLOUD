@extends('layouts.mainCompany')
@section('title','User | DataAnalysis')
@section('content')
<style>
    table {
            font-size: 14px;
        }
    
        .dataTables_wrapper {
            font-size: 12px;
        }
        td.checkbox {
            text-align: center;
            vertical-align: middle;  
        }

        #list_value {  
            height: 300px !important;
            overflow-y: scroll;
        }
        
        .result{
            padding: 20px;
            border:#eee 1px solid;
            border-radius: 10px;
        }  

        #graph > svg {
            margin-top: 10px;
    box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.13);
        } 

        .icon-info{
            cursor: pointer;
            color:#1e7bcb;
        }

        .download-file{
            cursor: pointer;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 9px 2px rgba(0, 0, 0, 0.13);
        }
   
</style>

<div class="row" style="margin-top:30px;">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Data analysis</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs tab-basic" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="classify-tab" data-toggle="tab" href="#classify" role="tab"
                            aria-controls="classify" aria-selected="true">Classify</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="regression-tab" data-toggle="tab" href="#regression" role="tab"
                            aria-controls="regression" aria-selected="true">Regression</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="cluster-tab" data-toggle="tab" href="#cluster" role="tab"
                            aria-controls="cluster" aria-selected="false">Cluster</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="associate-tab" data-toggle="tab" href="#associate" role="tab"
                            aria-controls="associate" aria-selected="false">Associate</a>
                    </li>
                </ul>
                <div class="form-row" id="input_analysis">
                        <!-- <span><i class="fas fa-times cancel-getFile grow" style="cursor: pointer;display: none"></i></span> -->
                    <div class="col-12">
                        <h4>Training file <span class="text-danger">*</span> </h4>
                        <select name="training_file" id="training_file" class="form-control">
                            <option value="">--Select training file--</option>
                        </select>
                        <small class="messages-error"></small>
                        <div class="lds-roller text-center mt-3" style="display:none">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <!-- height:300px;overflow-y: scroll; -->
                        <div class="table-responsive bg-white mt-3" style="display: none">
                            <table id="dataTable" class="table table-bordered table-striped display nowrap">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="tab-content tab-content-basic">
                    <h4>Options</h4>

                    <div class="tab-pane fade active show" id="classify" role="tabpanel" aria-labelledby="classify-tab">
                        @include('Analysis.DataAnalysisClassify')
                    </div>
                    <div class="tab-pane fade" id="regression" role="tabpanel" aria-labelledby="regression-tab">
                        @include('Analysis.DataAnalysisRegression')
                    </div>
                    <div class="tab-pane fade" id="cluster" role="tabpanel" aria-labelledby="cluster-tab">
                        @include('Analysis.DataAnalysisCluster')
                    </div>
                    <div class="tab-pane fade" id="associate" role="tabpanel" aria-labelledby="associate-tab">
                        @include('Analysis.DataAnalysisAssociate')
                    </div>
                </div>

                <div class="row justify-content-end mt-3 mr-2" style="text-align: center; ">
                    <button class="btn btn-primary btn-radius mt-2" id="btn_process" data-loading-text="<i class='fas fa-cog fa-spin'></i> Processing"><i
                            class="fas fa-cog"></i> Process</button>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-6">
                        <h4>Result</h4>
                    </div>

                    <div class="col-6 text-right">
                        <div class="dropdown">
                            <button type="button" class="btn btn-success btn-radius dropdown-toggle" data-toggle="dropdown">
                                Save result
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <span class="dropdown-item download-file" type="text">Result text</span>
                                <span class="dropdown-item download-file" type="json">Result json</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="form-row mt-2 result" style="display: none">
                    <pre id="outputText"></pre>
                </div> -->
                <div class="form-row-mt-2 result" id="outputHtml">

                </div>

                <div class="mt-3" id="visualize" style="display: none;">
                    <h4>Visualize</h4>
                    <div class="form-row">
                        <div class="col-6">
                            <label for="axis_x">Axis x</label>
                            <select name="axis_x" id="axis_x" class="form-control"></select>
                        </div>
                        <div class="col-6">
                            <label for="axis_y">Axis y</label>
                            <select name="axis_y" id="axis_y" class="form-control"></select>
                        </div>
                        <div style="width:100%;height: auto;">
                            <canvas id="scatter_chart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="mt-3" id="chart_regression" style="display: none;">
                    <div style="width:100%;height: auto;">
                        <canvas id="chart_linear"></canvas>
                    </div>
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

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Name</label>
                        <input type="text" id="data_name" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="datasource">Datasource</label>
                        <select name="datasource" id="datasource" class="form-control"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="start_date">Start date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="end_date">End date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <button class="btn btn-primary btn-sm btn-radius" id="btn_show_values">Show values</button>
                    </div>
                    <div class="col-12 mt-2 " id="list_value" style="display: none">
                        <table class="table table-bordered table-striped bg-white">
                            <thead>
                                <tr>
                                    <th>Select</th>
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
                <button type="button" id="btn_save" class="btn btn-success btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>
<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://unpkg.com/viz.js@1.8.0/viz.js" type="javascript/worker"></script>
<script src="https://unpkg.com/d3-graphviz@1.4.0/build/d3-graphviz.min.js"></script>
<script src="{{asset('js/company/analysis/Analysis.min.js')}}"></script>
@endsection
