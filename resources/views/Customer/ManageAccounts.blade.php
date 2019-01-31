@extends('layouts.mainCustomer') 
@section('title','Manage Accounts | Customer') 
@section('content')

<style>
    .modal-header {
        border-bottom: 0
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
                <a class="nav-link active show" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false">Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="emails-tab" data-toggle="tab" href="#emails" role="tab" aria-controls="emails" aria-selected="false">Emails</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="phones-tab" data-toggle="tab" href="#phones" role="tab" aria-controls="phones" aria-selected="false">Phones</a>
            </li>
        </ul>
        <div class="tab-content tab-content-basic">
            <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label>Firstname</label>
                        <input type="text" class="form-control" name="fname" value="{{$user->fname}}">
                        <label>Lastname</label>
                        <input type="text" class="form-control" name="lname" value="{{$user->lname}}">
                        <button type="button" class="btn btn-success mt-2" id="btn-update-profile" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Update profile</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <h6>Profile picture</h6>

                        <img class="img-xs rounded-circle" height="200" width="200" src="http://localhost:8000/api/account/profile/{{$user->img_profile}}"
                            alt="Profile image"><br/>

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
                        <label>Old password</label>
                        <input type="password" name="old_password" class="form-control">
                        <label>New password</label>
                        <input type="password" name="new_password" class="form-control">
                        <label>Confirm new password</label>
                        <input type="password" name="confirm_password" class="form-control">
                        <button type="button" class="btn btn-success mt-2" id="btn-update-password">Update password</button>
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
                        <button type="button" class="btn btn-success btn-block" id="btn-crop-save" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Uploading . . .">Set new profile picture</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>


<script type="text/javascript" src="{{mix('js/company/account/account.min.js')}}"></script>

@endsection