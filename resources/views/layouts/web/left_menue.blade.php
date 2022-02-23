@php
  $arr = explode('_',auth()->guard()->getName());
@endphp
@if(in_array('employer',$arr) && auth()->guard('employer')->check())
  <ul class="main-tabs-list content-tab">
    <li class="dashboard-tabs {{(isset($active_menue) && $active_menue == 'dashboard')?'dashboard-current':''}}" onclick="redirect_url($(this),'{{route("employer.home")}}',true)">
      <img src="{{asset('assets/web/images/dash-img.png')}}" alt="Dashboard">Dashboard
    </li>

    <li class="dashboard-tabs {{ (isset($active_menue) && $active_menue == 'applications') ? 'dashboard-current':''}}" data-tab="app-tab" onclick="redirect_url($(this),'{{route("employer.applications",["active"])}}',true)"><img src="{{asset('assets/web/images/img-application.png')}}" alt="Applications">Applications
    </li>

    <li class="dashboard-tabs" onclick="redirect_url($(this),'{{route("employer.job.listing")}}',true)">
      <img src="{{asset('assets/web/images/job-basket.png')}}" alt="Job Basket">Manage Jobs
    </li>

    <li class="dashboard-tabs {{ (isset($active_menue) && $active_menue == 'payments') ? 'dashboard-current':''}}" data-tab="pay-tab" onclick="redirect_url($(this),'{{route("employer.payments")}}',true)"><img src="{{asset('assets/web/images/payments.png')}}" alt="Payments">Payments
    </li>

    <li class="dashboard-tabs msg-icon" onclick="redirect_url($(this),'{{route("employer.messages")}}',true)"  data-tab="message-tab"><img src="{{asset('assets/web/images/msg.svg')}}" alt="Messages">Messages
    </li>
    <li class="dashboard-tabs" onclick="redirect_url($(this),'{{route("employer.notifications")}}',true)" data-tab="not-tab"><img src="{{asset('assets/web/images/notification.png')}}" alt="Notifications">Notifications
    </li>

    <li class="dashboard-tabs" onclick="redirect_url($(this),'{{route("employer.my-account")}}',true)">
        <img src="{{asset('assets/web/images/img-setting.png')}}" alt="Notifications">
        Settings
      </li>
    <li class="dashboard-tabs" onclick="submit_form($(this),$('#logout-form'),true)">
      <form id="logout-form" action="{{ url('employer/logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
      <img src="{{asset('assets/web/images/img-logout.png')}}" alt="Notifications">
      Sign Out
    </li>
  </ul>
@endif 

@if(in_array('candidate',$arr) && auth()->guard('candidate')->check())
  <ul class="main-tabs-list content-tab">
      <li class="profile-tabs" onclick="redirect_url($(this),'{{route("candidate.my-profile")}}',true)">
        <img src="{{asset('assets/images/img-profile.png')}}" alt="my-profile">
          My Profile
      </li>
      <li class="dashboard-tabs" data-tab="jobs-tab" onclick="redirect_url($(this),'{{route("candidate.saved_job",["saved"])}}',true)">
          <img src="{{asset('assets/web/images/job-basket.png')}}" alt="Job Basket">
          My Jobs
      </li>
      <li class="dashboard-tabs {{ (isset($active_menue) && $active_menue == 'referrals') ? 'dashboard-current':''}}" data-tab="ref-tab" onclick="redirect_url($(this),'{{route("candidate.referral",["sent"])}}',true)">
        <img src="{{asset('assets/web/images/img-referral.png')}}" alt="Referrals">
          Referrals
      </li>
      <li class="dashboard-tabs msg-icon" onclick="redirect_url($(this),'{{route("candidate.messages")}}',true)"  data-tab="message-tab"><img src="{{asset('assets/web/images/msg.svg')}}" alt="Messages">Messages
      </li>
      <li class="dashboard-tabs" onclick="redirect_url($(this),'{{route("candidate.notifications")}}',true)" data-tab="not-tab">
        <img src="{{asset('assets/web/images/notification.png')}}" alt="Notifications">Notifications
      </li>
      <li class="dashboard-tabs msg-icon" onclick="redirect_url($(this),'{{route("candidate.alerts")}}',true)"  data-tab="message-tab"><img src="{{asset('assets/web/images/msg.svg')}}" alt="Messages">My Alerts
      </li>
      <li class="dashboard-tabs" onclick="redirect_url($(this),'{{route("candidate.my-account")}}',true)">
        <img src="{{asset('assets/web/images/img-setting.png')}}" alt="Notifications">
        Settings
      </li>
      <li class="dashboard-tabs" onclick="submit_form($(this),$('#logout-form'),true)">
        <form id="logout-form" action="{{ url('candidate/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <img src="{{asset('assets/web/images/img-logout.png')}}" alt="Notifications">
        Sign Out
      </li>
  </ul>
