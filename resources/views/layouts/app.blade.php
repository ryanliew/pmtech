<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Toast style -->
    <link href="{{ asset('js/vendors/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/vendors/jasny-bootstrap/jasny-bootstrap.min.css') }}" rel="stylesheet">

    @yield('css')

     <!-- Theme style -->
    <link href="{{ asset('css/style.css?v=1.2') }}" rel="stylesheet">
</head>
<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div> 
    <div id="app">
        <div class="wrapper theme-4-active primary-color-blue">
            <!-- Top menu items -->
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="mobile-only-brand pull-left">
                    <div class="nav-header pull-left">
                        <div class="logo-wrap">
                            <a href="{{ url('/home') }}">
                                <img class="brand-img"/>
                                <span class="brand-text">{{ config('app.name', 'Welory Solution') }}</span>
                            </a>
                        </div>
                    </div>  
                    <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
                </div>
                <div id="mobile_only_nav" class="mobile-only-nav pull-right">
                    <ul class="nav navbar-right top-nav pull-right">
                        <li class="dropdown auth-drp">
                            <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">Welcome, {{ auth()->user()->name }} <i class="fa fa-caret-down"></i></a>
                            <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                <li>
                                    <a href="{{ route('user.profile') }}">
                                        <i class="fa fa-address-book"></i><span>My profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transactions', auth()->id()) }}">
                                        <i class="fa fa-bank"></i><span>My transactions</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off"></i><span>Logout</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>  
            </nav> 
            <!-- Top menu items -->
            <!-- Left Sidebar Menu -->
            <div class="fixed-sidebar-left">
                <ul class="nav navbar-nav side-nav nicescroll-bar">
                    <li class="navigation-header">
                        <span>Welcome, {{ auth()->user()->name }}</span>
                    </li>
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="fa fa-dashboard mr-20"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.profile') }}">
                            <i class="fa fa-address-book mr-20"></i><span>My profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transactions', auth()->id()) }}">
                            <i class="fa fa-bank mr-20"></i><span>My transactions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off mr-20"></i><span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <li class="navigation-header">
                        <span>Main</span> 
                        <i class="fa fa-chevron-circle-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('users') }}"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">Users</span></div><div class="clearfix"></div></a>
                    </li> 
                    <li>
                        <a href="{{ route('machines') }}"><div class="pull-left"><i class="fa fa-server mr-20"></i><span class="right-nav-text">Machines</span></div><div class="clearfix"></div></a>
                    </li>
                    <li>
                        <a href="{{ route('settings') }}"><div class="pull-left"><i class="fa fa-cog mr-20"></i><span class="right-nav-text">Settings</span></div><div class="clearfix"></div></a>
                    </li>
                    <li><hr class="light-grey-hr mb-10"/></li>
                </ul>
            </div>
            <!-- /Left Sidebar Menu -->


            <div class="page-wrapper">
                <div class="container-fluid pt-25"> 
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2017 &copy; {{ config('app.name', 'Welory Solution') }}. Pampered by Welory Solution</p>
                        </div>
                    </div>
                </footer>
                <!-- /Footer -->  
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script>
        @if( $errors->any() )
            @foreach($errors->all() as $error)
                $.toast({
                    heading: 'Error',
                    text: '{{ $error }}',
                    position: 'top-right',
                    loaderBg: '#fec107',
                    icon: 'error',
                    hideAfter: 3500 
                }); 
            @endforeach
        @endif

        @if( session('success') )
            $.toast({
                heading: 'Success',
                text: '{{ session("success") }}',
                position: 'top-right',
                loaderBg: '#fec107',
                icon: 'success',
                hideAfter: 3500 
            }); 
        @endif

        @if( session('error') )
            $.toast({
                heading: 'Error',
                text: '{{ session("error") }}',
                position: 'top-right',
                loaderBg: '#fec107',
                icon: 'error',
                hideAfter: 3500 
            }); 
        @endif
    </script>
    @yield('js')
</body>
</html>
