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
   
</style>

<div class="row" style="margin-top:30px;">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6" style="padding: 30px 0px 10px 15px">
                        <span class="h3">Data analysis</span>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn_save_output">
                            Save
                        </button>
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
                        <a class="nav-link " id="cluster-tab" data-toggle="tab" href="#cluster" role="tab"
                            aria-controls="cluster" aria-selected="false">Cluster</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="associate-tab" data-toggle="tab" href="#associate" role="tab"
                            aria-controls="associate" aria-selected="false">Associate</a>
                    </li>
                </ul>
                <div class="form-row">
                    <div class="col-12">
                        <select name="training_file" id="training_file" class="form-control">
                            <option value="">--Select training file--</option>
                        </select>
                    </div>
                </div>
                <div class="tab-content tab-content-basic">
                    

                    <div class="tab-pane fade active show" id="classify" role="tabpanel" aria-labelledby="classify-tab">
                        @include('company.DataAnalysisClassify')
                    </div>
                    <div class="tab-pane fade" id="cluster" role="tabpanel" aria-labelledby="cluster-tab">
                            @include('company.DataAnalysisCluster')
                    </div>
                    <div class="tab-pane fade" id="associate" role="tabpanel" aria-labelledby="associate-tab">
                        @include('company.DataAnalysisAssociate')
                    </div>
                </div>

                <button class="btn btn-primary btn-radius mt-2" id="btn_process" data-loading-text="<i class='fas fa-cog fa-spin'></i> Processing"><i
                        class="fas fa-cog"></i> Process</button>
                <h4>Result</h4>
                <div class="form-row mt-2 result" style="display: none">
                    <pre id="outputText"></pre>
                </div>
                <div id="graph" style="text-align: center;"></div>

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
