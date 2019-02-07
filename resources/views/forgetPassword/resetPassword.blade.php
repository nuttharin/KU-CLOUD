@extends('layouts.login') 
@section('content')
<style>
    html,body {
        background: #A1FFCE;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to bottom, #FAFFD1, #A1FFCE);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to bottom, #FAFFD1, #A1FFCE);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .form-email {
        width: 30%;
        margin-bottom: 15px;
        -webkit-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
        box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
        background: #FFF;
        border-radius: 4px;

        overflow-y: scroll;
        max-height:90vh;
    }

    @media screen and (max-width: 850px) {
        .form-email{
            width: 70%;
        }
    }

    @media screen and (max-width: 600px) {
        .form-email {
            width: 100%;
        }
    }

    .form-email::-webkit-scrollbar { 
        display: none; 
    }

    .content {
        padding: 30px 10px 30px 30px;
    }

    .input-data {
        padding: 20px;
        padding-top: 0px;
    }
</style>

<div class="content d-flex flex-column justify-content-center align-items-center" style="width:100%; height:100vh;">
    <div class="form-email">
        <form id="form_reset" action="{{url('/ResetPasswordPost')}}" method="post" autocomplete="nope">
            <div class="container">
                <div class="row" style="padding: 20px; padding-bottom:0px;">
                    <span style="font-size: 24px;">Reset password</span>
                </div>
                <hr>
                <div class="row input-data" style="margin: 0px; padding-bottom:10px;">
                    <label>New password</label>
                </div>
                <div class="input-group row input-data" style="margin: 0px;">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="nope">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span style="cursor:pointer"><i class="fas fa-eye-slash" id="toggle_pwd"></i></span>
                        </div>
                    </div>
                    <small class="messages-error"></small>
                </div>
                <div class="row input-data" style="margin: 0px; padding-bottom:10px;">
                    <label>Confirm password</label>
                </div>
                <div class="input-group row input-data" style="margin: 0px;">
                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Comfirm Password" autocomplete="nope">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span style="cursor:pointer"><i class="fas fa-eye-slash" id="toggle_confirm_pwd"></i></span>
                        </div>
                    </div>
                    <small class="messages-error"></small>
                </div>
            </div>
            <input type="hidden" id="user_id" name="user_id" value="{{$userId}}"/>
        </form>
        <div class="row input-data">
            <div class="col text-center">
                <button class="btn btn-success btn-radius form-control" id="btn_reset_pass" data-loading-text="Loading..." style="max-width:60%;">Submit</button>
            </div>
        </div>
    </div>
    @if (isset($responseMessage))
    <input type="hidden" id="response_message" value="{{$responseMessage}}"/>
    @endif
</div>

<!-- validate -->
<!-- <script src="{{asset('js/validate/validate.js')}}"></script>
<script type="text/javascript " src="{{url( 'js/sweetalert/sweetalert.min.js')}} "></script>
<script src="{{asset('js/account/register.min.js')}}"></script> -->

<script>
    $(document).ready(function() {
        if($("#response_message").val() != null)
        {
            alert($("#response_message").val());
        }
    });

    $("#toggle_pwd").click(function () {
        if ($("#password").attr("type") == 'text')
        {
            $("#password").attr('type', 'password');
            $("#toggle_pwd").removeClass("far fa-eye");
            $("#toggle_pwd").addClass("fas fa-eye-slash");
        }
        else
        {
            $("#password").attr('type', 'text');
            $("#toggle_pwd").removeClass("fas fa-eye-slash");
            $("#toggle_pwd").addClass("far fa-eye");
        }
    });

    $("#toggle_confirm_pwd").click(function () {
        if ($("#confirmPassword").attr("type") == 'text')
        {
            $("#confirmPassword").attr('type', 'password');
            $("#toggle_confirm_pwd").removeClass("far fa-eye");
            $("#toggle_confirm_pwd").addClass("fas fa-eye-slash");
        }
        else
        {
            $("#confirmPassword").attr('type', 'text');
            $("#toggle_confirm_pwd").removeClass("fas fa-eye-slash");
            $("#toggle_confirm_pwd").addClass("far fa-eye");
        }
    });

    $('#btn_reset_pass').click(function() {
        if ($("#password").val() != $("#confirmPassword").val())
        {
            alert("New password mismatch.")
            $("#confirmPassword").val("");
            $("#confirmPassword").focus();

            return false;
        }

        $('#form_reset').submit();
    });
</script>
@endsection