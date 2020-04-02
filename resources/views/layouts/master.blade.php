<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <link rel="stylesheet" type="text/css" href="{{asset('/css/custom.css')}}">
        <!--sweet alert  starts-->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- sweet alert ends -->
        <!-- <title>{{-- config('app.name', 'Laravel') --}}</title> -->
        <title>Complete Athlete - @yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="{{ asset('/admin/plugins/font-awesome/css/font-awesome.min.css') }}">

        <script src="{{ asset('/admin/jquery_validate/jquery.min.js') }}"></script>

        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- data tables -->
        <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/dt.css') }}">
     <!--    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/dataTables.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables/dataTables.bootstrap.css') }}"> -->

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('/admin/plugins/iCheck/flat/blue.css') }}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{ asset('/admin/plugins/morris/morris.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset('/admin/plugins/datepicker/datepicker3.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('/admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
        <!-- bootstrap wysihtml5 - text editor -->
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
         <script src="https://cdn.tiny.cloud/1/2jdr5l9ajoxntvz9e7ifjvkqi6j603280wtyg03q119cyv2q/tinymce/5/tinymce.min.js"></script>
          <script src="https://www.tinymce.com/docs/plugins/lists/ https://www.tinymce.com/docs/plugins/advlist/"></script>
        <script>tinymce.init({selector:'textarea.myeditor',height: "500px",plugins: "lists, advlist"});

        </script>

  
        <link rel="stylesheet" href="{{ asset('/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini">
        <style type="text/css">
            .main-header {
                background-color: #3c8dbc !important;
            }
            .navbar .nav>li>a{
                    color: #fff !important;
            }
            .img-circle-admin {
                float: left;
                width: 25px;
                height: 25px;
                border-radius: 50%;
                margin-right: 10px;
                margin-top: -2px;
            }
        </style>
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('home') }}" class="nav-link">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @if(Auth::user()->image!="")
                            <img src="{{ asset('/images/'.Auth::user()->image) }}" class="img-circle-admin" alt="User Image">{{ Auth::user()->name }} <span class="caret"></span>
                            @else
                            <img src="{{ asset('/images/user.png') }}" class="img-circle-admin" alt="User Image"><span class="caret"></span>

                            @endif
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin_profile') }}" >
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4 my_sidebar">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="brand-link">
                    <!-- <span class="brand-text font-weight-light">Sguardone</span> -->
                    <h4 style="text-align: center;font-family: serif;">Complete Athlete</h4>
                     <!-- <img src="{{ asset('/logo.png') }}"  class="render-image" style="height: 40px; margin: 0px 0px 0px 50px !important;"> -->
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                with font-awesome or any other icon font library -->
                            <li class="nav-item has-treeview @if(Route::currentRouteName() == 'home') {{ 'menu-open' }} @endif">
                                <a href="{{ route('home') }}" class="nav-link @if(Route::currentRouteName() == 'home') {{ 'active' }} @endif">
                                    <i class="nav-icon fa fa-home"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview @if(Route::currentRouteName() == 'ath_list' || Route::currentRouteName() == 'coach_list' ) {{ 'active menu-open' }} @endif">
                                <a href="#" class="nav-link @if(Route::currentRouteName() == 'ath_list' || Route::currentRouteName() == 'coach_list' ){{ 'active' }}) @endif">
                                    <i class="nav-icon fa fa-user" style="font-size: 1.5rem;"></i>
                                    <p>
                                    @if(Auth::user()->role==0)
                                        View Users
                                       @else 
                                        Manage Users
                                        @endif
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview ">
                                  
                                      <li class="nav-item">
                                        <a href="{{ route('ath_list') }}" class="nav-link @if(Route::currentRouteName() == 'ath_list') {{ 'active' }} @endif">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Athletes Listing</p>
                                        </a>
                                    </li>
                                    @if(Auth::user()->role==2)
                                     <li class="nav-item">
                                        <a href="{{ route('coach_list') }}" class="nav-link @if(Route::currentRouteName() == 'coach_list') {{ 'active' }} @endif">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Coach Listing</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                                <li class="nav-item has-treeview @if(Route::currentRouteName() == 'workout_listing' || Route::currentRouteName() == 'workout_add') {{ 'active menu-open' }} @endif">
                                <a href="#" class="nav-link @if(Route::currentRouteName() == 'workout_listing' || Route::currentRouteName() == 'workout_add') {{ 'active' }}) @endif">
                                  <i class="fa fa-child" aria-hidden="true" style="font-size:25px"></i>
                                    <p>
                                        Manage Workouts
                                        <i class="fa fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview ">
                                     @if(Auth::user()->role==2)
                                     <li class="nav-item">
                                        <a href="{{ route('workoutplace_add') }}" class="nav-link @if(Route::currentRouteName() == 'workoutplace_add') {{ 'active' }} @endif">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Add workout places</p>
                                        </a>
                                    </li>
                                    @endif
                                      <li class="nav-item">
                                        <a href="{{ route('workout_add') }}" class="nav-link @if(Route::currentRouteName() == 'workout_add') {{ 'active' }} @endif">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Add workouts</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('workout_listing') }}" class="nav-link @if(Route::currentRouteName() == 'workout_listing') {{ 'active' }} @endif">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>All Workouts</p>
                                        </a>
                                    </li>
                                     @if(Auth::user()->role==2)
                                    <li class="nav-item">
                                        <a href="{{ route('video_upload') }}" class="nav-link @if(Route::currentRouteName() == 'video_upload') {{ 'active' }} @endif">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>Add Video</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; {{date('Y')}} <a href="#">Complete Athlete</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <!-- <b>Version</b> 3.0.0-alpha -->
                </div>
            </footer>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <!-- jQuery -->
        <script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('/admin/jquery_validate/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('/admin/jquery_validate/additional-methods.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- data tables -->
        <!-- <script src="{{ asset('/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script> -->
         
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael.1.0/raphael-min.js"></script>
        <script src="{{ asset('/admin/plugins/morris/morris.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('/admin/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        
        <!-- jvectormap -->
        <script src="{{ asset('/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('/admin/plugins/knob/jquery.knob.js') }}"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="{{ asset('/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- datepicker -->
        <script src="{{ asset('/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset('/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset('/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('/admin/plugins/fastclick/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('/admin/dist/js/adminlte.js') }}"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!-- <script src="{{ asset('/admin/dist/js/pages/dashboard.js') }}"></script> -->
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('/admin/dist/js/demo.js') }}"></script>
        <script type="text/javascript">

            $('div.alert').delay(3000).slideUp(300);
        </script>
        <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>        
        <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({                 
                          "paging": false,
                          "lengthChange": true,
                          "searching": true,
                          "ordering": true,
                          "info": true,
                          "autoWidth": true,
                          "paging":true                          
                                    
                        });
            new $.fn.dataTable.FixedHeader( table );
        });
        </script>
    </body>
</html>