<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title')
        - Laravel
    </title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield('styles')

    @yield('head')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li><a href="{{ url('/forum') }}">Foros</a></li>
                    <li><a href="{{ url('/blogs') }}">Blogs</a></li>
                    <li><a href="{{ url('/galleries') }}">Galleries</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav nav-pills navbar-right" role="tablist">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="#" data-toggle="modal" data-target="#ModalLogIn">Login</a></li>
                        {{--<li><a href="{{ url('/login') }}">Login</a></li>--}}
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li>
                            <a href="#" class="dropdown-toggle"
                               data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-bell fa-lg"></i> <span class="badge" style="right:0px;position:absolute;top:5px;background:#ad1457"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle"
                               data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-envelope fa-lg"></i>
                                <?php $alerts = Auth::user()->pm_alerts()->where('is_read', '=', 0)->get() ?>
                                <span class="badge" style="right:0px;position:absolute;top:5px;background:#ad1457">{{ (count($alerts) > 0) ? count($alerts) : '' }}</span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('users.pm.index') }}"><i class="glyphicon glyphicon-list"></i> Ir a Inbox</a></li>
                            </ul>
                        </li>
                        <li role="separator"></li>
                        {{--
                        <li>
                            <a href="#" class="dropdown-toggle" id="user-panel">
                                {!! Auth::user()->profile->ImgAvatar(30,30) !!}
                                <span class="caret"></span>
                            </a>
                            @include('layouts.partials.popover')
                        </li>
                        --}}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {!! Auth::user()->profile->ImgAvatar(30,30) !!}
                                {{ Auth::user()->nickname }} <span class="caret"></span>
                            </a>
                            @include('layouts.partials.dropdown')
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    @include('layouts.partials.modal')

    @yield('content')

    <nav class="col-md-12 navbar navbar-default"></nav>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    @yield('scripts')

    <script>
        /*$(document).ready(function () {
            $(function () {
                $('#user-panel').popover({
                    html: true,
                    content: function() {
                        return $('#user-account').html();
                    },
                    container: 'body',
                    placement: 'auto',
                    trigger: 'focus',
                });
            });
        });*/
    </script>

</body>
</html>
