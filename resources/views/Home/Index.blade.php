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
        overflow-x: hidden;
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

    .footer-row{
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5) !important;
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
        z-index: 50;
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

    .contactText{
        display: block;
        font-size: 1em;
    }

    /* .modal-content {
        border-radius: 15px !important;
    }

    .modal-header {
        border: 0;
    }

    .modal-footer {
        border: 0;
    } */

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
    <div class="row d-xl-block d-lg-block d-none text-center main-parent" id="header_xl" style="height: 100vh;">
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
    <div class="d-xl-none d-lg-none d-block text-center main-parent" id="header_sm" style="height:50vh">
        <div class="col-12 child-parent" style="top:40%;">
            <h3 class="animated fadeInDown" style="font-size:50px">KU CLOUD</h3>
        </div>
        <div class="col-12 child-parent" style="top:55%;">
            <h3 class="animated" data-aos="fade-up" style="font-size:20px">Private cloud for you</h3>
        </div>
        <div class="col-12 child-parent" style="top:60%; cursor:pointer;">
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
            <a href="{{action('HomeController@CompanyList')}}" class="btn btn-white mt-3 animated fadeIn" id="Login">See company in KU CLOUD</a>
        </div>
    </div>
</div>


<footer>

        <div class="row" style="background:white; padding:20px;">
            <div class="col-xl-4 col-12 mt-4">
                <span class="text-center" style="font-size:5vw"><span style="color:#00ce68">KU</span> CLOUD</span>
            </div>
            <div class="col-xl-3 col-12 mt-4" style="color:#848684;">
                <span class="text-left contactText">ADDRESS</span>
                <span class="text-left contactText">1 Moo.6</span>
                <span class="text-left contactText">Kamphaengsaen</span>
                <span class="text-left contactText">Kamphaengsaen</span>
                <span class="text-left contactText">Nakhon Pathom 73140</span>
            </div>
            <div class="col-xl-3 col-12 mt-4" style="color:#848684;">
                <span class="text-left contactText">CONTACTS</span>
                <span class="text-left contactText">Email: ku.cloud.service@gmail.com</span>
                <span class="text-left contactText">Phone: +66.(0)3.428.1074</span>
                <span class="text-left contactText">Fax: +66.(0)3.428.1074</span>
            </div>
        </div>

</footer>


@endsection
