<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Bits Infotech Solutions') }}</title>
    <link rel="stylesheet" href="{{asset('materialize-css/css/materialize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="wrapper row">
        <div class="contentWrap col s12">
            <div class="contentContainer">
                {{-- NAV BAR GOES HERE --}}
                <header style="width:100%;">
                    <nav class="homeNav">
                        <div class="nav-wrapper">
                        <a href="#" data-target="mobile-demo" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a href="{{route('register').'#rightPane'}}" class="waves-effect waves-light transparent btn">
                                    SIGNUP<i class="material-icons left">person_add</i>
                                </a>
                            </li>
                            <li>
                            <a href="{{route('login').'#rightPane'}}" class="waves-effect waves-light transparent btn">
                                    <i class="material-icons right">lock_open</i>LOGIN
                                </a>
                            </li>
                        </ul>
                        </div>
                    </nav>

                    <ul class="sidenav" id="mobile-demo">
                        <li><a href="{{route('login').'#rightPane'}}">LOGIN</a></li>
                        <li><a href="{{route('register').'#rightPane'}}">REGISTER</a></li>
                    </ul>
                </header>

                {{-- CONTENT START HERE --}}
                <div class="logoArea">
                    <img src="{{asset('storage/compeer-LOGO-with-text.png')}}" alt="LOGO">
                </div>
                {{-- <div class="businessName center">
                    <h3>Bichy's Infotech Solutions</h3>
                </div> --}}
                <div class="MainsubTitle center white-text">
                    <h6>Business Inventory & Analytics platform</h6>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('materialize-css/js/materialize.min.js')}}"></script>
    <script src="{{asset('js/pace.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
</body>
</html>
