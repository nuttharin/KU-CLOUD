@extends('layouts.login')
@section('content')
<style>
    .form-register {
        width: 40%;
        margin: auto;
        -webkit-box-shadow: 0 -25px 37.7px 11.3px rgba(8, 0, 0, 0.07);
        box-shadow: 0 -25px 37.7px 11.3px rgba(8, 0, 0, 0.07);
        background: #FFF;
        border-radius: 4px;
    }

    @media screen and (max-width: 850px) {
        .form-register {
            width: 70%;
        }
    }

    @media screen and (max-width: 600px) {
        .form-register {
            width: 100%;
        }
    }

    .content{
        padding:30px;
    }

    .input-data{
        padding:20px;
        padding-top:0px;
    }
</style>
    <div class="content mx-auto my-auto" style="width: 100%">
        <div class="form-register">
            <form id="form_register">
                <div class="container">
                    <div class="row" style="padding: 20px; padding-bottom:0px;">
                        <span style="font-size: 24px;">Register</span>
                    </div>
                    <hr>
                    <div class="row input-data">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" autocomplete="off">
                    </div>
                    <div class="row input-data">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="off">
                    </div>
                    <div class="row input-data">
                        <label for="confirm_password">Confirm password</label>
                        <input type="text" name="confirm_password" class="form-control" id="confirm_password">
                    </div>
                    <div class="row input-data">
                        <label for="firstname">Firstname</label>
                        <input type="text" name="firstname" class="form-control" id="fname">
                    </div>
                    <div class="row input-data">
                        <label for="lname">Lastname</label>
                        <input type="text" name="lastname" class="form-control" id="lname">
                    </div>
                    <div class="row input-data">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="row input-data">
                        <div class="col-6">
                            <button class="btn btn-default btn-block btn-radius" id="btn_back">Back to login</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success btn-block btn-radius" id="btn_register">Comfirm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            const END_POINT = 'http://localhost:8000/api/';
            $("#btn_register").click(function(){
                $.ajax({
                    url:END_POINT + 'account/register',
                    method:'POST',
                    data:{
                        fname:$('#fname').val(),
                        lname:$('#lname').val(),
                        email:$('#email').val(),
                        password:$('#password').val(),
                        phone :$('#phone').val(),
                    },
                    success:() => {

                    },
                    error:(res) => {
                         console.log(res);
                    }
                })
            });
        })
    </script>

@endsection