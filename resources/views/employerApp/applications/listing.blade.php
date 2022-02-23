@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="dashboard-content job-basket dashboard-current" id="corrent-tab">
               <h2>Applications</h2>
               <ul class="app-tabs job-tabs-list clearfix hrz-scroll">
                  <li data-tab="act-content" class="apps-list {{($application_type == 'active')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("employer.applications",["active"])}}',true)">
                  Active Jobs
                  </li>
                  <li data-tab="hold-content" class="apps-list {{($application_type == 'on-hold')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("employer.applications",["on-hold"])}}',true)">
                  On hold Jobs
                  </li>
                  <li data-tab="closed-content" class="apps-list {{($application_type == 'closed')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("employer.applications",["closed"])}}',true)">
                  Closed Jobs
                  </li>
                  <li data-tab="cancel-content" class="apps-list {{($application_type == 'cancelled')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("employer.applications",["cancelled"])}}',true)">
                  Cancelled Jobs
                  </li>
               </ul>
               @include('employerApp.applications.include.filters')
               <div class="spc-job-ajax-render-section">
               @include('employerApp.applications.include.list_application_card_html')
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
