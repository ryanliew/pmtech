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

    <!-- Theme style -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/jasny-bootstrap/jasny-bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="preloader-it">
            <div class="la-anim-1"></div>
        </div> 
        <div class="wrapper pa-0 primary-color-blue">
            <header class="sp-header hidden-xs">
                <div class="sp-logo-wrap pull-left">
                    <a href="{{ url('/') }}">
                        <img class="brand-img" src="{{ asset('img/logo-text.png') }}"></img>
                    </a>
                </div>
                <div class="clearfix"></div>
            </header>
            <div class="visible-xs text-center">
                <div class="sp-logo-wrap mb-5 pl-0">
                    <a href="{{ url('/') }}">
                        <img class="brand-img"></img>
                        <span class="brand-text">{{ config('app.name', 'Welory Solution') }}</span>
                    </a>
                </div>
            </div>
            @yield('content')

            
        </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
