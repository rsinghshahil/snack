<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ url('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/select.dataTables.min.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ url('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css"> --}}

    <!-- Styles -->
    <style>
        #aside>ul li{
            margin-bottom:14px;
            list-style: none;
            text-align: center;
            size: 13ox;
            font-size: 20px;
            border: 1px solid #d8dbdea6;
            border-radius: 8px

        }
        #aside>ul li a {
            /* color:rgb(163, 81, 175) */
            color: #38c172
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="row">
                    <div class="col-md-2" id="aside">
                        <ul>
                            <li class="mb-3">
                                <router-link to="/snack/dashboard" style="color: #0c08087a;font-weight: bold;">DASHBOARD</router-link>
                            </li>
                            <li>
                                <router-link to="/daily-meal"><span class="fa fa-plus"></span> Daily Menu</router-link>
                            </li>
                            <li>
                                <router-link to="/register-user"><span class="fa fa-plus"></span> Customer Register</router-link>
                            </li>
                            <li>
                                <router-link to="/manage-meal-order"><span class="fa fa-plus"></span> Orders</router-link>
                            </li>
                            <li>
                                <router-link to="/meal-links"><span class="fa fa-plus"></span> Generated Links</router-link>
                            </li>
                            <li>
                                <router-link to="/menu"><span class="fa fa-plus"></span> Menu</router-link>
                            </li>
                            {{-- <li>
                                <router-link to="/dashboard1"><span class="fa fa-plus"></span> Settings</router-link>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="col-md-10">
                        {{-- <div class="col-md-8 col-md-offset-2"> --}}
                            <router-view></router-view>
                        {{-- </div> --}}
                    </div>
            </div>
            {{-- @yield('content') --}}
        </main>
    </div>
</body>
<script src="{{ url('assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
<script src="{{ url('js/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ url('js/jquery.dataTables.responsive.min.js') }}"defer></script>
<script src="{{ url('js/dataTables.select.min.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}"></script>
</html>

