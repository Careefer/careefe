@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
          <div class="dashboard-content dash-referrals dashboard-current referrals spc-job-ajax-render-section" id="corrent-tab">
            @if($page == 'sent')
              @include('specialistApp.referral.include.referal-card')
            @elseif($page == 'receive')
              @include('specialistApp.referral.include.referal-receive-card')
            @endif  
            </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>
@endsection
