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
    
        .form-reset-password {
            width: 30%;
            margin-bottom: 15px;
            -webkit-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
            box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
            background: #FFF;
            border-radius: 4px;
        }
    
        @media screen and (max-width: 850px) {
            .form-reset-password {
                width: 70%;
            }
        }
    
        @media screen and (max-width: 600px) {
            .form-reset-password {
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
        <div class="form-reset-password">
            <form id="form_reset_password" autocomplete="nope">
                <div class="container">
                    <div class="row" style="padding: 20px; padding-bottom:0px;">
                        <span style="font-size: 24px;">Reset password</span>
                    </div>
                    <hr>
                    <input type="text" id="user_id" value="{{$user_id}}" hidden>
                    <input type="text" id="token" value="{{$token}}" hidden>
                    <div class="row input-data">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="new-password">
                        <small class="messages-error"></small>
                    </div>
                    <div class="row input-data">
                        <label for="confirmPassword">Confirm password <span class="text-danger">*</span></label>
                        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                        <small class="messages-error"></small>
                    </div>
                    <div class="row input-data">
                            <button class="btn btn-success btn-block btn-radius" id="btn_reset_password" data-loading-text="Reset password <i class='fas fa-circle-notch fa-spin'></i>">Reset password</button>
                    </div>
                </div>
            </form>
        </div>
        <span> <span class="font-weight-semibold"> Already have an account ?</span> <a href="#">Sing in</a></span>
    </div>
    <!-- validate -->
<script src="{{asset('js/validate/validate.js')}}"></script>
<script type="text/javascript " src="{{url( 'js/sweetalert/sweetalert.min.js')}} "></script>
<script src="{{asset('js/auth/resetPasswordFirst.min.js')}}"></script>
@endsection