@extends('layouts.web.web')
@section('content')

<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="dashboard-content dashboard-current shadow dash-wrapper">
               <div class="top-content">
                  <h2>Dashboard</h2>
                  <ul class="top-list">
                     <li>
                        <a href="#"> Today </a>
                     </li>
                     <li>
                        <a href="#"> Week </a>
                     </li>
                     <li class="active">
                        <a href="#"> Month </a>
                     </li>
                     <li>
                        <a href="#"> All </a>
                     </li>
                  </ul>
               </div>
               <ul class="dashboard-list">
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/hire-img.png')}}" alt="hired"></span>
                     <span class="dash-content"> <strong class="dash-no">4</strong> <span class="dash-text">Candidates hired</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/app-receive.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">20</strong> <span class="dash-text">Total applications received</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/app-share.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">12/54</strong> <span class="dash-text">Applications shared with employers</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/app-rated.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">15/54</strong> <span class="dash-text">Applications rated by me</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/jobs-hire.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">20</strong> <span class="dash-text">Jobs with successful hires</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/new-job.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">4</strong> <span class="dash-text">Jobs with applications received</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/job-app.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">4</strong> <span class="dash-text">New jobs</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/jobs-hire.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">3</strong> <span class="dash-text">Active jobs</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/job-accept.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">25</strong> <span class="dash-text">Jobs accepted</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/job-hold.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">3</strong> <span class="dash-text">On hold jobs</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/job-decline.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">15</strong> <span class="dash-text">Jobs declined</span> </span>
                  </li>
                  <li>
                     <span class="dashboard-img"><img src="{{asset('assets/web/images/close-job.png')}}" alt="applications"></span>
                     <span class="dash-content"> <strong class="dash-no">3</strong> <span class="dash-text">Closed jobs</span> </span>
                  </li>
               </ul>
               <span class="login-last">Last login: <span class="login-color">2 days ago</span></span>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>

@endsection
