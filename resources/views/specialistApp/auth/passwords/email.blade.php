@extends('layouts.web.app')
@section('title','Specialist Password Reset Link')
<!-- Main Content -->
@section('content')
<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/specialist/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
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
        <h1>Forgot Password</h1>
        <p>
            This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
        </p>

        @if (session('status'))
            <p class="success_msg">
                {{ session('status') }}
            </p>
        @endif

        <div class="tabs-wrapper">
            <ul class="signin-tabs clearfix tabs">
                <li class="tab-link" data-tab="candidate-tab" onclick="redirect_url($(this),'{{ route('candidate.login') }}');">
                    Candidate/Referee
                </li>

                <li class="tab-link current" data-tab="specialist-tab">
                    Specialist
                </li>

                <li class="tab-link" data-tab="employer-tab" onclick="redirect_url($(this),'{{ route('employer.login') }}');">
                    Employer
                </li>
            </ul>
            <div id="specialist-tab" class="tab-content current">
                <form id="candidate_pass_resetlink_frm" class="signin-form form" role="form" method="POST" action="{{ url('/specialist/password/email') }}" autocomplete="off">
                        {{ csrf_field() }}
                    <div class="input-wrapper input-img">
                        <img src="{{asset('assets/web/images/email.svg')}}" alt="email">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus placeholder="Email">
                        @if($errors->has('email'))
                            <span class="err_msg">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <button type="button" class="login-btn button" onclick="submit_form($(this),$('#candidate_pass_resetlink_frm'))">
                        Send Reset Link
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="bottom-image">
        Image
    </div>
@endsection
