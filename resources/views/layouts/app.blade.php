<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bits Infotech Solutions') }}</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('materialize-css/css/materialize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/wnoty.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('materialize-css/js/materialize.min.js')}}"></script>
    <script src="{{asset('js/pace.min.js')}}"></script>
    <script src="{{asset('js/wnoty.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
</head>
<body>
    <div class="app" id="app">
        {{-- Navbar goes here --}}
        <div id="space-for-sidenave" class="navbar-fixed">
            <nav>
                <div class="nav-wrapper">
                    {{-- BREADCRUMB --}}
                    <div class="left breadcrumbWrap hide-on-small-only">
                        <a href="/dashboard" class="breadcrumb">Dashboard</a>
                        <a href="/Dashboard/{{request()->segment(2)}}" class="breadcrumb">{{(request()->segment(2) == '') ? 'Home' : ucfirst(request()->segment(2))}}</a>
                    </div>

                    @if(count($data['branchDetails']) > 0 && auth()->user()->role == 1 || auth()->user()->role == 2)
                        <form action="{{ url('switchBranch') }}" method="post" name="switchBranch" class="switchBranch brand-logo center">
                            @csrf
                            <div class="input-field col s12"  style="text-align:center;">
                                <select name="selectedBranch" id="selectedBranch" style="text-align:center;">
                                    <option value="" disabled  {{ auth()->user()->branch_id !== 0 ? 'selected' : ''}} class="white-text">Select a Branch</option>
                                    @foreach ($data['branchDetails'] as $branch)
                                        <option  style="text-align:center;" value="{{ucfirst($branch->id)}}" {{ $branch->id == auth()->user()->branch_id ? 'selected' : ''}}>{{ucfirst($branch->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    @endif

                    {{-- OTHER MENU RIGHT --}}
                    <a href="#" data-target="slide-out" class="sidenav-trigger hide-on-med-and-up right"><i class="material-icons">menu</i></a>
                    
                    <ul class="right hide-on-med-and-down">
                        <li class="logOutBtn">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="material-icons right">power_settings_new</i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    <ul class="right hide-on-small-only">
                        <a href="{{route('myProfile')}}">{{auth()->user()->firstname.' '.auth()->user()->lastname}}</a>
                    </ul>
                    @can('isOwner')
                    <ul>
                        <a  href="{{route('manageTransfers')}}" style="margin-right: 14px;" class="right hide-on-small-only">
                            <i style="margin-right: 0px;" class="material-icons left">notifications</i>
                            {!! $notification > 0 ? '<sup class="red notificationCount">'.$notification.'</sup>' : NULL !!}
                        </a>
                    </ul>
                    <ul>
                        <a  href="{{route('manageTransfers')}}" style="margin-left: 14px;" class="left hide-on-med-and-up">
                            <i style="margin-right: 0px;" class="material-icons left">notifications</i>
                            {!! $notification > 0 ? '<sup class="red notificationCount">'.$notification.'</sup>' : NULL !!}
                        </a>
                    </ul>  
                    @endcan 
                </div>
            </nav>
        </div>

        {{-- SIDE NAV --}}
        <ul id="slide-out" class="sidenav sidenav-fixed" style="min-height: 100%; display: flex; flex-direction: column;">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="{{asset('storage/office.jpg')}}">
                    </div>

                    {{-- BUSINESS LOGO --}}
                    @if (count($data['businessDetails']) == 1 && $data['businessDetails'][0]->logo != NULL)
                        @foreach ($data['businessDetails'] as $business)
                            <a href="#user"><img class="circle" src="{{asset('storage').'/site/'.$business->name.'/'.$business->logo}}"></a>
                        @endforeach    
                    @else
                        <a href="#user"><img class="circle" src="{{asset('storage/compeer-LOGO.png')}}"></a>
                    @endif
                    

                    {{-- BUSINESS NAME --}}
                    <a href="#name"><span class="white-text name">
                        @if (count($data['businessDetails']) == 1)
                            @foreach ($data['businessDetails'] as $business)
                                {{$business->name}}
                            @endforeach    
                        @else
                            Business Name here
                        @endif
                    </span></a>

                    {{-- BUSINESS BRANCH AND ADDRESS --}}
                    @if (count($data['branchDetails']) > 0)
                            <a href="#email"><span class="white-text email">
                                @foreach ($data['branchDetails'] as $branch)
                                    @if(auth()->user()->branch_id == $branch->id)
                                        {{ucfirst($branch->name)}} - {{$branch->address}}
                                    @endif
                                @endforeach 
                            </span></a>
                    @else
                        <a href="#email"><span class="white-text email">Branch Name - Address</span></a>
                    @endif

                </div>
            </li>
            <li class="{{(request()->segment(1) == 'dashboard') ? 'active' : ''}}"><a href="/dashboard"><i class="material-icons">dashboard</i>DASHBOARD</a></li>

            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="{{(request()->segment(2) == 'Transactions') ? 'activeCollape' : ''}}">
                        <a style="padding:0 32px;" class="collapsible-header"><i class="material-icons">attach_money</i>TRANSACTION<i class="material-icons right">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li class="{{(request()->segment(2) == 'sales') ? 'active' : ''}}"><a href="/Dashboard/sales">Sales</a></li>
                                <li class="{{(request()->segment(2) == 'expenses') ? 'active' : ''}}"><a href="/Dashboard/expenses">Expenses</a></li>
                                <li class="{{(request()->segment(2) == 'transfers') ? 'active' : ''}}"><a href="/Dashboard/transfers">Transfers</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            
            <li class="{{(request()->segment(2) == 'stock') ? 'active' : ''}}"><a href="/Dashboard/stock"><i class="material-icons">shopping_cart</i>STOCK</a></li>
            <li class="{{(request()->segment(2) == 'statistics') ? 'active' : ''}}"><a href="/Dashboard/statistics"><i class="material-icons">show_chart</i>STATISTICS</a></li>
            <li class="{{(request()->segment(2) == 'customers') ? 'active' : ''}}"><a href="/Dashboard/customers"><i class="material-icons">group</i>CUSTOMERS</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                <li class="{{(request()->segment(2) == 'Settings') ? 'activeCollape' : ''}}">
                    <a style="padding:0 32px;" class="collapsible-header"><i class="material-icons">settings</i>SETTINGS<i class="material-icons right">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                    <ul>
                        <li class="{{(request()->segment(2) == 'businessSettings') ? 'active' : ''}}"><a href="/Dashboard/businessSettings">Business settings</a></li>
                        <li class="{{(request()->segment(2) == 'branchSettings') ? 'active' : ''}}"><a href="/Dashboard/branchSettings">Branch settings</a></li>
                        <li class="{{(request()->segment(2) == 'staffSettings') ? 'active' : ''}}"><a href="/Dashboard/staffSettings">Staff settings</a></li>
                    </ul>
                    </div>
                </li>
                </ul>
            </li>
            
            {{-- OTHER MENU RIGHT FOR MOBILE DEVICES --}}
            <li class="hide-on-med-and-up col s12" style="border-top:2px solid darkgreen; justify-self: flex-end; margin-top: auto;">
                <ul class="right col s8" style="display:flex; justify-content:center; align-items:center; width:20%;">
                    <li class="logOutBtn">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i style="margin:0;" class="material-icons left">power_settings_new</i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                <ul class="col s4 right white-text" style="display:flex; justify-content:center; align-items:center; width:80%;">
                    @if(auth()->check())
                        <a class="white-text" href="{{route('myProfile')}}">{{auth()->user()->firstname.' '.auth()->user()->lastname}}</a>
                    @endif
                </ul>
            </li>
        </ul>

        {{-- CONTENT AREA    --}}
            @if (session()->has('accessError'))
                <script>
                $(document).ready(function () {
                        $.wnoty({
                        type: 'error',
                        message: '{{session('accessError')}}',
                        autohideDelay: 5000
                        });
                    });
                </script>
            @endif
            @if (session()->has('noBusinessRecord'))
                <script>
                $(document).ready(function () {
                        $.wnoty({
                        type: 'info',
                        message: '{{session('noBusinessRecord')}}',
                        autohideDelay: 5000
                        });
                    });
                </script>
            @endif
            @if (session()->has('status'))
                <script>
                $(document).ready(function () {
                        $.wnoty({
                        type: 'success',
                        message: '{{session('status')}}',
                        autohideDelay: 5000
                        });
                    });
                </script>
            @endif
        @yield('content')

    </div>
</body>
</html>
