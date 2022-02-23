@php

  $user_type = null;
  $obj_user = null;
  $logoutUrl = null;

  $arr = explode('_',auth()->guard()->getName());

  if(in_array('employer',$arr) && auth()->guard('employer')->check())
  {
      $user_type = 'employer';
      $obj_user = auth()->guard('employer')->user();
      $logoutUrl = url('/employer/logout');
  }

  if(in_array('candidate',$arr) && auth()->guard('candidate')->check())
  {
      $user_type = 'candidate';
      $obj_user = auth()->guard('candidate')->user();
      $logoutUrl = url('/candidate/logout');
  }

  if(in_array('specialist',$arr) && auth()->guard('specialist')->check())
  {
      $user_type = 'specialist';
      $obj_user = auth()->guard('specialist')->user();
      $logoutUrl = url('/specialist/logout');
  }

@endphp

<header class="header">
  <div class="container clearfix">
    <a href="{{url('')}}" class="logo left-logo">
      @php $logo = site_config('site_logo');  @endphp 
        <img src="{{asset('storage/site_logo/'.$logo)}}" alt="careefer">
     <!--  <img src="{{asset('assets/web/images/logo.png')}}" alt="careefer"> -->
    </a>
    <div class="hamburger">
      <span class="top-line">line</span>
      <span class="middle-line">line</span>
      <span class="bottom-line">line</span>
    </div>
    <div class="currency-select currency-mobile">
      <div id="currency-flag" data-input-name="country" data-selected-country="IN" data-button-size="btn-lg" data-button-type="btn-warning" data-scrollable="true"  data-scrollable-height="250px"></div>
    </div>
    <div class="hamburger-menu">
      <ul class="left-menu clearfix">
        <li>
          <a href="javascript:void(0);" onclick="redirect_url($(this),'{{url('jobs')}}',true)">Jobs</a>
        </li>
        <li>
          <a href="javascript:void(0);" onclick="redirect_url($(this),'{{url('how-it-works')}}',true)">How it works?</a>
        </li>
        <li class="down-arrow">
          <span class="menu-tab">Resources</span>
          <ul class="header-submenu">
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.companies.listing')}}',true)">Company Profiles</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.career_advice')}}',true)">Career Advice</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.faq')}}',true)">FAQs</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.blogs')}}',true)">Blog</a>
            </li>
          </ul>
        </li>
        <li class="down-arrow">
          <span class="menu-tab">Specialists</span>
          <ul class="header-submenu">
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('specialist.register')}}',null)">Become a specialist</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.faq')}}',true)">FAQs</a>
            </li>
          </ul>
        </li>
        <li class="down-arrow">
          <span class="menu-tab">Employers</span>
          <ul class="header-submenu">
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('employer.register')}}',true)">
              Employer Sign Up</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{url('benefits')}}',true)">Benefits</a>
            </li>
            <li>
              <a href="#">Help</a>
            </li>
          </ul>
        </li>
      </ul>
      <nav class="right-menu-wrapper clearfix">
        <ul class="right-menu clearfix">
          <li class="currency-select header-current-list">
            @php 
              $currencies = currencies(); 
               if(!request()->session()->get('toIsoCode'))
               {
                   userCurrentLocation();
               }
            @endphp
            <select  class="currency_rate_conversion">
               @foreach($currencies as $currency)
               <option data-content="<i class='fa fa-address-book-o' aria-hidden='true'></i>" value="{{$currency->iso_code}}"
               @if(request()->session()->get('toIsoCode'))
                {{ ( $currency->iso_code == request()->session()->get('toIsoCode')) ? 'selected' : '' }}
               @endif> 
                {{$currency->iso_code}}</option>
               @endforeach
            </select>
            <!-- <div id="currency-flag-2" data-input-name="country" data-selected-country="IN" data-button-size="btn-lg" data-button-type="btn-warning" data-scrollable="true"  data-scrollable-height="250px">
            </div> -->
            {{--@if(auth()->user())--}}
            <div class="currency-popup box-arrow">
              <p>
                To change your currency, please visit your profile
                
              </p>
              <a href="#" class="visit-profile">Visit Profile</a>
            </div>
            {{--@endif--}}
          </li>
          @if($user_type)
            <li class="notification">
              <div class="action-link">
                <span class="notification-img" id="page-header-notifications-dropdown"><img src="{{asset('assets/web/images/bell-icon.png')}}" alt="notification"></span>
                @if(Auth::user()->unreadNotifications->count())
                <span class="notification-no">{{Auth::user()->unreadNotifications->count()}}</span>
                @endif
              </div>
              <div class="notification-wrapper box-arrow">
                <h4>Notifications</h4>
                <ul class="notification-menu">
                  @forelse(Auth::user()->unreadNotifications as $notification)
                  <li>
                    <a href="#"> <strong>{{$notification->data['first_name']." ".$notification->data['last_name']}}</strong> <span class="notification-text">{{$notification->data['notification']}}</span> <span class="notification-date">{{$notification->created_at}}</span> </a>
                  </li>
                  @empty
                    <p style="text-align: center;padding-top: 20px;"> NO Notification </p>           
                  @endforelse
                </ul>
                <div class="notification-link">
                  @if($user_type == 'employer')
                    <a href="{{route('employer.notifications')}}">See All</a>
                  @elseif($user_type == 'candidate')
                    <a href="{{route('candidate.notifications')}}">See All</a>
                  @elseif($user_type == 'specialist')
                    <a href="{{route('specialist.notifications')}}">See All</a>
                  @endif
                </div>
              </div>
            </li>
            <li class="registered-user clearfix">
              <div class="user-wrapper action-link">
               {{-- @if($user_type=='candidate')
                  @if($obj_user->image) 
                  <img src="{{ asset('storage/candidate/profile_pic/'.$obj_user->image) }}" alt="profile" >
                  @else
                   <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">
                  @endif
                @endif--}}
                <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">

                  @php 
                        $name  = strtoupper($obj_user->name); 
                        $remove = ['.', 'MRS', 'MISS', 'MS', 'MASTER', 'DR', 'MR'];
                        $nameWithoutPrefix=str_replace($remove," ",$name);
                        $words = explode(" ", $nameWithoutPrefix);
                        $firtsName = reset($words); 
                        $lastName  = end($words);
                        $firstname =  substr($firtsName,0,1);
                        $lastname = substr($lastName ,0,1);
                  @endphp
                 @if($firstname == $lastname) 
                    {{$firstname}}
                 @else
                  {{$firstname.$lastname}}
                 @endif
                
                </span>
              </div>
              <ul class="user-submenu box-arrow">

                   <li>
                    <a href="javascript:void(0);" style="cursor:default">{{ucfirst($obj_user->name)}}</a>
                  </li>
                @if($user_type == 'employer')
                  <li>
                    <a href="{{route('employer.profile.view')}}">Profile</a>
                  </li>
                @elseif($user_type == 'candidate')
                  <li>
                    <a href="{{route('candidate.my-profile')}}">Profile</a>
                  </li>
                @elseif($user_type == 'specialist')
                  <li>
                    <a href="{{route('specialist.profile')}}">Profile</a>
                  </li>  
                @endif

                <li>
                  @if($user_type == 'employer')
                  <a href="{{route('employer.job.listing')}}">My Jobs</a>
                  @elseif($user_type == 'candidate')
                  <a href="{{route("candidate.saved_job",["saved"])}}">My Jobs</a>
                  @elseif($user_type == 'specialist')
                  <a href="{{route("specialist.jobs",["new"])}}">My Jobs</a> 
                  @endif
                </li>
                <li>
                  @if($user_type == 'candidate')
                  <a href="{{route("candidate.referral",["sent"])}}">Referrals</a>
                  @elseif($user_type == 'specialist')
                  <a href="{{route("specialist.referral-section",["sent"])}}">Referrals</a>
                  @endif
                </li>
                <li>
                  @if($user_type == 'employer')
                  <a href="{{route("employer.messages")}}">Messages</a>
                  @elseif($user_type == 'candidate')
                  <a href="{{route("candidate.messages")}}">Messages</a>
                  @elseif($user_type == 'specialist')
                  <a href="{{route("specialist.messages")}}">Messages</a>
                  @endif
                </li>
                <li>
                  @if($user_type == 'employer')
                  <a href="{{route("employer.notifications")}}">Notification Center</a>
                  @elseif($user_type == 'candidate')
                  <a href="{{route("candidate.notifications")}}">Notification Center</a>
                  @elseif($user_type == 'specialist')
                  <a href="{{route("specialist.notifications")}}">Notification Center</a>
                  @endif
                </li>
                <li>
                  @if($user_type == 'employer')
                  <a href="{{route("employer.my-account")}}">Account Settings</a>
                  @elseif($user_type == 'candidate')
                  <a href="{{route("candidate.my-account")}}">Account Settings</a>
                  @elseif($user_type == 'specialist')
                  <a href="{{route("specialist.my-account")}}">Account Settings</a>
                  @endif
                </li>
                <li>                  
                    <form id="logout-form" action="{{ $logoutUrl }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                    </form>

                    <a href="javascript:void(0)"
                        onclick="submit_form($(this),$('#logout-form'))">
                        Sign Out
                    </a>
                </li>
              </ul>
            </li>
          @else
               @if(auth()->guard('candidate')->user())
                  @php
                    $user_type = 'candidate';
                    $obj_user = auth()->guard('candidate')->user();
                    $logoutUrl = url('/candidate/logout');
                  @endphp

                  <li class="notification">
                    <div class="action-link">
                      <span class="notification-img" id="page-header-notifications-dropdown"><img src="{{asset('assets/web/images/bell-icon.png')}}" alt="notification"></span>
                      @if($obj_user->unreadNotifications->count())
                      <span class="notification-no">{{$obj_user->unreadNotifications->count()}}</span>
                      @endif
                    </div>
                    <div class="notification-wrapper box-arrow">
                      <h4>Notifications</h4>
                      <ul class="notification-menu">
                        @forelse($obj_user->unreadNotifications as $notification)
                        <li>
                          <a href="#"> <strong>{{$notification->data['first_name']." ".$notification->data['last_name']}}</strong> <span class="notification-text">{{$notification->data['notification']}}</span> <span class="notification-date">{{$notification->created_at}}</span> </a>
                        </li>
                        @empty
                          <p style="text-align: center;padding-top: 20px;"> NO Notification </p>           
                        @endforelse
                      </ul>
                      <div class="notification-link">
                        @if($user_type == 'candidate')
                          <a href="{{route('candidate.notifications')}}">See All</a>
                        @endif
                      </div>
                    </div>
                  </li>
                  <li class="registered-user clearfix">
                    <div class="user-wrapper action-link">
                        {{-- @if($user_type=='candidate')
                          @if($obj_user->image) 
                          <img src="{{ asset('storage/candidate/profile_pic/'.$obj_user->image) }}" alt="profile" >
                          @else
                           <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">
                          @endif
                        @endif--}}
                     
                      <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">

                        @php 
                              $name  = strtoupper($obj_user->name); 
                              $remove = ['.', 'MRS', 'MISS', 'MS', 'MASTER', 'DR', 'MR'];
                              $nameWithoutPrefix=str_replace($remove," ",$name);
                              $words = explode(" ", $nameWithoutPrefix);
                              $firtsName = reset($words); 
                              $lastName  = end($words);
                              $firstname =  substr($firtsName,0,1);
                              $lastname = substr($lastName ,0,1);
                        @endphp
                       @if($firstname == $lastname) 
                          {{$firstname}}
                       @else
                        {{$firstname.$lastname}}
                       @endif
                      
                      </span>
                    </div>
                    <ul class="user-submenu box-arrow">

                         <li>
                          <a href="javascript:void(0);" style="cursor:default">{{ucfirst($obj_user->name)}}</a>
                        </li>
                     
                      @if($user_type == 'candidate')
                        <li>
                          <a href="{{route('candidate.my-profile')}}">Profile</a>
                        </li>  
                      @endif

                      <li>
                        @if($user_type == 'candidate')
                        <a href="{{route("candidate.saved_job",["saved"])}}">My Jobs</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'candidate')
                        <a href="{{route("candidate.referral",["sent"])}}">Referrals</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'candidate')
                        <a href="{{route("candidate.messages")}}">Messages</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'candidate')
                        <a href="{{route("candidate.notifications")}}">Notification Center</a>
                        @endif
                      </li>
                      <li>
                      
                        @if($user_type == 'candidate')
                        <a href="{{route("candidate.my-account")}}">Account Settings</a>
                        
                        @endif
                      </li>
                      <li>                  
                          <form id="logout-form" action="{{ $logoutUrl }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                          </form>

                          <a href="javascript:void(0)"
                              onclick="submit_form($(this),$('#logout-form'))">
                              Sign Out
                          </a>
                      </li>
                    </ul>
                  </li>
               @elseif(auth()->guard('employer')->check())
                  @php
                    $user_type = 'employer';
                    $obj_user = auth()->guard('employer')->user();
                    $logoutUrl = url('/employer/logout');
                  @endphp

                  <li class="notification">
                    <div class="action-link">
                      <span class="notification-img" id="page-header-notifications-dropdown"><img src="{{asset('assets/web/images/bell-icon.png')}}" alt="notification"></span>
                      @if($obj_user->unreadNotifications->count())
                      <span class="notification-no">{{$obj_user->unreadNotifications->count()}}</span>
                      @endif
                    </div>
                    <div class="notification-wrapper box-arrow">
                      <h4>Notifications</h4>
                      <ul class="notification-menu">
                        @forelse($obj_user->unreadNotifications as $notification)
                        <li>
                          <a href="#"> <strong>{{$notification->data['first_name']." ".$notification->data['last_name']}}</strong> <span class="notification-text">{{$notification->data['notification']}}</span> <span class="notification-date">{{$notification->created_at}}</span> </a>
                        </li>
                        @empty
                          <p style="text-align: center;padding-top: 20px;"> NO Notification </p>           
                        @endforelse
                      </ul>
                      <div class="notification-link">
                        @if($user_type == 'employer')
                          <a href="{{route('employer.notifications')}}">See All</a>
                        @endif
                      </div>
                    </div>
                  </li>
                  <li class="registered-user clearfix">
                    <div class="user-wrapper action-link">
                        {{-- @if($user_type=='candidate')
                          @if($obj_user->image) 
                          <img src="{{ asset('storage/candidate/profile_pic/'.$obj_user->image) }}" alt="profile" >
                          @else
                           <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">
                          @endif
                        @endif--}}
                     
                      <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">

                        @php 
                              $name  = strtoupper($obj_user->name); 
                              $remove = ['.', 'MRS', 'MISS', 'MS', 'MASTER', 'DR', 'MR'];
                              $nameWithoutPrefix=str_replace($remove," ",$name);
                              $words = explode(" ", $nameWithoutPrefix);
                              $firtsName = reset($words); 
                              $lastName  = end($words);
                              $firstname =  substr($firtsName,0,1);
                              $lastname = substr($lastName ,0,1);
                        @endphp
                       @if($firstname == $lastname) 
                          {{$firstname}}
                       @else
                        {{$firstname.$lastname}}
                       @endif
                      
                      </span>
                    </div>
                    <ul class="user-submenu box-arrow">

                         <li>
                          <a href="javascript:void(0);" style="cursor:default">{{ucfirst($obj_user->name)}}</a>
                        </li>
                     
                      @if($user_type == 'employer')
                        <li>
                          <a href="{{route('employer.profile.view')}}">Profile</a>
                        </li>  
                      @endif

                      <li>
                        @if($user_type == 'employer')
                        <a href="{{route('employer.job.listing')}}">My Jobs</a>
                        @endif
                      </li>
                      
                      <li>
                        @if($user_type == 'employer')
                        <a href="{{route("employer.messages")}}">Messages</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'employer')
                        <a href="{{route("employer.notifications")}}">Notification Center</a>
                        @endif
                      </li>
                      <li>
                      
                        @if($user_type == 'employer')
                        <a href="{{route("employer.my-account")}}">Account Settings</a>
                        
                        @endif
                      </li>
                      <li>                  
                          <form id="logout-form" action="{{ $logoutUrl }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                          </form>

                          <a href="javascript:void(0)"
                              onclick="submit_form($(this),$('#logout-form'))">
                              Sign Out
                          </a>
                      </li>
                    </ul>
                  </li>

                  @elseif(auth()->guard('specialist')->check())
                  @php
                    $user_type = 'specialist';
                    $obj_user = auth()->guard('specialist')->user();
                    $logoutUrl = url('/specialist/logout');
                  @endphp

                  <li class="notification">
                    <div class="action-link">
                      <span class="notification-img" id="page-header-notifications-dropdown"><img src="{{asset('assets/web/images/bell-icon.png')}}" alt="notification"></span>
                      @if($obj_user->unreadNotifications->count())
                      <span class="notification-no">{{$obj_user->unreadNotifications->count()}}</span>
                      @endif
                    </div>
                    <div class="notification-wrapper box-arrow">
                      <h4>Notifications</h4>
                      <ul class="notification-menu">
                        @forelse($obj_user->unreadNotifications as $notification)
                        <li>
                          <a href="#"> <strong>{{$notification->data['first_name']." ".$notification->data['last_name']}}</strong> <span class="notification-text">{{$notification->data['notification']}}</span> <span class="notification-date">{{$notification->created_at}}</span> </a>
                        </li>
                        @empty
                          <p style="text-align: center;padding-top: 20px;"> NO Notification </p>           
                        @endforelse
                      </ul>
                      <div class="notification-link">
                        @if($user_type == 'specialist')
                          <a href="{{route('specialist.notifications')}}">See All</a>
                        @endif
                      </div>
                    </div>
                  </li>
                  <li class="registered-user clearfix">
                    <div class="user-wrapper action-link">
                        {{-- @if($user_type=='candidate')
                          @if($obj_user->image) 
                          <img src="{{ asset('storage/candidate/profile_pic/'.$obj_user->image) }}" alt="profile" >
                          @else
                           <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">
                          @endif
                        @endif--}}
                     
                      <img src="{{asset('assets/web/images/user-img.png')}}" alt="img"><span class="user-name">

                        @php 
                              $name  = strtoupper($obj_user->name); 
                              $remove = ['.', 'MRS', 'MISS', 'MS', 'MASTER', 'DR', 'MR'];
                              $nameWithoutPrefix=str_replace($remove," ",$name);
                              $words = explode(" ", $nameWithoutPrefix);
                              $firtsName = reset($words); 
                              $lastName  = end($words);
                              $firstname =  substr($firtsName,0,1);
                              $lastname = substr($lastName ,0,1);
                        @endphp
                       @if($firstname == $lastname) 
                          {{$firstname}}
                       @else
                        {{$firstname.$lastname}}
                       @endif
                      
                      </span>
                    </div>
                    <ul class="user-submenu box-arrow">

                         <li>
                          <a href="javascript:void(0);" style="cursor:default">{{ucfirst($obj_user->name)}}</a>
                        </li>
                     
                      @if($user_type == 'specialist')
                        <li>
                          <a href="{{route('specialist.profile')}}">Profile</a>
                        </li>  
                      @endif

                      <li>
                        @if($user_type == 'specialist')
                        <a href="{{route("specialist.jobs",["saved"])}}">My Jobs</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'specialist')
                        <a href="{{route("specialist.referral-section",["sent"])}}">Referrals</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'specialist')
                        <a href="{{route("specialist.messages")}}">Messages</a>
                        @endif
                      </li>
                      <li>
                        @if($user_type == 'specialist')
                        <a href="{{route("specialist.notifications")}}">Notification Center</a>
                        @endif
                      </li>
                      <li>
                      
                        @if($user_type == 'specialist')
                        <a href="{{route("specialist.my-account")}}">Account Settings</a>
                        
                        @endif
                      </li>
                      <li>                  
                          <form id="logout-form" action="{{ $logoutUrl }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                          </form>

                          <a href="javascript:void(0)"
                              onclick="submit_form($(this),$('#logout-form'))">
                              Sign Out
                          </a>
                      </li>
                    </ul>
                  </li>
                     
               @else
                <li class="employer-login">
                  <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('employer.login')}}',true)">Employer Login</a>
                </li>
                <li>
                  <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('candidate.login')}}',true)">Sign In</a>
                </li>
                <li>
                  <a href="javascript:void(0);" class="register-btn" onclick="redirect_url($(this),'{{route('candidate.register')}}',true)">Sign Up</a>
                </li>
              @endif
          @endif
        </ul>
      </nav>
    </div>
  </div>
</header>

@php  $url = $user_type.'/readNotification'; @endphp
<script>
    $(document).ready(function()
    {
        $("#page-header-notifications-dropdown").on("click",function(e){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
              url : '{{ url($url) }}',
              type : "POST",
              success : function(data){
                $("span.count").remove();
              }
            });
          }); 
    });
</script>