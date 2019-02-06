<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <meta name="ws_url" content="{{ env('WS_URL') }}">
    <meta name="user_id" content="{{ $user->user_id }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('bootstrap-4.1.3/css/bootstrap.min.css')}}">
    <script type="text/javascript" src="{{asset('jquery/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('bootstrap-4.1.3/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap-4.1.3/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/test.js')}}"></script>

    <!-- nouislider -->
    <link rel="stylesheet" href="{{asset('js/nouislider/nouislider.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.0.4/wNumb.js"></script>

    <!-- Font Awesome JS -->
    <link href="{{asset('Font-Awesome/web-fonts-with-css/css/fontawesome-all.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href={{asset( 'css/main.css')}}>
    <!-- <link rel="stylesheet" href={{asset( 'css/style4.css')}}> -->
    <link rel="stylesheet" href={{asset( 'css/style-theme.css')}}>

    <!-- I-check -->
    <link rel="stylesheet" href={{asset( 'css/i-check.min.css')}}>

    <!-- font -->
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/fc-3.2.5/fh-3.1.4/r-2.2.2/sc-1.5.0/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/fc-3.2.5/fh-3.1.4/r-2.2.2/sc-1.5.0/datatables.min.js"></script>

    <!-- gridstack -->
    <link rel="stylesheet" href="{{asset('js/gridstack/gridstack.css')}}">
    <link rel="stylesheet" href="{{asset('js/gridstack/css/index.css')}}">

    <!-- Minicolor -->
    <link rel="stylesheet" href="{{asset('js/Color-Picker-Plugin-jQuery-MiniColors/jquery.minicolors.css')}}">

    <!-- Leaflet -->
    <link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}}" />
    <link rel="stylesheet" href="{{asset('mappadcontrol/L.Control.Pan.css')}}" />
    <script src="{{asset('leaflet/leaflet.js')}}"></script>
    <script src="{{asset('leaflet/BoundaryCanvas.js')}}"></script>
    <script src="{{asset('mappadcontrol/L.Control.Pan.js')}}"></script>
    <script src="{{asset('mappadcontrol/leaflet-tilejson.js')}}"></script>
    <script src="{{asset('leaflet/BoundaryCanvas.js')}}"></script>

    <!-- materialdesignicons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.7.94/css/materialdesignicons.min.css">

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- loading -->
    <link rel="stylesheet" href="{{asset('css/loading.css')}}">

    <script type="text/javascript" src="{{asset('js/Global.js')}}"></script>

    <!-- toastr -->
    <link href="{{asset('js/toastr/toastr.min.css')}}" rel="stylesheet" />

    <!-- socket -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script src="{{asset('js/socket.js')}}"></script>

    <link rel="stylesheet" href="{{asset('freetrans/jquery.freetrans.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.3.4/dist/interact.min.js"></script>

    <!-- pace -->
    <script src="{{asset('pace/pace.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('pace/pace.css')}}">



</head>