@endif

@if(in_array('specialist',$arr) && auth()->guard('specialist')->check())
  <ul class="main-tabs-list content-tab">
      <li data-tab="corrent-tab" class="dashboard-tabs {{(isset($active_menue) && $active_menue == 'dashboard')?'dashboard-current':''}}" onclick="redirect_url($(this),'{{route("specialist.home")}}',true)">
        <img src="{{asset('assets/web/images/dash-img.png')}}" alt="Dashboard">Dashboard
      </li>
      <li data-tab="corrent-tab" onclick="redirect_url($(this),'{{route("specialist.jobs",["new"])}}',true)" class="{{(isset($active_menue) && $active_menue == 'job')?'dashboard-current':''}}">
        <img src="{{asset('assets/web/images/job-basket.png')}}" alt="Job Basket">Job Basket
      </li>
      <li data-tab="corrent-tab" onclick="redirect_url($(this),'{{route("specialist.applications",["active"])}}',true)" class="{{(isset($active_menue) && $active_menue == 'applications')?'dashboard-current':''}}"> 
        <img src="{{asset('assets/web/images/application.png')}}" alt="Applications">Applications
      </li>
      <li data-tab="corrent-tab" onclick="redirect_url($(this),'{{route("specialist.referral-section",["sent"])}}',true)" class="{{(isset($active_menue) && $active_menue == 'referrals')?'dashboard-current':''}}">
        <img src="{{asset('assets/web/images/img-referral.png')}}" alt="Referrals">Referrals
      </li>
      <li data-tab="corrent-tab" onclick="redirect_url($(this),'{{route("specialist.referral-payment")}}',true)" class="dashboard-tabs {{(isset($active_menue) && $active_menue == 'payments')?'dashboard-current':''}}">
        <img src="{{asset('assets/web/images/payments.png')}}" alt="Payments">Payments
      </li>
      <li class="dashboard-tabs msg-icon" onclick="redirect_url($(this),'{{route("specialist.messages")}}',true)" data-tab="corrent-tab">
        <img src="{{asset('assets/web/images/msg.svg')}}" alt="Messages">Messages
      </li>
      <li class="dashboard-tabs" onclick="redirect_url($(this),'{{route("specialist.notifications")}}',true)" data-tab="corrent-tab">
        <img src="{{asset('assets/web/images/notification.png')}}" alt="Notifications">Notifications
      </li>
      <li data-tab="corrent-tab" class="dashboard-tabs" onclick="redirect_url($(this),'{{route("specialist.my-account")}}',true)">
        <img src="{{asset('assets/web/images/img-profile.png')}}" alt="My Account">
            My Account
      </li>
  
      <li class="dashboard-tabs" onclick="submit_form($(this),$('#logout-form'),true)">
        <form id="logout-form" action="{{ url('candidate/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <img src="{{asset('assets/web/images/img-logout.png')}}" alt="Notifications">
        Sign Out
      </li>
  </ul>
@endif