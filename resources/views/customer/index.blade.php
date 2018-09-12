@extends('layouts.mainCompany')
@section('content')
<style>
    table{
        font-size:14px; 
    }
    .dataTables_wrapper {
    font-size: 12px;
    }
</style>
<div class="row border-bottom">
    <div class="col-lg-6" style="padding: 30px 0px 10px 15px">
        <span class="h3">Customer</span>
    </div>
    <div class="col-lg-6 text-right" style="border-bottom: solid 1px #ddd; padding: 30px 15px 10px 0px">
        <button type="button" onclick="#" class="btn btn-success btn-radius">
            <i class="fa fa-plus"></i>
            Create
        </button>
    </div>
</div>   
<div class="row" style="padding: 30px 0px 10px 0px">
    <div class="col-12">
        <div class="panel-body">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="example">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Alias</th>
                        <th>Contact</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>LIONKING</td>
                        <td>lion</td>
                        <td>0886442121</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>LIONKING</td>
                        <td>lion</td>
                        <td>0886442121</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>LIONKING</td>
                        <td>lion</td>
                        <td>0886442121</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>LIONKING</td>
                        <td>lion</td>
                        <td>0886442121</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>LIONKING</td>
                        <td>lion</td>
                        <td>0886442121</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>LIONKING</td>
                        <td>lion</td>
                        <td>0886442121</td>
                        <td>
                            <center>
                                <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
@endsection