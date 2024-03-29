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
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/moment-timezone-with-data-1970-2030.js')}}"></script>
    <script src="{{asset('js/livestamp.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
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
            --button-secondary: #D32F2F;
        }
    </style>
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
                        <a href="/dashboard/{{request()->segment(2)}}" class="breadcrumb">{{(request()->segment(2) == '') ? 'Home' : ucfirst(request()->segment(2))}}</a>
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

                    {{-- OWNER NOTIFICATION BLOCK --}}
                    @can('isOwner')
                    <ul>
                        <a href="#" style="margin-right: 14px;" data-target='notifications'  class="dropdown-trigger right hide-on-small-only">
                            <i style="margin-right: 0px;" class="material-icons left">notifications</i>
                            {!! auth()->user()->unreadNotifications->count() > 0 ? '<sup class="red notificationCount">'.auth()->user()->unreadNotifications->count().'</sup>' : '<sup class="red green notificationCount">0</sup>' !!}
                        </a>
                        <!-- Dropdown Structure -->
                        <ul id='notifications' class='dropdown-content'>
                            @foreach($notification->unreadNotifications as $notificationCollection)
                                @foreach($notificationCollection->data as $notificationItem)
                                <li>
                                    <a href="{{url($notificationItem['url'])}}">
                                        <i class="material-icons">monetization_on</i>
                                        <div class='notMsg'>
                                            <p>{{$notificationItem['msg']}}</p>
                                            <sub>{{Carbon\Carbon::parse($notificationCollection->created_at)->diffForHumans()}}</sub>
                                        </div>
                                        
                                    </a>
                                </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </ul>
                    <ul> {{-- FOR MOBILE --}}
                        <a  href="#" style="margin-left: 14px;" data-target='notifications'  class="dropdown-trigger left hide-on-med-and-up">
                            <i style="margin-right: 0px;" class="material-icons left">notifications</i>
                            {!! auth()->user()->unreadNotifications->count() > 0 ? '<sup class="red notificationCount">'.auth()->user()->unreadNotifications->count().'</sup>' : '<sup class="red green notificationCount">0</sup>' !!}
                        </a>
                    </ul>  
                    @endcan 

                    {{-- OTHERS NOTIFICATION BLOCK --}}
                    @cannot('isOwner')
                    <ul>
                        <a href="#" style="margin-right: 14px;" data-target='notifications'  class="dropdown-trigger right hide-on-small-only">
                            <i style="margin-right: 0px;" class="material-icons left">notifications</i>
                            {!! auth()->user()->unreadNotifications->count() > 0 ? '<sup class="red notificationCount">'.auth()->user()->unreadNotifications->count().'</sup>' : '<sup class="red green notificationCount">0</sup>' !!}
                        </a>
                        <!-- Dropdown Structure -->
                        <ul id='notifications' class='dropdown-content'>
                            @foreach($notification->unreadNotifications as $notificationCollection)
                                @foreach($notificationCollection->data as $notificationItem)
                                <li>
                                    <a href="{{ $notificationItem['type'] == 'transfer' ? route('transfers') : route('utility') }}">
                                        <i class="material-icons">monetization_on</i>
                                        <div class='notMsg'>
                                            <p>{{$notificationItem['msg']}}</p>
                                            <sub>{{Carbon\Carbon::parse($notificationCollection->created_at)->diffForHumans()}}</sub>
                                        </div>
                                        
                                    </a>
                                </li>
                                <li class="divider" tabindex="-1"></li>
                                @endforeach
                            @endforeach
                            @if($notification->unreadNotifications->count() > 0)
                                <li>
                                    <a href="{{ route('clearNotifications') }}">
                                        <i class="material-icons">clear_all</i>
                                        <div class='notMsg'>
                                            <p>Clear notifications</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </ul>
                    <ul> {{-- FOR MOBILE --}}
                        <a  href="#" style="margin-left: 14px;" data-target='notifications'  class="dropdown-trigger left hide-on-med-and-up">
                            <i style="margin-right: 0px;" class="material-icons left">notifications</i>
                            {!! auth()->user()->unreadNotifications->count() > 0 ? '<sup class="red notificationCount">'.auth()->user()->unreadNotifications->count().'</sup>' : '<sup class="red green notificationCount">0</sup>' !!}
                        </a>
                    </ul>  
                    @endcannot
                </div>
            </nav>
        </div>

        {{-- SIDE NAV --}}
        <ul id="slide-out" class="sidenav sidenav-fixed" style="min-height: 100%; display: flex; flex-direction: column;">
            <div class="sideNavContainer">
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
                <li class="{{(request()->segment(1) == 'dashboard' && request()->segment(2) == NULL) ? 'active' : ''}}"><a href="/dashboard"><i class="material-icons">dashboard</i>DASHBOARD</a></li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li class="{{(request()->segment(2) == 'Transactions') ? 'activeCollape' : ''}}">
                            <a style="padding:0 32px;" class="collapsible-header"><i class="material-icons">attach_money</i>TRANSACTION<i class="material-icons right">arrow_drop_down</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li class="{{(request()->segment(2) == 'sales') ? 'active' : ''}}"><a href="/dashboard/sales">Sales</a></li>
                                    <li class="{{(request()->segment(2) == 'expenses') ? 'active' : ''}}"><a href="/dashboard/expenses">Expenses</a></li>
                                    <li class="{{(request()->segment(2) == 'transfers') ? 'active' : ''}}"><a href="/dashboard/transfers">Transfer money</a></li>
                                    <li class="{{(request()->segment(2) == 'utility-bill-payment') ? 'active' : ''}}"><a href="/dashboard/utility-bill-payment">Utility bill payment</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                
                <li class="{{(request()->segment(2) == 'stock') ? 'active' : ''}}"><a href="/dashboard/stock"><i class="material-icons">shopping_cart</i>STOCK</a></li>
                <li class="{{(request()->segment(2) == 'statistics') ? 'active' : ''}}"><a href="/dashboard/statistics"><i class="material-icons">show_chart</i>STATISTICS</a></li>
                <li class="{{(request()->segment(2) == 'customers') ? 'active' : ''}}"><a href="/dashboard/customers"><i class="material-icons">group</i>CUSTOMERS</a></li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                    <li class="{{(request()->segment(2) == 'Settings') ? 'activeCollape' : ''}}">
                        <a style="padding:0 32px;" class="collapsible-header"><i class="material-icons">settings</i>SETTINGS<i class="material-icons right">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                        <ul>
                            <li class="{{(request()->segment(2) == 'business-settings') ? 'active' : ''}}"><a href="/dashboard/business-settings">Business settings</a></li>
                            <li class="{{(request()->segment(2) == 'branch-settings') ? 'active' : ''}}"><a href="/dashboard/branch-settings">Branch settings</a></li>
                            <li class="{{(request()->segment(2) == 'staff-settings') ? 'active' : ''}}"><a href="/dashboard/staff-settings">Staff settings</a></li>
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
            </div>
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
        
    <script src="{{asset('js/lately.js')}}"></script>
    <script src="{{asset('materialize-css/js/materialize.min.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/pace.min.js')}}"></script>
    <script src="{{asset('js/ion.sound.min.js')}}"></script>
    <script src="{{asset('js/wnoty.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>

    {{-- @can('isOwner') --}}
        <script>
            // CHECK FOR NEW NOTIFICATION EVERY SECOND
            window.setInterval(function(){
                loadNotification('{{asset('storage')}}');
            }, 2000);   
        </script>
    {{-- @endcan --}}
</body>
</html>
