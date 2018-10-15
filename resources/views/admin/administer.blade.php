@extends('layouts.main')
@section('title','Admin | Administer')
@section('content')
<style>
    table{
        font-size:14px; 
    }
    .dataTables_wrapper {
    font-size: 12px;
    }
</style>
<div class="card bg-white"style="margin-top:30px;">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-6" style="padding: 30px 0px 10px 15px">
                <span class="h3">User</span>
            </div>
            <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                <button type="button" onclick="" class="btn btn-success btn-radius">
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
                                <i class="mdi mdi-account-multiple text-secondary icon-lg"></i>
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
                <table style="width: 100%;" class="table table-striped table-bordered table-hover dt-responsive nowrap"
                    id="example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Alias</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>User</th>
                            <th>Customer</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <td>LIONKING</td>
                            <td>LION</td>
                            <td>088554412</td>
                            <td>xxx@xxx.com</td>
                            <td>xxx</td>
                            <td><a href="#">x</a></td>
                            <td><a href="#">x</a></td>
                            <td>xxx</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Block">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>LIONKING</td>
                            <td>LION</td>
                            <td>088554412</td>
                            <td>xxx@xxx.com</td>
                            <td>xxx</td>
                            <td><a href="#">x</a></td>
                            <td><a href="#">x</a></td>
                            <td>xxx</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Block">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>LIONKING</td>
                            <td>LION</td>
                            <td>088554412</td>
                            <td>xxx@xxx.com</td>
                            <td>xxx</td>
                            <td><a href="#">x</a></td>
                            <td><a href="#">x</a></td>
                            <td>xxx</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Block">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>LIONKING</td>
                            <td>LION</td>
                            <td>088554412</td>
                            <td>xxx@xxx.com</td>
                            <td>xxx</td>
                            <td><a href="#">x</a></td>
                            <td><a href="#">x</a></td>
                            <td>xxx</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Block">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>LIONKING</td>
                            <td>LION</td>
                            <td>088554412</td>
                            <td>xxx@xxx.com</td>
                            <td>xxx</td>
                            <td><a href="#">x</a></td>
                            <td><a href="#">x</a></td>
                            <td>xxx</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Block">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>LIONKING</td>
                            <td>LION</td>
                            <td>088554412</td>
                            <td>xxx@xxx.com</td>
                            <td>xxx</td>
                            <td><a href="#">x</a></td>
                            <td><a href="#">x</a></td>
                            <td>xxx</td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Block">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
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
</div>
@endsection