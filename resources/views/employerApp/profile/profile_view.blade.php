@extends('layouts.web.web')
@section('content')
  <div class="dashboard-wrapper employer-main">
    <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
        <div class="main-tabs-content">
          <div class="emp-content shadow account-wrapper emp-current" id="emp-setting">
            <div class="profile-top">
              <h2>Account Settings</h2>
              <a class="edit-btn" href="javascript:void()" onclick="redirect_url($(this),'{{ route('employer.profile.edit') }}');">
                <img src="{{asset('assets/web/images/edit-icon.png')}}" alt="edit">Edit </a>
            </div>
            <ul class="job-tabs-list clearfix refer-tabs-list">
              <li class="lists-profile acc-current" data-tab="company-setting">
                Company Profile
              </li>
              <li class="lists-profile" data-tab="profile-setting">
                Personal Profile
              </li>
            </ul>
            <div class="acc-tab-content">
              <div id="company-setting" class="content-account clearfix acc-current">
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
                          <img src="{{asset('assets/web/images/new-loc.png')}}" alt="location">
                          <strong>Headquarter: </strong>{{$company_detail->head_office->location}}
                        </span>
                      @endif
                      <span class="apache">
                        <img src="{{asset('assets/web/images/new-loc.png')}}" alt="location"><strong>Other Location:</strong> {{$other_location}}
                      </span>
                      <span class="company-website apache">
                        <img src="{{asset('assets/web/images/website.png')}}" alt="website">
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
            </div>
          </div>
          <div class="emp-content shadow" id="emp-logout">

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom-image">
    Image
  </div>
@endsection
