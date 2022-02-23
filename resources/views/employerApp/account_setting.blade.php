@extends('layouts.web.web')
@section('content')

<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">

         <div class="emp-content shadow setting-wrapper emp-current">
            <div class="" id="settings-tab">
               <h2 class="d-inline-block-head">Settings</h2>
               <a class="edit-btn edit-btn-right" href="javascript:void()" onclick="redirect_url($(this),'{{ route('employer.profile.edit') }}');">
                <img src="{{asset('assets/web/images/edit-icon.png')}}" alt="edit">Edit </a>
               <ul class="job-tabs-list clearfix refer-tabs-list">
              <li class="lists-profile {{($active_tab == 'company')?'acc-current':''}}" data-tab="company-setting">
                Company Profile
              </li>
              <li class="lists-profile" data-tab="profile-setting">
                Personal Profile
              </li>
              <li class="lists-profile {{($active_tab == 'change_password')?'acc-current':''}}" data-tab="change-password">
                Change Password
              </li>
               </ul>

               <div class="acc-tab-content">
                <div id="company-setting" class="content-account clearfix {{($active_tab == 'company')?'acc-current':''}}">
                <div class="detail-main">
                  <div class="detail-left-wrapper">
                    <span class="cmp-logo">
                      @if($company_detail->logo) 
                      <img src="{{ asset('storage/employer/company_logo/'.$company_detail->logo) }}" alt="logo" >
                      @else
                       <img src="{{asset('assets/web/images/project-apache.png')}}" alt="apache">
                      @endif
                      
                    </span>

                    @if($company_detail->size_of_company)
                      <span class="emp-number">{{$company_detail->size_of_company}} Employees</span>
                    @endif
                  </div>
                  <div class="detail-right-wrapper">
                    <div class="company-detail">
                      <h2>{{$company_detail->company_name}}</h2>
                      @if($company_detail->head_office)
                        <span class="apache">
                          <img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                          <strong>Headquater:</strong>{{$company_detail->head_office->location}}
                        </span>
                      @endif
                      <span class="apache">
                        <img src="{{asset('assets/web/images/location.svg')}}" alt="location"><strong>Other Loactions:</strong> {{$other_location}}
                      </span>
                      <span class="company-website apache">
                        <img src="{{asset('assets/web/images/search.svg')}}" alt="website">
                        @if($company_detail->website_url)
                        <a href="{{$company_detail->website_url}}" target="_blank">{{$company_detail->website_url}}</a>
                        @else
                        Not specified
                        @endif
                      </span>
                    </div>
                    <h3>About Company</h3>
                    <p>
                    {{($company_detail->about_company)?$company_detail->about_company:'Not specified'}}</p>
                    <span class="industry-type"><strong>Industry: <img src="{{asset('assets/web/images/info-icon.png')}}" alt="info"></strong>
                      @if(isset($company_detail->industry->name))
                      {{$company_detail->industry->name}}
                      @else
                      Not specified
                      @endif
                    </span>
                  </div>
                </div>
                <a href="#" class="button-link request-link">Request Additional Account</a>
              </div>
               
               <div id="profile-setting" class="content-account">
                <div class="setting-outer clearfix">
                  <span class="setting-text"><strong>Name:</strong> {{$user_info->name}}</span>
                  <span class="setting-text"><strong>Email:</strong>{{$user_info->email}}</span>
                  <span class="setting-text"><strong>Contact no:</strong> {{($user_info->mobile)?$user_info->mobile:'Not specified'}}</span>
                  <span class="setting-text"><strong>Location:</strong>
                    @if(isset($user_info->my_location->location))
                      {{$user_info->my_location->location}}
                    @else
                      Not specified
                    @endif
                  </span>
                  <span class="setting-text"><strong>Timezone:</strong>&nbsp{{($timezone)?$timezone:'Not specified'}}</span>
                </div>
              </div>
              
              <div id="change-password" class="content-account clearfix {{($active_tab == 'change_password')?'acc-current':''}}">
              <h4>Change Password</h4>
                  <form class="setting-form spe-setting" method="POST" action="{{ route('employer.change-password') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <div class="setting-inner">
                        <div class="form-detail clearfix">
                           <div class="form-input">
                              <label class="form-label">Enter Existing Password</label>
                              <div class="pw-wrap">
                                 <input type="password" name="existing_password" id="existing_password" placeholder="Enter" value="{{old('existing_password')}}">
                              </div>
                              @if($errors->has('existing_password'))
                               <span class="err_msg">{{ $errors->first('existing_password') }}.</span>
                              @endif
                           </div>
                        </div>
                        <div class="form-detail clearfix">
                           <div class="form-input">
                              <label class="form-label">New Password</label>
                              <div class="pw-wrap">
                                 <input type="password" name="new_password" id="new_password" placeholder="Enter" value="{{ old('new_password') }}">
                              </div>
                              @if ($errors->has('new_password'))
                                <span class="err_msg">{{ $errors->first('new_password') }}.</span>
                              @endif
                           </div>
                           <div class="form-input">
                              <label class="form-label">Confirm Password</label>
                              <div class="pw-wrap">
                                 <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter" value="{{ old('confirm_password') }}">
                              </div>
                              @if ($errors->has('confirm_password'))
                              <span class="err_msg">{{ $errors->first('confirm_password') }}.</span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="update-pw">
                        <button type="submit" class="button-link">
                           Update
                        </button>
                     </div>
               </form>
              </div>
               </div>

               
            </div>
            </div>

         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>

@endsection
