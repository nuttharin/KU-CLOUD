@extends('layouts.mainCompany')
@section('title','Manage Accounts | Company')
@section('content')
<?php $user = session('user') ?>
<style>
    .modal-header {
        border-bottom: 0
    }

    .address-add {
        cursor: pointer;
    }

    .edit-address,
    .delete-address {
        cursor: pointer;
    }

    .address {
        border: 1px solid #eee;
        padding: 50px;
        margin: 20px;
        width: 100%;
        height: 300px;
        border-radius: 10px;
        transition: all .2s ease-in-out;
    }

    .address:hover {
        background-color: #eee;
    }

</style>

<link rel="stylesheet" href="{{asset('css/croppie.css')}}">
<div class="card bg-white" style="margin-top:30px;">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-6" style="padding: 30px 0px 10px 15px">
                <span class="h3">Manage Accounts</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs tab-basic" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="true">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab"
                    aria-controls="account" aria-selected="false">Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="emails-tab" data-toggle="tab" href="#emails" role="tab" aria-controls="emails"
                    aria-selected="false">Emails</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="phones-tab" data-toggle="tab" href="#phones" role="tab" aria-controls="phones"
                    aria-selected="false">Phones</a>
            </li>
            @if($user->type_user == 'CUSTOMER')
            <li class="nav-item">
                <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
                    aria-controls="address" aria-selected="false">Address</a>
            </li>
            @endif
        </ul>
        <div class="tab-content tab-content-basic">
            <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>Firstname</label>
                            <input type="text" class="form-control" name="firstname" value="{{$user->fname}}">
                            <small class="messages-error"></small>
                        </div>
                        <div class="form-group">
                            <label>Lastname</label>
                            <input type="text" class="form-control" name="lastname" value="{{$user->lname}}">
                            <small class="messages-error"></small>
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="btn-update-profile"
                            data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Update
                            profile</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <h6>Profile picture</h6>

                        <img class="img-xs rounded-circle" height="200" width="200"
                            src="{{env('API_URL')}}account/profile" alt="Profile image"><br />

                        <label class="btn btn-primary mt-2">
                            Upload new picture <input type="file" name="img-profile" id="img-profile" hidden>
                        </label>
                        <button type="button" class="btn mt-2" hidden>Upload new picture</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                <h4>Change password</h4>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>Old password</label>
                            <input type="password" name="old_password" class="form-control">
                            <small class="messages-error"></small>
                        </div>
                        <div class="form-group">
                            <label>New password</label>
                            <input type="password" name="new_password" class="form-control">
                            <small class="messages-error"></small>
                        </div>
                        <div class="form-group">
                            <label>Confirm new password</label>
                            <input type="password" name="confirm_password" class="form-control">
                            <small class="messages-error"></small>
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="btn-update-password">Update
                            password</button>
                    </div>
                </div>
                <hr>
                <h4>Change Username</h4>
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="{{$user->username}}">
                        <button type="button" class="btn btn-success mt-2" id="btn_update_username"
                            data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Update
                            username</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="emails-tab">
                <div id="list-email"></div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6">
                        <label>Add email address</label>
                        <div class="d-flex">
                            <input type="text" name="add-email" class="form-control">
                            <button type="button" class="ml-2 btn btn-success" id="btn-add-email">Add</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 form-group">
                        <label>Primary email address</label>
                        <div class="d-flex">
                            <select name="" id="select-email" class="form-control"></select>
                            <button type="button" class="ml-2 btn btn-success" id="btn-save-email-pri">Save</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="phones" role="tabpanel" aria-labelledby="phones-tab">
                <div id="list-phone">

                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6">
                        <label>Add phone</label>
                        <div class="d-flex">
                            <input type="text" name="add-phone" class="form-control">
                            <button type="button" class="ml-2 btn btn-success" id="btn-add-phone">Add</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 form-group">
                        <label>Primary phone</label>
                        <div class="d-flex">
                            <select name="" id="select-phone" class="form-control"></select>
                            <button type="button" class="ml-2 btn btn-success" id="btn-save-phone-pri">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            @if($user->type_user == 'CUSTOMER')
            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                <div class="row justify-content-start">
                    <div class="address address-add d-flex justify-content-center flex-column text-center"
                        style="display:none !important">
                        <i class="fas fa-plus fa-lg"></i><br>
                        Add address
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="profile-crop">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="imageUploadForm">
                        <div id="upload-demo"></div>
                        <input type="hidden" id="imagebase64" name="imagebase64">
                        <button type="button" class="btn btn-success btn-block" id="btn-crop-save"
                            data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Uploading . . .">Set
                            new profile picture</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @if($user->type_user == 'CUSTOMER')
    <div class="modal fade" id="addAddress">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add address</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_add_address">
                        <div class="col-xl-12">
                            <div class="row input-data">
                                <label for="address">Address</label>
                                <textarea name="address_detail" id="address_detail" cols="30" rows="5"
                                    class="form-control"></textarea>
                                <small class="messages-error"></small>
                            </div>
                            <div class="row input-data">
                                <label for="province">Province</label>
                                <select name="province" id="province" class="form-control">
                                    <option value="">--Select provice--</option>
                                </select>
                                <small class="messages-error"></small>
                            </div>
                            <div class="row input-data">
                                <label for="amphure">Amphure</label>
                                <select name="amphure" id="amphure" class="form-control">
                                    <option value="">--Select amphure--</option>
                                </select>
                                <small class="messages-error"></small>
                            </div>
                            <div class="row input-data">
                                <div class="col-6" style="padding-left:0px;">
                                    <label for="district">District</label>
                                    <select name="district" id="district" class="form-control">
                                        <option value="">--Select district--</option>
                                    </select>
                                    <small class="messages-error"></small>
                                </div>
                                <div class="col-6" style="padding-right:0px;">
                                    <label for="zip_code">Zip code</label>
                                    <input name="zip_code" id="zip_code" class="form-control">
                                    <small class="messages-error"></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success btn-block" id="btn_add_address">Save</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>


<script type="text/javascript" src="{{mix('js/company/account/account.min.js')}}"></script>

{{--
<script type="text/javascript" src="{{mix('js/company/account/Accounts.js')}}"></script> --}}
@endsection
