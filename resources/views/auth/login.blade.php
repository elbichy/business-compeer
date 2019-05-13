@extends('layouts.userforms')

@section('content')
<h4 class="center">{{ __('Sign In') }}</h4>
<form class="col s12 loginForm" method="POST" action="{{ route('login') }}">
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
        <div class="input-field btnWrap col s12 m7 l7 center">
            <p style="margin:0;">
                <label>
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                    <span>Remember Me</span>
                </label>
            </p>
        </div>
        <div class="input-field btnWrap col s12 m5 l5 center" style="display:flex; justify-content:center;">
            <button id="loginBtn" class="btn waves-effect waves-light loginButton" type="submit" name="loginButton">LOGIN
                <i class="material-icons right">send</i>
            </button>

            {{-- SPINNER --}}
            @include('components.submitPreloader')
        </div>
        <div class="input-field col s12" style="display: flex; justify-content: center;">
            <span>Don't have an account yet? <a class="RegisterBtn" href="/register">Sign Up!</a></span>
        </div>

    </div>
</form>
@endsection
