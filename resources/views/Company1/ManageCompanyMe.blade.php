@extends('layouts.mainCompany')
@section('title','Manage Company')
@section('content')
<div class="card bg-white" style="margin-top:30px;">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-6" style="padding: 30px 0px 10px 15px">
                <span class="h3">Manage Company</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex flex-wrap align-content-center" id="loading">
            <div class="lds-ring text-center mx-auto">
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
        <form id="form_edit_company" style="display:none">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="row mt-2">
                        <div class="col-6" style="padding-left:0px;">
                            <label for="">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="companyname" class="form-control" id="company_name_edit" />
                            <small class="messages-error"></small>
                        </div>
                        <div class="col-6" style="padding-right:0px;">
                            <label for="">Alias <span class="text-danger">*</span></label>
                            <input type="text" name="alias" class="form-control" id="alias_edit" />
                            <small class="messages-error"></small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label for="address">Note <span class="text-danger">*</span></label>
                        <textarea name="note" id="note_edit" cols="30" rows="5" class="form-control"></textarea>
                        <small class="messages-error"></small>
                    </div>
                    <div class="row mt-2">
                        <label for="address">Address <span class="text-danger">*</span></label>
                        <textarea name="address_detail" id="address_edit" cols="30" rows="5"
                            class="form-control"></textarea>
                        <small class="messages-error"></small>
                    </div>
                    <div class="row mt-2">
                        <label for="province">Province <span class="text-danger">*</span></label>
                        <select name="province" id="province_edit" class="form-control">
                            <option value="">--Select provice--</option>
                        </select>
                        <small class="messages-error"></small>
                    </div>
                    <div class="row mt-2">
                        <label for="amphure">Amphure <span class="text-danger">*</span></label>
                        <select name="amphure" id="amphure_edit" class="form-control">
                            <option value="">--Select amphure--</option>
                        </select>
                        <small class="messages-error"></small>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6" style="padding-left:0px;">
                            <label for="district">District <span class="text-danger">*</span></label>
                            <select name="district" id="district_edit" class="form-control">
                                <option value="">--Select district--</option>
                            </select>
                            <small class="messages-error"></small>
                        </div>
                        <div class="col-6" style="padding-right:0px;">
                            <label for="zip_code">Zip code <span class="text-danger">*</span></label>
                            <input name="zip_code" id="zip_code_edit" class="form-control">
                            <small class="messages-error"></small>
                        </div>
                    </div>
                </div>
            </div>
            <br>

        </form>
        <div class="row justify-content-center">
            <button class="btn btn-success btn-block btn-radius" id="btn_submit_edit_company"
                style="width:50% ;display: none"  data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Save</button>
        </div>
    </div>
</div>

<script src="{{asset('js/company/ManageCompanyMe.min.js')}}"></script>

@endsection
