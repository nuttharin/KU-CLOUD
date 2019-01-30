@extends('layouts.home')
@section('content')
<style>
    body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        
        background: linear-gradient(-45deg, #00e4d0, #5983e8, #23A6D5, #23D5AB);
        background-size: 400% 400%;
        -webkit-animation: Gradient 15s ease infinite;
        -moz-animation: Gradient 15s ease infinite;
        animation: Gradient 15s ease infinite;
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
        color: #fff;
        /* background: linear-gradient(-45deg, #00e4d0, #5983e8, #23A6D5, #23D5AB);
        background-size: 400% 400%;
        -webkit-animation: Gradient 15s ease infinite;
        -moz-animation: Gradient 15s ease infinite;
        animation: Gradient 15s ease infinite; */
        
      
        height: 100vh;
        z-index: 1;
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

<link href="{{url('css/ku-cloud.css')}}" rel="stylesheet">
<link href="{{url('css/animate.css')}}" rel="stylesheet">
<link href="{{asset('js/aos/aos.css')}}" rel="stylesheet">


<header class="header">
    <div class="d-flex flex-column justify-content-center align-items-center" id="header" style="margin: 20px;height: 100vh;">
        <h1 class="display-1 animated fadeInDown ">KU CLOUD</h1>
        <h1 class="display-4 animated" data-aos="fade-up">Private cloud for you</h1>
        <i class="fas fa-chevron-down fa-3x mt-5 animated flash"></i>
        <a href="#" class="btn btn-green mt-3 animated fadeIn" id="Login">Go to Site</a>
    </div>
</header>

<!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fringilla porta mauris et
                                tincidunt. Ut ac viverra mi. Praesent
                                quis vehicula tellus. Proin dapibus ornare orci, sed sollicitudin metus fringilla et.
                                Mauris
                                consectetur ultricies mi non condimentum. Aliquam lacus arcu, ornare a urna vel,
                                sollicitudin
                                tristique lorem. Vestibulum -->

<main class="content-wrapper d-flex flex-column justify-content-around">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
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
                <div class="col-12 col-md-4">
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
                <div class="col-12 col-md-4">
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
                <div class="col-12 text-center mt-5">
                    <a href="#" class="btn btn-white mt-3 animated fadeIn" id="Login">See company in KU CLOUD</a>
                </div>
            </div>
        </div>

    </section>
</main>

<div class="login-wrapper">
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
</div>


<footer>

</footer>

<script src="{{asset('js/aos/aos.js')}}"></script>
<script>
    $(document).ready(function () {
        // let height = $(window).height();
        // $("#header").height(height);

        // $(window).resize(function () {
        //     $("#header").height(height);
        // });
        AOS.init();
        $("#Login").click(function () {
            // $(".login-wrapper").animate({
            //     "top": "0"
            // })
            // $("#d-flex-login").animate({
            //     "height": height
            // })
            $('html, body').animate({
                scrollTop: $(".login-wrapper").offset().top
            }, 800, function () {


            });
        });

        $("#btn-close-login").click(function () {
            // $(".login-wrapper").animate({
            //     "top": "100%"
            // })
            $('html, body').animate({
                scrollTop: $(".header").offset().top
            }, 800, function () {


            });

        });

        $("a#about").click(function () {
            $('html, body').animate({
                scrollTop: $(".content-wrapper").offset().top -25
            }, 800, function () {


            });
        });

        $('#btn-submit-login').click(function () {
            event.preventDefault();
            $.ajax({
                url: "http://localhost:8000/api/Auth/Login",
                method: "POST",
                dataType: "json",
                data: {
                    email: $("#email").val(),
                    password: $("#pwd").val()
                },
                success: (res) => {
                    setCookie("token", res.token);
                    window.location = res.path;
                },
                error: (res) => {
                    if (res.status === 500) {
                        $(".alert ").show();
                        $(".alert ").html("<strong>Error!</strong> Please check email " +
                            $(
                                "#email").val() + " to verify.");
                    }
                }
            });
        })

        $("input,button").focus(function () {
            $(".alert").hide();
        });
    });

</script>
@endsection
