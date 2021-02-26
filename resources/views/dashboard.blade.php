<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Jobberman</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="../../index3.html" class="navbar-brand">
                    <img src="https://www.jobberman.com/build/static-assets/img/ng/landscape-86f8ce6fb7.svg" alt="AdminLTE Logo"
                        class="brand-image" style="opacity: .8">
                    <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                       
                        <li class="nav-item">
                            <router-link to="/home" class="nav-link">
                                <p class="nav-item">Dashboard</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/company" class="nav-link">
                                <p class="nav-item">Company</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/employee" class="nav-link">
                                <p class="nav-item">Employee</p>
                            </router-link>
                        </li>
                       
                    </ul>

                   
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- Messages Dropdown Menu -->
                   
                    <!-- Notifications Dropdown Menu -->
                   
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fa fa-user"></i> {{ Auth::user()->fullname }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            
                            <router-link to="/profile" class="dropdown-item">
								<p>Update Profile</p>
							</router-link>
                            <router-link to="/profile/change-password" class="dropdown-item">
								<p>Change Password</p>
							</router-link>
                            
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <router-view></router-view>
            <!-- Content Header (Page header) -->
            
        </div>
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        <footer class="main-footer text-center">

            <!-- Default to the left -->
            <strong>Copyright &copy; {{date('Y')}} <a href="#">Jobberman</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

</body>

</html>