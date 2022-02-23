@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="dashboard-content dash-pay dashboard-current">
              @if($type == 'referral-payment')
                @include('specialistApp.payment-history.include.job_referee_card')
              @else 
                @include('specialistApp.payment-history.include.job_card')
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
