@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="dashboard-content job-basket dashboard-current spc-job-ajax-render-section" id="corrent-tab">
              @include('specialistApp.application-detail.include.application-cards')
            </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>
@endsection
