@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="dashboard-content dash-pay dashboard-current" id="score-spe">
            	<div class="job-content-inner shadow">   
					<h2>Payments</h2>
					@include('specialistApp.payment.include.topbar')
					<div class="refer-tabs-content">
                  <div class="payment-content refer-common payment-current" id="score-spe">
                     <div class="score-card">
                        <ul class="score-list">
                           <li class="score-success">
                              <span class="score-no">{{ round($specialist_score) }}</span>
                              <span class="ref-score">Specialist Score</span>
                           </li>
                           <li class="score-total">
                              <span class="score-no"> {{ @$specialist_hired }}</span>
                              <span class="ref-score">Sucessful Hires</span>
                           </li>
                           <li class="score-referral">
                              <span class="score-no">{{ @$application_recommended }}</span>
                              <span class="ref-score">Applications Recommended</span>
                           </li>
                        </ul>
                        <h5>Do you know?</h5>
                        <ul class="score-text">
                           @php 
                              $content = cmsPage('specialist-score-card-content');
                              echo html_entity_decode($content);
                           @endphp 
                           <!-- <li>
                              This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum.
                           </li>
                           <li>
                              Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, , nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum gravida nibh vel velit auctor aliquet.
                           </li>
                           <li>
                              Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, , nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum gravida nibh vel velit auctor aliquet.
                           </li> -->
                        </ul>
                     </div>
                  </div>
					</div>
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
