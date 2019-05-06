@extends('layouts.userforms')

@section('content')
<div class="registerBackNav">
    <a class="Back black-text" href="/login">
        <i class="material-icons prefix">arrow_back</i>
    </a>
</div>
<h4 class="center">{{ __('Sign Up') }}</h4>
<form class="col s12 regForm" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">person</i>
            <input id="firstname" name="firstname"  type="text" class="validate {{ $errors->has('firstname') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('firstname'))
                    <span class="helper-text red-text">
                        <strong>{{ $errors->first('firstname') }}</strong>
                    </span>
                @endif
            <label for="firstname">{{ __('Firstname') }}</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">person</i>
            <input id="lastname" name="lastname"  type="text" class="validate {{ $errors->has('lastname') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('lastname'))
                    <span class="helper-text red-text">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                @endif
            <label for="lastname">{{ __('Lastname') }}</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">email</i>
            <input id="email" name="email"  type="email" class="validate {{ $errors->has('email') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('email'))
                    <span class="helper-text red-text">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            <label for="email">{{ __('E-Mail Address') }}</label>
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" name="password" type="password" class="validate {{ $errors->has('password') ? ' is-invalid' : '' }}" required>
            <label for="password">{{ __('Password') }}</label>
        </div>
        <input type="hidden" name="role" value="1">
        <div class="input-field col s12">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            @if ($errors->has('password'))
                <span class="helper-text red-text">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
        </div>
        <div class="input-field btnWrap col s12 center" style="display:flex; justify-content:center;">
            <button id="registerBtn" class="btn waves-effect waves-light" type="submit" name="action">{{ __('Register') }}
                <i class="material-icons right">send</i>
            </button>
            {{-- SPINNER --}}
            @include('components.submitPreloader')
        </div>
    </div>
</form>
@endsection
