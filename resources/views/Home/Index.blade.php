@extends('layouts.home')
@section('content')
<style>
    body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-image: url('imagehome/startpagev1.jpg');
        /* background: linear-gradient(-45deg, #00e4d0, #5983e8, #23A6D5, #23D5AB);
        background-size: 400% 400%;
        -webkit-animation: Gradient 15s ease infinite;
        -moz-animation: Gradient 15s ease infinite;
        animation: Gradient 15s ease infinite; */
    }

    #form_login {
        width: 35%;
        margin: auto;
        padding: 40px 40px 10px;
        -webkit-box-shadow: 0 -25px 37.7px 11.3px rgba(8, 143, 220, 0.07);
        box-shadow: 0 -25px 37.7px 11.3px rgba(8, 143, 220, 0.07);
        background: #FFF;
        border-radius: 4px;
    }

    @media screen and (max-width: 850px) {
        #form_login {
            width: 70%;
        }
    }

    @media screen and (max-width: 600px) {
        #form_login {
            width: 100%;
        }
    }

    #btn-close-login {
        transition: 0.3s;
        cursor: pointer;
    }

    #btn-close-login:hover {

        color: #e13130;
    }

    .header {
        text-align: center;
        color: black;
        /* background: linear-gradient(-45deg, #00e4d0, #5983e8, #23A6D5, #23D5AB);
        background-size: 400% 400%;
        -webkit-animation: Gradient 15s ease infinite;
        -moz-animation: Gradient 15s ease infinite;
        animation: Gradient 15s ease infinite; */    
        height: 100vh;
        z-index: 50;
        min-height: 100vh;
        overflow: hidden;
        text-align: center;
        box-sizing: border-box;
    }

    .content-wrapper {
        /* background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%); */
        top: 100%;
        z-index: 2;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .login-wrapper {
        color: #000;
        top: 100%;
        /* background: linear-gradient(-45deg, #00e4d0, #5983e8, #23A6D5, #23D5AB);
        background-size: 400% 400%;
        -webkit-animation: Gradient 15s ease infinite;
        -moz-animation: Gradient 15s ease infinite;
        animation: Gradient 15s ease infinite;  */
        width: 100%;
        z-index: 3;
        height: 100vh;
        overflow: hidden;
    }

    .modal-content {
        border-radius: 15px !important;
    }

    .modal-header {
        border: 0;
    }

    .modal-footer {
        border: 0;
    }

    @-webkit-keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @-moz-keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }
</style>

<link href="{{url('css/homepage.css')}}" rel="stylesheet">
<link href="{{url('css/ku-cloud.css')}}" rel="stylesheet">
<link href="{{url('css/animate.css')}}" rel="stylesheet">
<link href="{{asset('js/aos/aos.css')}}" rel="stylesheet">


<div class="header">
    <div class="row d-xl-block d-lg-block d-none text-center main-parent" id="header_xl" style="height: 90vh;">
        <div class="col-12 child-parent" style="top:15%;">
            <span class="animated fadeInDown" style="font-size:150px">KU CLOUD</span>
        </div>
        <div class="col-12 child-parent" style="top:55%;">
            <span class="animated" data-aos="fade-up" style="font-size:50px">Private cloud for you</span>
        </div>
        <div class="col-12 child-parent" style="top:65%; cursor:pointer;">
            <i class="fas fa-chevron-down fa-3x mt-5 animated flash"></i>
        </div>
        <!-- <a href="#" class="btn btn-green mt-3 animated fadeIn" id="Login">Go to Site</a> -->
    </div>
    <div class="d-xl-none d-lg-none d-block text-center main-parent" id="header_sm" style="height: 90vh;">
        <div class="col-12 child-parent" style="top:15%;">
            <h3 class="animated fadeInDown" style="font-size:50px">KU CLOUD</h3>
        </div>
        <div class="col-12 child-parent" style="top:25%;">
            <h3 class="animated" data-aos="fade-up" style="font-size:20px">Private cloud for you</h3>
        </div>
        <div class="col-12 child-parent" style="top:30%; cursor:pointer;">
            <i class="fas fa-chevron-down fa-3x mt-5 animated flash"></i>
        </div>
        <!-- <a href="#" class="btn btn-green mt-3 animated fadeIn" id="Login">Go to Site</a> -->
    </div>
</div>

<!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fringilla porta mauris et
                                tincidunt. Ut ac viverra mi. Praesent
                                quis vehicula tellus. Proin dapibus ornare orci, sed sollicitudin metus fringilla et.
                                Mauris
                                consectetur ultricies mi non condimentum. Aliquam lacus arcu, ornare a urna vel,
                                sollicitudin
                                tristique lorem. Vestibulum -->



