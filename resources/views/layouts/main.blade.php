<!DOCTYPE html>
<html lang="en">
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('bootstrap-css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('bootstrap-css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('bootstrap-css/ionicons.min.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('bootstrap-css/jquery-jvectormap.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('bootstrap-css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('bootstrap-css/_all-skins.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url('bootstrap-css/dataTables.bootstrap.min.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Table-->
  <link rel="stylesheet" href="{{url('bootstrap-css/jquery-3.3.1.js')}}">
  <link rel="stylesheet" href="{{url('bootstrap-css/jquery.dataTables.min.js')}}">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<header class="main-header">

<!-- Logo -->
<a href="{{action('AdminController@index')}}" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b><font color="#66CC66">KU</font></b><i class="fa fa-cloud"></i></span>

  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b><font color="#66CC66">KU</font></b>-CLOUD<i class="fa fa-cloud"></i></span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="{{url('img/ALVJ1378.jpg')}}" class="user-image" alt="User Image">
          <span class="hidden-xs">Ninja DOGGY</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="{{url('img/ALVJ1378.jpg')}}" class="img-circle" alt="User Image">

            <p>
              Ninja DOGGY
            </p>
            <p><small>xxx@email.com</small><p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href="#" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>

</nav>
</header>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('img/ALVJ1378.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Ninja DOGGY</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" id="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li >
        <a href="{{action('AdminController@user')}}">
            <i class="fa fa-group"></i> <span>User</span>
          </a>
        </li>
        <li>
        <a href="{{action('AdminController@company')}}">
            <i class="fa fa-handshake-o"></i> <span>Company</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <div id="content">
            @yield('content')
  </div>

<!-- Sparkline -->
<script src="{{url('bootstrap-css/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap  -->
<script src="{{url('bootstrap-css/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{url('bootstrap-css/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- ChartJS -->
<script src="{{url('bootstrap-css/Chart.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('dist/js/pages/dashboard2.js')}}"></script>
<!-- SlimScroll -->
<script src="{{url('bootstrap-css/jquery.slimscroll.min.js')}}"></script>
<link rel="stylesheet" href="{{url('bootstrap-css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('bootstrap-css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('bootstrap-css/ionicons.min.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('bootstrap-css/jquery-jvectormap.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('bootstrap-css/_all-skins.min.css')}}">

<!-- jQuery 3 -->
<script src="{{url('bootstrap-css/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('bootstrap-css/bootstrap.min.js')}}"></script>
<!-- DataTables -->
<script src="{{url('bootstrap-css/jquery.dataTables.min.js')}}"></script>
<script src="{{url('bootstrap-css/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{url('bootstrap-css/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('bootstrap-css/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('bootstrap-css/demo.js')}}"></script>
<!--table-->
<link rel="stylesheet" href="{{url('bootstrap-css/table.css')}}">
<script src="{{url('bootstrap-css/table.js')}}"></script>  
 <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <!--bootstap datatable-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">

<!-- page script -->
<script>
  $(document).ready(function() {
    var table = $('#example').DataTable( {
        /*scrollY:        "300px",
        scrollX:        true,*/
        scrollCollapse: true,
        paging:         true,
        /*fixedColumns:   {
            leftColumns: 2
        }*/
    } );
} );

$("#sidebar-menu li a").on('click', function(e){
    $("#sidebar-menu li").removeClass('active');
    $(this).parent().addClass('active');
    //e.preventDefault();
});
</script>  
</body>
</html>