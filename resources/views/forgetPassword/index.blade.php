@extends('layouts.login') 
@section('content')
<style>
    body {
        background: #A1FFCE;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to bottom, #FAFFD1, #A1FFCE);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to bottom, #FAFFD1, #A1FFCE);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .form-register {
        width: 30%;
        margin-bottom: 15px;
        -webkit-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
        box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
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

    .content {
        padding: 30px 10px 30px 30px;
    }

    .input-data {
        padding: 20px;
        padding-top: 0px;
    }

    .swal-modal {
        width: 580px;
    }
</style>
<div class="content d-flex flex-column justify-content-center align-items-center" style="width: 100%;height: 100vh;">
    <div class="form-register">
        <form id="form_register" autocomplete="nope">
            <div class="container">
                <div class="row" style="padding: 20px; padding-bottom:0px;">
                    <span style="font-size: 24px;">Register</span>
                </div>
                <hr>
                <div class="row input-data">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="nope">
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" autocomplete="new-password">
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data">
                    <label for="confirmPassword">Confirm password</label>
                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data">
                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" class="form-control" id="fname">
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data">
                    <label for="lname">Lastname</label>
                    <input type="text" name="lastname" class="form-control" id="lname">
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone">
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data">
                    <button class="btn btn-success btn-block btn-radius" id="btn_register" data-loading-text="Create my account <i class='fas fa-circle-notch fa-spin'></i>">Create your account</button>
                </div>
            </div>
        </form>
    </div>
    <span> <span class="font-weight-semibold"> Already have an account ?</span> <a href="{{action('AuthController@index')}}">Sing in</a></span>
</div>

<!-- validate -->
<script src="{{asset('js/validate/validate.js')}}"></script>
<script type="text/javascript " src="{{url( 'js/sweetalert/sweetalert.min.js')}} "></script>
<script src="{{asset('js/account/register.min.js')}}"></script>
@endsection