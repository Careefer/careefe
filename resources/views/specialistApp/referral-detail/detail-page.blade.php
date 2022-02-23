@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
             @include('specialistApp.referral-detail.include.sent-card')
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>
@endsection
