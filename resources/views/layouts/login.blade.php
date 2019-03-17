<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset( 'bootstrap-4.1.3/css/bootstrap.min.css')}}"">
    <script type="text/javascript" src="{{asset('jquery/jquery-3.3.1.min.js')}}">

    </script>
    <script type="text/javascript" src="{{asset('bootstrap-4.1.3/js/bootstrap.min.js')}}">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    {{--
    <script type="text/javascript" src="{{url('js/test.js')}}"></script> --}}

    <!-- Font Awesome JS -->
    <link href="{{asset('Font-Awesome/web-fonts-with-css/css/fontawesome-all.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href={{asset( 'css/style4.css')}}>
    <link rel="stylesheet" href={{asset( 'css/style-theme.css')}}>

    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

    <!-- materialdesignicons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.7.94/css/materialdesignicons.min.css">

    <style>
        #content {
            margin-left: 0
        }
    </style>
</head>

<body>
    
    <!-- <nav class="navbar navbar-expand-lg default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="background: #fff">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" style="margin-top:10px" href="#d">
                <h3 class="text-center"><span style="color:#00ce68">KU</span> CLOUD</h3>
            </a>
            <a class="navbar-brand brand-logo-mini" style="margin-top:10px" href="#">
                <h3 class="text-center" style="color:#00ce68">KU</h3>
               
            </a>
        </div>
    </nav>  -->

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