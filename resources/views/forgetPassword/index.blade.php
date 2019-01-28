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

    .form-email {
        width: 50%;
        margin-bottom: 15px;
        -webkit-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
        box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
        background: #FFF;
        border-radius: 4px;

        overflow-y: scroll;
        max-height:90vh;
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
        <form id="form_email" action="{{url('/ForgetPasswordSendMail')}}" method="post" autocomplete="nope">
            <div class="container">
                <div class="row" style="padding: 20px; padding-bottom:0px;">
                    <span style="font-size: 24px;">Forget password?</span>
                </div>
                <hr>
                <div class="row input-data">
                    <span>It happens to all of us. Just enter the email you registered with and we'll email the details to reset your password</span>
                </div>
                <div class="row input-data">
                    <input type="email" name="email" class="form-control" id="input_email" placeholder="Email address" autocomplete="nope">
                    <small class="messages-error"></small>
                </div>
            </div>
        </form>
        <div class="row input-data">
            <div class="col text-center">
                <button class="btn btn-success btn-radius form-control" id="btn_send_email" data-loading-text="Sending..." style="max-width:60%;">Submit</button>
            </div>
        </div>
    </div>
    <span> <span class="font-weight-semibold"> Already have an account ?</span> <a href="{{action('AuthController@index')}}">Sing in</a></span>
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
        if($("#response_message").val() == "true")
        {
            alert("Send mail already.");
        }
    });

    $('#btn_send_email').click(function() {
        $.ajax({
            url: 'http://localhost:8000/api/getAllEmail',
            method: 'POST',
            data: {
                email: $("#input_email").val(),
            },
            success: (res) => {
                if(res.success == true)
                {
                    $('#form_email').submit();
                }
                else
                {
                    $('#form_email').submit();
                    alert(res.detail);
                    return false;
                }
            }
        });
        return false;
    });
</script>
@endsection