@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper employer-main">
   <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="emp-content emp-current shadow emp-dash" id="emp-dashboard">
               <div class="top-content">
                  <h2>Dashboard</h2>
                  <form action="{{ route('employer.home') }}" method="GET" id="filter_form">
                        <input type="hidden" name="type" id="filter_data">
                  </form>
                  <ul class="top-list">
                     <li class="{{ app('request')->input('type') == 'today' ? 'active' : '' }}">
                        <a href="#" id="today"> Today </a>
                     </li>
                     <li class="{{ app('request')->input('type') == 'week' ? 'active' : '' }}">
                        <a href="#" id="week"> Week </a>
                     </li>
                     <li class="{{ app('request')->input('type') == 'month' ? 'active' : '' }}">
                        <a href="#" id="month"> Month </a>
                     </li>
                     <li class="{{ (app('request')->input('type') == 'all' || app('request')->input('type') == '') ? 'active' : '' }}">
                        <a href="#" id="all">All</a>
                     </li>
                  </ul>
               </div>
               <ul class="dashboard-list">
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/posted-jobs.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $posted_jobs }}</strong> <span class="dash-text">Jobs posted</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/app-receive.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $application_recevied }}</strong> <span class="dash-text">Applications received</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/job-app.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $job_with_application_recevied }}</strong> <span class="dash-text">Jobs with applications received</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/jobs-hire.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $job_with_application_recevied_with_success_hired }}</strong> <span class="dash-text">Jobs with successful hires</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/hire-img.png')}}" alt="hired"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $candidate_hired }} </strong> <span class="dash-text">Candidates hired</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/close-job.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $closed_jobs }}</strong> <span class="dash-text">Closed jobs</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/open-jobs.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $open_jobs }}</strong> <span class="dash-text">Open jobs</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/job-hold.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">{{ $on_hold_jobs}}</strong> <span class="dash-text">On hold jobs</span> </span>
                  </li>
               </ul>
               @php 
                  $user = my_detail();
               @endphp
               <span class="login-last">Last login: <span class="login-color"> {{ display_date_time($user->last_login)  }} </span></span>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>

 <script type="text/javascript">
        $(function(){
            $('.top-list #today').on('click', function(){
               $('#filter_data').val("today");
               $('#filter_form').submit(); 
            });

            $('.top-list #week').on('click', function(){
               $('#filter_data').val("week");
               $('#filter_form').submit(); 
            });

            $('.top-list #month').on('click', function(){
               $('#filter_data').val("month");
               $('#filter_form').submit(); 
            });

            $('.top-list #all').on('click', function(){
               $('#filter_data').val("all");
               $('#filter_form').submit(); 
            });

        });
</script>

@endsection
