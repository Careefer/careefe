@extends('layouts.web.app')
@section('title','Employer Register')
@section('content')
@section('page-class','reg-errormsg')
    <div class="banner employer-banner">
        Banner image
    </div>
    <div class="signin-wrapper employer-signup" id="emp-scroll">
        <div class="emp-inner">
            <h1>Welcome to careefer</h1>
            <div class="signup-tabs-wrapper">
                <ul class="signup-tabs clearfix tabs">
                    <li class="signup-tab-link">
                        <a href="{{route('candidate.register')}}">Sign Up as Candidate/Referee </a>
                    </li>
                    <li class="signup-tab-link">
                        <a href="{{route('specialist.register')}}">Sign Up as Specialist</a>
                    </li>
                </ul>
                <div id="employer" class="tab-signup">

                    <form class="signup-form form" id="employer_signup" role="form" method="POST" action="{{ url('/employer/register') }}">
                        {{ csrf_field() }}
                        <h3>Sign Up as Employer</h3>
                        <div class="form-msg"></div>
                        <div class="func-wrapper">
                            <div class="company-name input-wrapper loc">
                                <span class="input-img"><img src="{{asset('assets/web/images/company.png')}}" alt="name"></span>
                                <input type='text'
                                placeholder='Company Name'
                                class='flexdatalist'           
                                name='company_name' maxlength="191">
                            </div>
                        </div>
                        
                        <!-- bkp class = func-wrapper -->    
                        <div class="">
                            <div class="head-loc input-wrapper loc">
                                <span class="input-img"><img src="{{asset('assets/web/images/head-loc.png')}}" alt="location"></span>

                                <select name="head_office" class="loadAjaxSuggestion" data-placeholder="Head Office Location">
                                </select>

                            </div>
                        </div>
                        <div class="branch-container-wrap">
                            <div class="branch-container">
                                <div class="branch-loc input-wrapper loc">
                                    <span class="input-img">
                                        <img src="{{asset('assets/web/images/head-loc.png')}}" alt="location">
                                    </span>
                                    
                                    <select name="location_id_0" class="loadAjaxSuggestion branch_location_id" data-placeholder="Branch Location">
                                    </select>
                                    <input type="hidden" name="temp[]">
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <button type="button" class="button del branch-del"><img src="{{asset('assets/web/images/delete.png')}}" alt="delete" class="del-img">Delete
                            </button>
                            <button class="add-more add-branch button" type="button">
                                <span class="plus">plus icon</span>Add More
                            </button>
                        </div>
                        <!-- bkp class = func-wrapper -->
                        <div class="" id="industry-select">
                            <div class="input-wrapper industry loc">
                                <span class="input-img"><img src="{{asset('assets/web/images/industry.png')}}" alt="industry"></span>
                                <!-- <input type='text'
                                placeholder='Industry'
                                class='flexdatalist'> -->
                                
                                <select class="careefer-select2" data-search="true" placeholder="Select industry" name="industry_id" data-placeholder="Industry">
                                    @if($industries)
                                        <option value=""></option>
                                          @foreach($industries as $industry_id => $industry_name)
                                            <option value="{{$industry_id}}">{{$industry_name}}</option>
                                          @endforeach
                                        @else
                                        <option value="">No data found</option>
                                   @endif   
                                  </select>
                                <!-- <input type="hidden" name="industry_id" value="1"> -->
                            </div>
                        </div>
                        <div class="">
                            <div class="input-wrapper select comapny-size">
                                <span class="input-img"><img src="{{asset('assets/web/images/size.png')}}" alt="company-size"></span>
                                <select class="careefer-select2" data-search="true" data-placeholder="Number of Employees" name="company_size">
                                    <option value=""></option>
                                    <option value="1-10">1-10</option>
                                    <option value="11-50">11-50</option>
                                    <option value="51-100">51-100</option>
                                    <option value="101-500">101-500</option>
                                    <option value="501-1000">501-1000</option>
                                    <option value="1001-5000">1001-5000</option>
                                    <option value="5001-10000">5001-10000</option>
                                    <option value="10001-50000">10001-50000</option>
                                    <option value="50000+">50000+</option>
                                </select>
                            </div>
                        </div>
                        <div class="acc-line">
                            <span>Associated Accounts</span>
                        </div>
                        <div class="email-container-wrap">
                            <div class="email-container">
                                <div class="email-append input-wrapper input-img"><img src="{{asset('assets/web/images/email.svg')}}" alt="email">
                                    <input class="associated-acc-email" type="email" name="email_0" placeholder="Email">
                                    <input type="hidden" name="temp2[]">
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrap add-btn ">
                            <button type="button" class="button del mail-del"><img src="{{asset('assets/web/images/delete.png')}}" alt="delete" class="del-img">Delete
                            </button>
                            <button class="add-more button add-mail" type="button">
                                <span class="plus">plus icon</span>Add More
                            </button>
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
                                <span class="checkmark"></span></label>
                            </div>
                        </div>
                        <button class="login-btn button" id="emp_signup_btn" type="button" onclick="employer_register();">
                            Sign Up
                        </button>
                    </form>
                    <span class="no-account">Already have an account? <a href="{{route('employer.login')}}" class="register-link">Sign In</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-image">
        Image
    </div>
    @push('js')
        <script src="{{asset('assets/js/employer.js')}}"></script>
        <script src="{{asset('assets/web/js/select2.min.js')}}"></script>
    @endpush
@endsection
