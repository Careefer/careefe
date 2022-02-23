@extends('layouts.web.app')
@section('title','Candidate Register')
@section('content')
@section('page-class','candidate-signup')


<div class="banner candidate-banner">
  Banner image
</div>
<div class="signin-wrapper signup">
  <h1>Welcome to careefer</h1>
  <div class="signup-tabs-wrapper">
    <ul class="signup-tabs clearfix tabs">
      <li class="signup-tab-link">
        <a href="{{route('specialist.register')}}">Sign Up as Specialist</a>
      </li>
      <li class="signup-tab-link">
        <a href="{{route('employer.register')}}">Sign Up as Employer</a>
      </li>
    </ul>
    <div class="candidate-wrapper">
        <form class="signup-form form" id="candidate_signup_frm" role="form" method="POST" action="{{ url('/candidate/register') }}">
        {{ csrf_field() }}
        <h3>Candidate/Referee</h3>

        <div class="name-wrapper cmn-space clearfix">
            
            <div class="first-name input-wrapper input-img"><img src="{{asset('assets/web/images/account.svg')}}" alt="first-name">
                <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" maxlength="100">
                @if($errors->has('first_name'))
                    <span class="err_msg">{{ $errors->first('first_name') }}</span>
                @endif
            </div>

            <div class="last-name input-wrapper input-img"><img src="{{asset('assets/web/images/account.svg')}}" alt="last-name">
                <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" maxlength="100">
                @if($errors->has('last_name'))
                    <span class="err_msg">{{ $errors->first('last_name') }}</span>
                @endif
            </div>
        </div>

        <div class="input-wrapper cmn-space input-img"><img src="{{asset('assets/web/images/email.svg')}}" alt="email">
            <input id="email" type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}">
            @if($errors->has('email'))
                <span class="err_msg">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="password input-wrapper cmn-space input-img"><img src="{{asset('assets/web/images/lock.svg')}}" alt="password">
          <input id="password" type="password" class="pass4" name="password" placeholder="Password" value="{{old('password')}}">
            @if($errors->has('password'))
                <span class="err_msg">{{ $errors->first('password') }}</span>
            @endif
          <div class="pass-visible">
            <div class="eye eye-icon eye4">
              eye
            </div>
          </div>
        </div>
        <div class="input-wrapper phone cmn-space input-img"><img src="{{asset('assets/web/images/phone.png')}}" alt="phone" width="18" height="18">
            <input type="tel" name="phone" placeholder="Phone with country/region code" max="15" value="{{old('phone')}}">
            @if($errors->has('phone'))
                <span class="err_msg">{{ $errors->first('phone') }}</span>
            @endif
        </div>

        <div class="checkbox-wrapper">
            <div class="terms-checkbox">
                <label class="checkbox-container">
                I agree to
                @php $pages = cmsPages(); @endphp
                @foreach($pages as $value) 
                    <a href="{{url($value->slug)}}">{{$value->title}}</a>
                @endforeach
                <input {{(old('term_and_condition')) ? 'checked': ''}} type="checkbox" name="term_and_condition" value="yes">
                @if($errors->has('term_and_condition'))
                    <span class="err_msg">
                        {{ $errors->first('term_and_condition') }}
                    </span>
                @endif
                <span class="checkmark"></span></label>
            </div>
        </div>

        <button class="login-btn button" type="button" onclick="submit_form($(this),$('#candidate_signup_frm'))">
          Sign Up
        </button>

      </form>

      <div class="line">
        <span>or</span>
      </div>
      <ul class="social-icons">
        <li>
          <a href="{{ url('candidate/login/facebook') }}"><img src="{{asset('assets/web/images/fb.png')}}" alt="facebook"></a>
        </li>
        <li>
          <a href="#"><img src="{{asset('assets/web/images/twitter.png')}}" alt="twitter"></a>
        </li>
        <li>
          <a href="{{ url('candidate/login/linkedin') }}"><img src="{{asset('assets/web/images/linkedin.png')}}" alt="linkedin"></a>
        </li>
      </ul>
      <span class="no-account">Already have an account? <a href="{{route('candidate.login')}}" class="register-link">Sign In</a></span>
    </div>
  </div>
</div>
<div class="bottom-image">
  Image
</div>

@endsection