<body>
    <div class="pace"></div>
    <nav class="navbar navbar-expand-lg default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" style="margin-top:10px" href="#">
                <h3 class="text-center"><span style="color:#00ce68">KU</span> CLOUD</h3>
            </a>
            <a class="navbar-brand brand-logo-mini" style="margin-top:10px" href="#">
                <h3 class="text-center" style="color:#00ce68">KU</h3>
                <!-- <img src="./logo.png" alt="" height="30px"> -->
            </a>
        </div>

        <div id="sidebarCollapse" class=" ">
            <i class="fas fa-align-left"></i>
        </div>
        <!--<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>-->

        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link dropdown-toggle user-dropdown" id="UserDropdown" href="#" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-angle-right"></i>
                    <span class="profile-text">{{$user->fname." ".$user->lname}}</span>
                    <img class="img-xs rounded-circle" width="30" height="30" src="http://localhost:8000/api/account/profile/{{$user->img_profile}}"
                        alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <a class="dropdown-item ">
                        <div class="d-flex border-bottom">
                            <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                <i class="far fa-bookmark text-muted"></i>
                            </div>
                            <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                                <i class="far fa-user text-muted"></i>
                            </div>
                            <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                <i class="far fa-bell text-muted"></i>
                            </div>
                        </div>

                    </a>
                    <a class="dropdown-item mt-2" href="{{action('CompanyController@manageAccounts')}}">
                        Manage Accounts
                    </a>
                    <a class="dropdown-item">
                        Check Inbox
                    </a>
                    <a class="dropdown-item" href="{{action('CompanyController@Logout')}}">
                        Sign Out
                    </a>
                </div>
            </li>

        </ul>
        <!-- </div> -->
        </div>
    </nav>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="sidebar">

            <ul class="list-unstyled components" style="margin-top:60px">
                <li class="nav-item nav-profile">
                    <!--<div class="nav-link nav-profile-hide">
                        <div class="user-wrapper">
                            <div class="profile-image">
                                <img src="data:image/png;base64,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"
                                    alt="">
                            </div>
                            <div class="text-wrapper">
                                <p class="profile-name">Richard V.Welsh</p>
                                <div>
                                    <small class="designation text-muted">Manager</small>
                                    <span class="status-indicator online"></span>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </li>
                @can('isCompanyAdmin')
                <li class="nav-item">
                    <a href="{{action('CompanyController@user')}}">
                        <i class="fas fa-users"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{action('CompanyController@customer')}}">
                        <i class="fas fa-briefcase"></i>
                        <span>Customer</span>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-collapse">
                        <i class="fas fa-database"></i>
                        <span>Input Service</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <ul class="collapse list-unstyled sub" id="homeSubmenu">
                        <li class="nav-item">
                            <a href="{{action('CompanyController@service')}}">Web Service</a>
                        </li>


                        <li class="nav-item">
                            <a href="{{action('CompanyController@Output_service')}}">Output Service</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{action('CompanyController@iot')}}">IoT</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{action('CompanyController@infographic')}}">
                        <i class="fas fa-file-image"></i>
                        <span class="link_hide">Infographic</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{action('CompanyController@staticDatatable')}}">
                        <i class="fas fa-chart-line"></i>
                        <span class="link_hide">Static</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#AnalysisSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-collapse">
                        <i class="far fa-file-alt"></i>
                        <span>Analysis</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <ul class="collapse list-unstyled sub" id="AnalysisSubmenu">
                        <li class="nav-item">
                            <a href="{{action('CompanyController@AnalysisPrepareData')}}">
                                Prepare data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{action('CompanyController@DataAnalysis')}}">
                                Data Analysis
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#LogSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-collapse">
                        <i class="far fa-file-alt"></i>
                        <span>Logs</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <ul class="collapse list-unstyled sub" id="LogSubmenu">
                        <li class="nav-item">
                            <a href="{{action('CompanyController@LogViewer')}}">
                                Database Logs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="">
                                Datawarehouse Logs
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- jQuery Custom Scroller CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.0/lodash.min.js"></script>

        <link rel="stylesheet" href="{{asset('js/circliful/jquery.circliful.css')}}" />
        <script type="text/javascript" src="{{asset('js/circliful/jquery.circliful.min.js')}}"></script>

        <!--toastr.min.js -->
        <script src="{{asset('js/toastr/toastr.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('freetrans/Matrix.js')}}"></script>
        <script type="text/javascript" src="{{asset('freetrans/jquery.freetrans.js')}}"></script>
        <script type="text/javascript" src="{{asset('circlejson/circular-json.js')}}"></script>
        <script type="text/javascript" src="{{url('htmltocanvas/htmltocanvas.js')}}"></script>

        <!-- validate -->
        <script src="{{asset('js/validate/validate.js')}}"></script>



        <!-- Page Content  -->
        <div id="content" class="content">
            @yield('content')
        </div>

        <script>
            paceOptions = {
                ajax: true,
                document: true,
                eventLag: false
            };

            Pace.on('done', function () {
                $('#preloader').delay(500).fadeOut(800);
            });

        </script>

</body>

</html>
