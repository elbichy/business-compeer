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
    <style>
        :root {
            --primary-bg-dark: #086b23; 
            --primary-bg-light: #0fb13b; 
            
            --primary-trans-bg-dark: rgb(8, 107, 35, 0.9); 
            --primary-trans-bg-light: rgb(15, 177, 59, 0.9);
            
            --secondary-bg-dark: #C03B2B; 
            --secondary-bg-light: #E64C3C; 
            
            --switch-dark: #098f45; 
            --switch-light: #22da75; 

            --button-dark: #098f45; 
            --button-light: #37ad68; 
        }
    </style>
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
        <div id="rightPane" class="rightPane col s12 l6">
            <div id="formBox" class="formBox card">
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
