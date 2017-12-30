<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title')
        - Laravel Forums
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
            <a class="navbar-brand" href="{{ url('admin/index') }}">Admin</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('admin/index') }}">Principal</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav nav-pills navbar-right" role="tablist">
                <li><a href="{{ url('/') }}">Retornar</a></li>
                <li>
                    <a href="{{ url('/logout') }}">
                        {!! Auth::user()->profile->ImgAvatar(30,30) !!}
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="row" style="margin:5px;">
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul style="list-style-type: none;">
                    <li>
                        <a href="{{ route('admin.users.index') }}">Administrar Usuarios</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.boards.index') }}">Administrar Boards</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.galleries.index') }}">Administrar Galerías</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        @yield('content')
    </div>
</div>

<nav class="col-md-12 navbar navbar-default"></nav>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

@yield('scripts')

</body>
</html>
