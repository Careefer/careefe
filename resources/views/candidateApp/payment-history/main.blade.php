@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="profile-content referrals profile-current spc-job-ajax-render-section" id="referral-tab">
               @include('candidateApp.payment-history.include.job_card')
            </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>  
@endsection