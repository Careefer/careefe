@extends('layouts.web.app')
@section('title','Specialist Register')
@section('content')

<div class="banner specialist-banner">
    Banner image
</div>
<div class="signin-wrapper specialist-signup">
    <h1>Welcome to careefer</h1>
    <div class="signup-tabs-wrapper">
        <ul class="signup-tabs clearfix tabs">
            <li class="signup-tab-link">
                <a href="{{route('candidate.register')}}">Sign Up as Candidate/Referee </a>
            </li>
            <li class="signup-tab-link">
                <a href="{{route('employer.register')}}">Sign Up as Employer</a>
            </li>
        </ul>
        <div id="specialist" class="tab-signup">
            <form class="signup-form form" id="specialist_signup_frm" role="form" method="POST" action="{{ url('/specialist/register') }}" autocomplete="off" enctype='multipart/form-data'>
                {{ csrf_field() }}

                <h3>Sign Up as Specialist</h3>
                
                <div class="name-wrapper cmn-space clearfix">
                    <div class="first-name input-wrapper input-img"><img src="{{asset('assets/web/images/account.svg')}}" alt="first-name">
                        <input type="text" name="first_name" placeholder="First Name" maxlength="191" value="{{old('first_name')}}">
                        @if($errors->has('first_name'))
                            <span class="err_msg">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                    <div class="last-name  input-wrapper input-img"><img src="{{asset('assets/web/images/account.svg')}}" alt="last-name">
                        <input type="text" name="last_name" placeholder="Last Name" maxlength="191" value="{{old('last_name')}}">
                        @if($errors->has('last_name'))
                            <span class="err_msg">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="email input-wrapper cmn-space input-img"><img src="{{asset('assets/web/images/email.svg')}}" alt="email">
                    <input type="email" name="email" placeholder="Email" maxlength="191" value="{{old('email')}}">
                    @if($errors->has('email'))
                        <span class="err_msg">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="password cmn-space input-wrapper input-img">
                    <img src="{{asset('assets/web/images/password.svg')}}" alt="password">
                    <input type="password" name="password" placeholder="Password" maxlength="20" value="{{old('password')}}">
                    @if($errors->has('password'))
                        <span class="err_msg">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="input-wrapper cmn-space phone input-img"><img src="{{asset('assets/web/images/phone.png')}}" alt="phone">
                    <input type="tel" name="phone" placeholder="Phone with country/region code" maxlength="15" value="{{old('phone')}}">
                    @if($errors->has('phone'))
                        <span class="err_msg">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                
                <div class="cmn-space">
                    <div class="input-wrapper">
                        <span class="input-img"><img src="{{asset('assets/web/images/location.svg')}}" alt="Location"></span>
                         <select name="location" class="loadAjaxSuggestion" data-placeholder="Location">
                         </select>
                        @if($errors->has('location'))
                            <span class="err_msg">{{ $errors->first('location') }}</span>
                        @endif
                    </div>
                </div>
                <div class="func-wrapper cmn-space">
                    <div class="input-wrapper select">
                        <span class="input-img"><img src="{{asset('assets/web/images/innovation.svg')}}" alt="Area"></span>
                        <select  name="functional_area"> 
                            <option value="">Functional Area</option>

                            @forelse($functional_area as $id => $name)
                                @if (old('functional_area') == $id)
                                    <option value="{{ $id }}" selected>{{ $name }}</option>
                                @else
                                    <option value="{{$id}}">{{$name}}</option>
                                @endif
                            @empty
                                <option value="">No data found</option>
                            @endforelse

                            <!-- <option value="">Functional Area</option>
                            <option value="1">Option 2</option>
                            <option value="2">Option 3</option>
                            <option value="3">Option 4</option> -->

                        </select>
                        @if($errors->has('functional_area'))
                            <span class="err_msg">{{ $errors->first('functional_area') }}</span>
                        @endif
                    </div>
                </div>
                <div class="file-wrapper cmn-space cv-up-wrap">
                    <label for="file-upload" class="custom-file-upload">No File</label>
                    <input id="file-upload" name="resume" type="file" style="display:none;">
                    @if($errors->has('resume'))
                        <span class="err_msg">{{ $errors->first('resume') }}</span>
                    @endif
                    <span id="fileInfo" class="alertCls" style="display:none;"></span>
                </div>
                <!-- <div class="checkbox-wrapper">
                    <div class="terms-checkbox">
                        <label class="checkbox-container">I agree to <a href="#">T&amp;C</a> and <a href="#">Policy</a>
                            <input {{(old('term_and_condition')) ? 'checked': ''}} type="checkbox" name="term_and_condition">
                            @if($errors->has('term_and_condition'))
                                <span class="err_msg">
                                    {{ $errors->first('term_and_condition') }}
                                </span>
                            @endif
                            <span class="checkmark"></span></label>
                    </div>
                </div> -->
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
                <button class="login-btn button register-btn" type="button" onclick="submit_form($(this),$('#specialist_signup_frm'))">
                    Sign Up
                </button>
                    <span class="no-account account-nopes">Already have an account? <a href="{{route('specialist.login')}}" class="register-link">Sign In</a></span>

            </form>
        </div>
    </div>
</div>
<div class="bottom-image">
    Image
</div>
@endsection