<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-xs-12 col-12" style="margin-top:10px;">
            <div class="card d-flex" data-aos="fade-down">
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-shield-alt fa-6x fa-gradient-green"></i>
                    </div>
                    <div class="card-title text-center mt-4">
                        <h4>Security</h4>
                    </div>
                    <div class="card-text mt-5">
                        <p>
                            Data on KU CLOUD will encryption all data api and your iot device registered make
                            sure you can trust us
                            to store data on KU CLOUD if you is private user not public user you can see more
                            company at button
                            SEE COMPANY IN
                            KU CLOUD
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-12" style="margin-top:10px;">
            <div class="card" data-aos="fade-down">
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-database fa-6x fa-gradient-blue"></i>
                    </div>
                    <div class="card-title text-center mt-4">
                        <h4>Database storage NoSQL</h4>
                    </div>
                    <p class="card-text mt-5">
                        You can register api from other where or your iot device to store in database KU CLOUD
                        you can select value from api and set value form your iot device to access data and you
                        can set
                        public or private your api and iot device
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-12" style="margin-top:10px;">
            <div class="card" data-aos="fade-down">
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-chart-line fa-6x fa-gradient-yellow"></i>
                    </div>
                    <div class="card-title text-center mt-4">
                        <h4>Realtime and analysis data</h4>
                    </div>
                    <p class="card-text mt-5">
                        You can access data from your api or iot device registered to show result to
                        realtime or static and we have widgets such as muti line , table , text/value , map ,
                        gauges, radar and textbox
                        all of this make you to visualization data very easy. moreover we have infographic to
                        make your report
                        and you can export to images , excel and pdf file
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 text-center mt-5 mb-5">
            <a href="#" class="btn btn-white mt-3 animated fadeIn" id="Login">See company in KU CLOUD</a>
        </div>
    </div>
</div>




<!-- <div class="login-wrapper">
    <div class="d-flex flex-column justify-content-center align-items-center " style="margin: 20px;height: 100vh;">
        <form id="form_login" data-aos="zoom-in">
            <i class="fas fa-times fa-1x" style="float:right" id="btn-close-login"></i>
            <div class="alert alert-danger" style="display:none">
            </div>

            <label>Username</label>
            <input type="text" class="form-control" id="email" placeholder="Username">
            <label>Password</label>
            <input type="password" class="form-control" id="pwd" placeholder="******">
            <button class="btn btn-success btn-block btn-radius mt-3" id="btn-submit-login">Login</button>
            <div class="form-group d-flex justify-content-center mt-3 my-2">
                <a href="{{action('AuthController@forgetPassword')}}" class="text-small forgot-password text-black">Forgot
                    Password</a>

            </div>
            <div class="text-block text-center my-3">
                <span class="text-small font-weight-semibold">Not a member ?</span>
                <a href="{{action('RegisterController@index')}}" class="text-black text-small">Create new account</a>
            </div>
        </form>
    </div>
</div> -->

<div class="background-opar" id="model_background_login">
    <div class="model animate" id="model_body_login">
        <div class="model-content">
            <i class="fas fa-times fa-1x" style="float:right; cursor:pointer" id="btn_close_login"></i>
            <div class="alert alert-danger" style="display:none"></div>
            <label>Username</label>
            <input type="text" class="form-control" id="email_login" placeholder="Username">
            <label>Password</label>
            <input type="password" class="form-control" id="pwd_login" placeholder="Password">
            <button class="btn btn-success btn-block btn-radius mt-3" id="btn_submit_login">Login</button>
            <div class="form-group d-flex justify-content-center mt-3 my-2">
                <a href="{{action('AuthController@forgetPassword')}}" class="text-small forgot-password text-black">Forgot Password</a>
            </div>
            <div class="text-block text-center my-2">
                <span class="text-small font-weight-semibold">Not a member ?</span>
                <a href="{{action('RegisterController@index')}}" class="text-black text-small">Create new account</a>
            </div>
        </div>
    </div>
</div>

<div class="background-opar" id="model_background_register">
    <div class="model animate" id="model_body_register" style="top:5%; width:60%">
        <div class="model-content">
            <i class="fas fa-times fa-1x" style="float:right; cursor:pointer" id="btn_close_register"></i>
            <div class="container">
                <div class="row">
                    <span style="font-size: 24px;">Register</span>
                </div>
                <hr>
            </div>
            <div id="content_register" class="container">
                <form id="form_register" autocomplete="nope">
                    <div class="row">
                        <div class="col-6" style="border-right-style:solid; border-right-width:2px; border-right-color:#eaeaea;">
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
                        </div>
                        <div class="col-6">
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
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <button class="btn btn-success btn-block btn-radius" id="btn_register" data-loading-text="Create my account <i class='fas fa-circle-notch fa-spin'></i>">Create your account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
</footer>

<script src="{{asset('js/aos/aos.js')}}"></script>
<script src="{{asset('js/home/home.js')}}"></script>
<script src="{{asset('js/validate/validate.js')}}"></script>
<script type="text/javascript " src="{{url( 'js/sweetalert/sweetalert.min.js')}} "></script>
<script src="{{asset('js/account/register.min.js')}}"></script>
<script>
    $(document).ready(function () {
    });

</script>
@endsection
