<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    {!! Html::style('thirdparty/fonts/Lato/latofonts.css') !!}
    {!! Html::style('thirdparty/fonts/Lato/latostyle.css') !!}
    {!! Html::style('thirdparty/font-awesome/4.6.1/css/font-awesome.css') !!}
    {!! Html::style('thirdparty/bootstrap/3.3.6/css/bootstrap.css') !!}

    <style>
        body {
            font-family: 'LatoWeb';
            padding-top: 70px;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield ('styles')
    
    {!! Html::script('thirdparty/js/jquery-1.12.3.js') !!}
    {!! Html::script('thirdparty/bootstrap/3.3.6/js/bootstrap.js') !!}
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ root_url('/') }}">
                            app.dev
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ root_url('/login') }}">Login</a></li>
                        <li><a href="{{ root_url('/register') }}">Register</a></li>
                    @else
                        <?php
                            if (
                                Gate::check('manage-users')
                                || Gate::check('manage-roles')
                                || Gate::check('manage-permissions')
                            ) :
                        ?>
                            <li>
                                <a href="{{ root_url('/dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                        <?php
                            endif;
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ root_url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</body>
</html>
