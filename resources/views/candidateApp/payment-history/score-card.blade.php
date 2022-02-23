@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="profile-content referrals profile-current" id="referral-tab">
               <div class="profile-content-inner shadow">
                  <h2>Referrals</h2>
                  @include('candidateApp.referral.bank-detail.include.top_bar_html')
                  <div class="refer-tabs-content">
                     <div id="score-content" class="refer-content refer-common refer-current">
                        <div class="score-card">
                           <ul class="score-list">
                              <li class="score-referral">
                                 <span class="score-no">{{ round($referral_score) }}</span>
                                 <span class="ref-score">Referral Score</span>
                              </li>
                              <li class="score-total">
                                 <span class="score-no">{{ @$total_referral  }}</span>
                                 <span class="ref-score">Total Referrals</span>
                              </li>
                              <li class="score-success">
                                 <span class="score-no"> {{ @$success_referral }} </span>
                                 <span class="ref-score">Successful Referrals</span>
                              </li>
                           </ul>
                           <h5>Do you know?</h5>
                           <ul class="score-text">
                              
                                 @php 
                                    $content = cmsPage('candidate-score-card-content');
                                    echo html_entity_decode($content);
                                 @endphp 

                             
                             <!--  <li>
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