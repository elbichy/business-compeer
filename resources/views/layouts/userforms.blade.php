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
        <div class="leftPane col s12 l6 z-depth-1">
            <div class="leftContainer">
                <div class="logoArea">
                    <img src="{{asset('storage/compeer-LOGO-with-text.png')}}" alt="LOGO">
                </div>
                {{-- <div class="businessName center">
                    <h3>Compeer</h3>
                </div> --}}
                <div class="MainsubTitle center">
                    <h6>Business Inventory & Analytics platform</h6>
                </div>
            </div>
        </div>
        <div class="rightPane col s12 l6">
            <div class="formBox card">
                @yield('content')
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
