@extends('layouts.mainCompany')
@section('title','Manage Company | Customer')
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
                <span class="h3">Manage Company</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table style="width: 100%; display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap" id="company_list">
            <thead>
                <tr>
                    <th>Company name</th>
                    <th>Status</th>
                    <th>Approved</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="lds-roller text-center" id="loading">
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

<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>


<script type="text/javascript" src="{{mix('js/customer/manageCompany/manageCompany.min.js')}}"></script>

@endsection
