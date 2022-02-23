@extends('layouts.web.app')
@section('title','Employer Login')
@section('content')

    <div class="banner signin-banner">
        Banner image
    </div>
    <div class="signin-wrapper sign-in">
        <h1>Welcome to careefer</h1>
        <div class="tabs-wrapper">
            <ul class="signin-tabs clearfix tabs">
                <li class="tab-link" data-tab="user-login-tab" onclick="redirect_url($(this),'{{ route('candidate.login') }}');">
                    Candidate/Referee
                </li>

                <li class="tab-link" data-tab="user-login-tab" onclick="redirect_url($(this),'{{ route('specialist.login') }}');">
                    Specialist
                </li>

                <li class="tab-link current" data-tab="user-login-tab">
                    Employer
                </li>
            </ul>
            <div id="user-login-tab" class="tab-content current">
                
                <form class="signin-form form" id="employer_login_form" role="form" method="POST" action="{{ url('/employer/login') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="input-wrapper input-img">
                        <img src="{{asset('assets/web/images/email.svg')}}" alt="email">
                        <input id="email" type="email" name="email" value="{{ old('email','') }}" autofocus placeholder="Email">
                        @if($errors->has('email'))
                            <span class="err_msg">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="password input-wrapper input-img">
                        <img src="{{asset('assets/web/images/password.svg')}}" alt="password">
                        <input id="password" type="password" name="password" placeholder="Password" class="pass1" value="">
                        @if($errors->has('password'))
                            <span class="err_msg">{{ $errors->first('password') }}</span>
                        @endif
                        <div class="pass-visible">
                            <div class="eye eye-icon eye1">
                                eye
                            </div>
                        </div>
                    </div>
                    <div class="checkbox-wrapper clearfix">
                        <div class="remember-box">
                            <label class="checkbox-container">Remember me
                                <input type="checkbox" name="remember">
                                <span class="checkmark"> </span>
                            </label>
                        </div>
                        <a href="{{ url('/employer/password/reset') }}" class="forgot-pass">Forgot Password?</a>
                    </div>
                    <button type="button" class="login-btn button" onclick="submit_form($(this),$('#employer_login_form'))">
                        Sign In
                    </button>
                </form>
                
                <span class="no-account">Don’t have an account? <a href="{{route('employer.register')}}" class="register-link">Sign Up</a></span>
                <p>By signing up with careefer, you agree to careefer's Terms & Conditions and consent to our Cookie Policy and Privacy Policy. You consent to receive notifications and communications related to marketing or general information. You can opt out by changing settings in your account.</p>
            </div>
        </div>
    </div>
    <div class="bottom-image">
        Image
    </div>
@endsection
