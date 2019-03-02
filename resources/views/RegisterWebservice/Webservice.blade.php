@extends('layouts.mainCompany')
@section('title','Register web service')
@section('content')
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
                        <span class="h3">Register web service</span>
                    </div>
                    <div class="col-6 text-right" style="padding: 30px 15px 10px 0px;width:100%">
                        <button type="button" class="btn btn-success btn-radius" id="btn_register_service">
                            <i class="fas fa-link"></i>
                            Register
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table style="width: 100%; display:none" class="table table-striped table-bordered table-hover dt-responsive nowrap"
                    id="example">
                    <thead>
                        <tr>
                            <th>Customer name</th>
                            <th>Webservice name</th>
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

<div class="modal fade" id="registerUser">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Register web service to customer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_bind_user">
                    <label for="">Webservice</label>
                    <select name="webservice" id="webservice" class="form-control">

                    </select>
                    <label for="">Email customer</label>
                    <select multiple name="input_bind_email" id="input_bind_email" placeholder="Choose email address">

                    </select>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn_save_register_user" class="btn btn-success btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Save</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript " src="{{asset( 'js/sweetalert/sweetalert.min.js')}} "></script>
<link rel="stylesheet" href="{{asset('js/fastsearch/fastsearch.css')}}">
<script src="{{asset('js/fastsearch/fastsearch.min.js')}}"></script>
<script src="{{ mix('/js/registerWebservice/registerWebservice.min.js') }}"></script>
@endsection
