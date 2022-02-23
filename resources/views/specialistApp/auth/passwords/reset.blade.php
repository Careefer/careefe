@extends('layouts.web.app')
@section('title','Specialist Forgot Password')
@section('content')
<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/specialist/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
    <div class="banner signin-banner">
        Banner image
    </div>
    <div class="signin-wrapper sign-in">
        <h1>Reset Password</h1>
        <p>
            This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
        </p>
        <div class="tabs-wrapper">
            <ul class="signin-tabs clearfix tabs">
                <li class="tab-link" data-tab="candidate-tab" onclick="redirect_url($(this),'{{ route('candidate.login') }}');">
                    Candidate/Referee
                </li>

                <li class="tab-link current" data-tab="employer-tab">
                    Specialist
                </li>

                <li class="tab-link" data-tab="employer-tab" onclick="redirect_url($(this),'{{ route('employer.login') }}');">
                    Employer
                </li>
            </ul>
            <div id="candidate-tab" class="tab-content current">
                
                <form id="candidate_pass_rest_frm" class="signin-form form" role="form" method="POST" action="{{ url('/specialist/password/reset') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-wrapper input-img">
                        <img src="{{asset('assets/web/images/email.svg')}}" alt="email">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus placeholder="Email">
                        @if($errors->has('email'))
                            <span class="err_msg">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="password input-wrapper input-img">
                        <img src="{{asset('assets/web/images/password.svg')}}" alt="password">
                        <input id="password" type="password" name="password" placeholder="Password" class="pass1" value="{{old('password')}}">
                        @if($errors->has('password'))
                            <span class="err_msg">{{ $errors->first('password') }}</span>
                        @endif
                        <div class="pass-visible">
                            <div class="eye eye-icon eye1">
                                eye
                            </div>
                        </div>
                    </div>

                    <div class="password input-wrapper input-img">
                        <img src="{{asset('assets/web/images/password.svg')}}" alt="password">

                        <input id="password-confirm" type="password" class="pass2" name="password_confirmation" placeholder="Confirm Password">

                        @if($errors->has('password_confirmation'))
                            <span class="err_msg">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                        <div class="pass-visible">
                            <div class="eye eye-icon eye2">
                                eye
                            </div>
                        </div>
                    </div>

                    <button type="button" class="login-btn button" onclick="submit_form($(this),$('#candidate_pass_rest_frm'))">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="bottom-image">
        Image
    </div>
@endsection
