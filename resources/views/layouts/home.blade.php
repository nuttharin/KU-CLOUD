<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset( 'bootstrap-4.1.3/css/bootstrap.min.css')}}"">
    <script type=" text/javascript"
        src="{{asset('jquery/jquery-3.3.1.min.js')}}">
    </script>
    <script type="text/javascript" src="{{asset('bootstrap-4.1.3/js/bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <!-- <script type="text/javascript" src="{{url('js/test.js')}}"></script> -->

    <!-- Font Awesome JS -->
    <link href="{{asset('Font-Awesome/web-fonts-with-css/css/fontawesome-all.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-theme.css')}}">

    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

    <!-- materialdesignicons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.7.94/css/materialdesignicons.min.css">

    <style>
        .content {
            margin-left: 0
        }
        .navbar.default-layout{
            background-color: #fff !important;
            background:#fff;
            height: 63px;
        }
        .nav-item >  .nav-link{
            color: #777777 !important;
        }
        .nav-item > .nav-link:hover{
            color: #000000 !important;
        }
    </style>
</head>

<body>

    <!-- <nav class="navbar navbar-expand-lg default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row " style="background: #fff">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" style="margin-top:10px" href="#">
                <h3 class="text-center"><span style="color:#00ce68">KU</span> CLOUD</h3>
            </a>
        </div>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link">
                    About
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    Contact
                </a>
            </li>
        </ul>
    </nav> -->

    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" style="box-shadow: 0 0 0.5cm rgba(0,0,0,0.5) !important;"> 
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#"><h3 class="text-left"><span style="color:#00ce68">KU</span> CLOUD</h3></a>


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
                        <a class="nav-link" href="{{action('RegisterController@index')}}" id="nav_register">REGISTER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_login" href="#" id="nav_login">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </nav>

    <!-- <nav class="navbar navbar-expand-lg default-layout col-lg-12 col-12 p-0 fixed-top nav_back" id="navbar_fixed" style="  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5) !important;">
        <div class="container d-xl-block d-lg-block d-none">
            <div class="row col-12">
                <div class="col-8">
                    <h3 class="text-left"><span style="color:#00ce68">KU</span> CLOUD</h3>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-3">
                            <span class="nav-link" id="about" href="#" style="cursor:pointer;">ABOUT</span>
                        </div>
                        <div class="col-3">
                            <span class="nav-link" href="#" style="cursor:pointer;">CONTACT</span>
                        </div>
                        <div class="col-3">
                            <span class="nav-link" id="nav_register" href="#" style="cursor:pointer;">REGISTER</span>
                        </div>
                        <div class="col-3">
                            <span class="nav-link nav_login" id="nav_login" href="#" style="cursor:pointer;">LOGIN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-xl-none d-lg-none d-block">
            <div class="row col-12">
                <div class="col-8">
                    <h3 class="text-left"><span style="color:#00ce68">KU</span> CLOUD</h3>
                </div>
                <div class="col-4">
                    <span class="nav-link nav_login" href="#" style="font-size:80%; cursor:pointer;">REGISTER / LOGIN</span>
                </div>
            </div>
        </div>
    </nav> -->

    <script type="text/javascript" src="{{asset('js/Global.js')}}"></script>

            
    <script>
        const END_POINT = "{{ env('API_URL') }}";
        const END_POINT_WED = "{{env('APP_URL')}}";
    </script>

    <!-- Page Content  -->
    <div id="content-login">
        @yield('content')
    </div>

</body>

</html>
