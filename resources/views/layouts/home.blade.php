<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('bootstrap-4.1.3/css/bootstrap.min.css')}}">
    <script src="{{asset('jquery/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('bootstrap-4.1.3/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap-4.1.3/js/bootstrap.min.js')}}"></script>


    <!-- Font Awesome JS -->
    <link href="{{asset('Font-Awesome/web-fonts-with-css/css/fontawesome-all.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-theme.css')}}">

    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

    <!-- materialdesignicons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.7.94/css/materialdesignicons.min.css">

    <!-- loding -->
    <link rel="stylesheet" href="{{asset('css/loading.css')}}">

    <script  src="{{asset('js/navHome.js')}}"></script>
    

    <style>
        .content {
            margin-left: 0
        }

        .navbar.default-layout {
            background-color: #fff !important;
            background: #fff;
            height: 63px;
        }

        .nav-item>.nav-link {
            color: #777777 !important;
        }

        .nav-item>.nav-link:hover {
            color: #000000 !important;
        }

        .nav-item.active a {
            color: #000000  !important
        }

    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top"
        style="box-shadow: 0 0 0.5cm rgba(0,0,0,0.2) !important;">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <h3 class="text-left"><span style="color:#00ce68">KU</span> CLOUD</h3>
            </a>


            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="about">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{action('HomeController@CompanyList')}}" id="company">COMPANY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="contact">CONTACT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{action('RegisterController@index')}}" id="nav_register">REGISTER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{action('DashboardController@DashboardsPublic')}}"
                            id="nav_dashboards">DASHBOARDS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_login" href="#" id="nav_login">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </nav>

    <script type="text/javascript" src="{{asset('js/Global.js')}}"></script>


    <script>
        const END_POINT = "{{ env('API_URL') }}";
        const END_POINT_WED = "{{env('APP_URL')}}";
        const WS_URL  = "{{env('WS_URL')}}";
        console.log(END_POINT);
    </script>

    <script src="{{asset('js/aos/aos.js')}}"></script>
    <script src="{{asset('js/validate/validate.js')}}"></script>
    <script src="{{asset('js/home/home.min.js')}}"></script>
    <script src="{{asset( 'js/sweetalert/sweetalert.min.js')}} "></script>
    <script src="{{asset('js/account/register.min.js')}}"></script>

    <!-- socket -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.0/lodash.min.js"></script>
    <script type="text/javascript" src="{{url('htmltocanvas/htmltocanvas.js')}}"></script>

    <!-- Page Content  -->
    <div id="content" >
        @yield('content')
    </div>

    <div class="modal fade" id="model_body_login">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header" style="border-bottom:0px">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <div class="modal-body" style="padding:42px;">
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="row form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username">
                        <small class="messages-error"></small>
                    </div>
                    <div class="row form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="pwd_login" placeholder="Password">
                        <small class="messages-error"></small>
                    </div>

                    <button class="btn btn-success btn-block btn-radius mt-3" id="btn_submit_login">Login</button>
                    <div class="form-group d-flex justify-content-center mt-3 my-2">
                        <a href="{{action('AuthController@forgetPassword')}}"
                            class="text-small forgot-password text-black">Forgot
                            Password
                        </a>
                    </div>
                    <div class="text-block text-center my-2">
                        <span class="text-small font-weight-semibold">Not a member ?</span>
                        <a href="{{action('RegisterController@index')}}" class="text-black text-small">Create new
                            account</a>
                    </div>
                </div>

                <div class="modal-footer" style="border-top:0px">
                </div>

            </div>
        </div>
    </div>
</body>

</html>
