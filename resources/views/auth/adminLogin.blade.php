@extends('layouts.userforms')

@section('content')
<h4 class="center">{{ __('Sign In') }}</h4>
<form class="col s12 loginForm" method="POST" action="{{ route('admin.login.submit') }}">
    @csrf
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">person</i>
            <input id="email" name="email" type="email" class="validate {{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus>
            @if ($errors->has('email'))
                <span class="helper-text red-text">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <label for="email">{{ __('E-Mail Address') }}</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" name="password"  type="password" class="validate {{ $errors->has('password') ? ' is-invalid' : '' }}">
            @if ($errors->has('password'))
                <span class="helper-text red-text">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <label for="password">{{ __('Password') }}</label>
        </div>
        <div class="input-field btnWrap col s12 center" style="display:flex; justify-content:center;">
            <button id="loginBtn" class="btn waves-effect waves-light loginButton" type="submit" name="loginButton">LOGIN
                <i class="material-icons right">send</i>
            </button>

            {{-- SPINNER --}}
            @include('components.submitPreloader')
        </div>
        <div class="input-field col s12" style="display: flex; justify-content: center;">
            <a class="RegisterBtn" href="/register">
                <i class="material-icons removePrefix prefix">person_add</i>
            </a>
        </div>

    </div>
</form>
@endsection
