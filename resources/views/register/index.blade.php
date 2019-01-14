@extends('layouts.login')
@section('content')
<style>
    .form-register {
        width: 40%;
        margin: auto;
        padding: 40px 40px 10px;
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
</style>
    <div class="content mx-auto my-auto" style="width: 100%">
        <div class="form-register">
            <form id="form_register">
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" class="form-control" id="fname">
                </div>
                <div class="form-group">
                    <label for="lname">Lastname</label>
                    <input type="text" name="lastname" class="form-control" id="lname">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm password</label>
                    <input type="text" name="confirm_password" class="form-control" id="confirm_password">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone">
                </div>
            </form>
            <button class="btn btn-success btn-block btn-radius" id="btn_register">Register</button>
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