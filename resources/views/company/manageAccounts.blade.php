@extends('layouts.mainCompany') 
@section('title','Manage Accounts | Company') 
@section('content')
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
                    <div class="col-6">
                        <label>Firstname</label>
                        <input type="text" class="form-control" value="{{$user->fname}}">
                        <label>Lastname</label>
                        <input type="text" class="form-control" value="{{$user->lname}}">
                        <button type="button" class="btn btn-success mt-2">Upload profile</button>
                    </div>
                    <div class="col-6">
                        <h6>Profile picture</h6>
                        <img class="img-xs rounded-circle" height="200" width="200" src="data:image/png;base64,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"
                            alt="Profile image"><br/>
                        <button type="button" class="btn ">Upload new picture</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                <h4>Change password</h4>
                <div class="row">
                    <div class="col-6">
                        <label>Old password</label>
                        <input type="password" class="form-control">
                        <label>New password</label>
                        <input type="password" class="form-control">
                        <label>Confirm new password</label>
                        <input type="password" class="form-control">
                        <button type="button" class="btn btn-success mt-2">Update password</button>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="emails-tab">
                <div id="list-email"></div>
                <div class="row mt-3">
                    <div class="col-6">
                        <label>Add email address</label>
                        <div class="d-flex">
                            <input type="text" name="add-email" class="form-control">
                            <button type="button" class="ml-2 btn btn-success" id="btn-add-email">Add</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-6 form-group">
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
                    <div class="col-6">
                        <label>Add phone</label>
                        <div class="d-flex">
                            <input type="text" name="add-phone" class="form-control">
                            <button type="button" class="ml-2 btn btn-success" id="btn-add-phone">Add</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-6 form-group">
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
</div>

<script type="text/javascript" src="{{url('js/sweetalert/sweetalert.min.js')}}"></script>

<script type="text/javascript" src="{{mix('js/company/account/account.min.js')}}"></script>
@endsection