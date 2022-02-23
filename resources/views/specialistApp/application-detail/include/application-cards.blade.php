<div class="dashboard-content dashboard-current dash-application detail-app" id="app-tab">
  <div class="job-content-inner shadow">
    <div class="dashboard-main appliactions-list">
      <div class="btn-back">
        <a href="{{ route('specialist.application.detail', @$application->job->slug) }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
      </div>
      <div class="project-job">
        <div class="top-block top-desktop">
        <div class="top-main">
          <em class="job-id">Job Id: {{  @$application->job->job_id }}</em>
          <span class="pending">Job Status: <span class="{{ @$application->job->status }}">{{  @$application->job->status }}</span></span>
        </div>
          <div class="project-details">
            <div class="left-detail">
              <h3>{{ optional($application->job->position)->name }}</h3>
              @if(@$application->job->company->company_name)
                <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$application->job->company->slug])}}',null,true)">
                      {{ $application->job->company->company_name }}
                </h4>
              @endif
              <span class="basket-text">
                 <!-- cities -->
               @if($application->job->cities())
                  {{implode(', ',$application->job->cities())}}
               @endif,

               <!-- states -->
               @if($application->job->state())
                  <strong>{{implode(', ',$application->job->state())}}</strong>
               @endif,

               <!-- country -->
               <strong>
                  {{(@$application->job->country)? @$application->job->country->name:''}}
               </strong>
              </span>
              <span class="basket-text basket-vac">Vacancies: <strong>{{$application->job->vacancy}}</strong></span>
              <span class="basket-text basket-vac">Applications: <strong>{{ $application->job->applications() }}</strong></span>
              <span class="basket-text basket-work">Applications recommended: <strong>{{ $application->job->recommended() }}</strong></span>
              <span class="basket-text">Received: <strong>{{display_date_time($application->job->created_at)}}</strong></span>
            </div>
            <div class="right-detail">
              @php
               $logo_path = public_path('storage/employer_logos/'.@$application->job->company->logo);

               if(file_exists($logo_path))
               {
                  $logo_path = asset('storage/employer_logos/'.$application->job->company->logo);
               }
               else
               {
                  $logo_path = asset('storage/employer/company_logo/default.png');
               }
            @endphp


              <a href="#" class="project-logo"><img src="{{ $logo_path }}" alt="project-apache"></a>
              <ul class="basket-bonus">
                <li>
                  <span class="ref-bonus">
                    @if($application->job->specialist_bonus_amt)

                        @php 
                         $fromIsoCode = '';
                         $fromCurrencySign = '';
                         if($application->job->country->currency_sign)
                         {
                          $fromCurrencySign = $application->job->country->currency_sign->symbol;
                          $fromIsoCode = $application->job->country->currency_sign->iso_code;
                         }

                        $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$application->job->specialist_bonus_amt);
                        if($rateConversion)
                        {
                          echo $rateConversion;
                        }
                       @endphp

                     {{--{{get_amount($application->job->specialist_bonus_amt)}}--}}
                  @else
                  --   
                  @endif</span>
                  <em class="ref-text">Specialist Bonus</em>
                </li>
                <li>
                  <span class="ref-bonus">
                  @if($application->job->referral_bonus_amt)
                      @php 
                         $fromIsoCode = '';
                         $fromCurrencySign = '';
                         if($application->job->country->currency_sign)
                         {
                          $fromCurrencySign = $application->job->country->currency_sign->symbol;
                          $fromIsoCode = $application->job->country->currency_sign->iso_code;
                         }

                        $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$application->job->referral_bonus_amt);
                        if($rateConversion)
                        {
                          echo $rateConversion;
                        }
                       @endphp
                      {{--{{get_amount($application->job->referral_bonus_amt)}}--}}
                  @else
                     --   
                   @endif</span>
                  <em class="ref-text">Referral Bonus</em>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="top-block top-mobile">
          <div class="project-details">
            <div class="left-detail">
              <em class="job-id">Job Id: {{ @$application->job->job_id }}</em>
              <h3>{{ optional($application->job->position)->name }}</h3>
              @if(@$application->job->company->company_name)
                <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$application->job->company->slug])}}',null,true)">
                      {{ $application->job->company->company_name }}
                </h4>
              @endif
              <a href="#" class="project-logo"><img src="{{ $logo_path }}" alt="project-apache"></a>
              <span class="basket-text">
                  <!-- cities -->
               @if($application->job->cities())
                  {{implode(', ',$application->job->cities())}}
               @endif,

               <!-- states -->
               @if($application->job->state())
                  <strong>{{implode(', ',$application->job->state())}}</strong>
               @endif,

               <!-- country -->
               <strong>
                  {{(@$application->job->country)? @$application->job->country->name:''}}
               </strong>  

              </span>
              <span class="basket-text basket-vac">Vacancies: <strong>{$application->job->vacancy}}</strong></span>
              <span class="basket-text basket-vac">Applications: <strong>{{ $application->job->applications() }}</strong></span>
              <span class="basket-text basket-work">Applications recommended: <strong>{{ $application->job->recommended() }}</strong></span>
              <span class="basket-text">Received: <strong>{{display_date_time($application->job->created_at)}}</strong></span>
            </div>
            <div class="right-detail">
              <ul class="basket-bonus">
                <li>
                  <span class="ref-bonus">@if($application->job->specialist_bonus_amt)
                     {{get_amount($application->job->specialist_bonus_amt)}}
                  @else
                  --   
                  @endif</span>
                  <em class="ref-text">Specialist Bonus</em>
                </li>
                <li>
                  <span class="ref-bonus">
                  @if($application->job->referral_bonus_amt)
                      {{get_amount($application->job->referral_bonus_amt)}}
                  @else
                     --   
                  @endif
                  </span>
                  <em class="ref-text">Referal Amount</em>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="app-detail-wrapper">
        <div class="list-content">
          <div class="application-wrapper">
            <em class="app-id">Application Id: {{ $application->application_id }}</em>
            <div class="app-status">
              @php 
                //$application_status = ['applied' => 'Applied','in_progress' =>'In Progress', 'unsuccess' => 'Unsuccess', 'success'=>'Success', 'candidate_declined'=> 'Candidate Declined', 'hired' => 'Hired','cancelled'=> 'Cancelled']; 
              @endphp 

              <Span class="status-text">Application Status:</Span>
              <div class="status-wrapper">
                <select class="sts-select" id="select-application-status">
                 <!--  <option value="">Application Status</option> -->
                  @foreach($application_status as $key=>$val)

                  @php
                     $selected = '';
                     if(isset($application->status) && $application->status == $key)
                     {
                       $selected = 'selected="selected"';
                     }
                   @endphp
                  <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="reference-wrapper">
            <div class="ref-info">
              <span class="ref-name">{{ $application->name }}</span>
              <span class="basket-text">{{ (@$application->candidate->current_location) ? @$application->candidate->current_location->address : '--' }}, <strong>{{ (@$application->candidate->current_location) ? @$application->candidate->get_location_by_id($application->candidate->current_location->location_id)->location : '--' }}</strong></span>
              <ul class="email-list">
                <li>
                  <a href="mailto:{{ $application->email }}" class="ref-mail">{{ $application->email }}</a>
                </li>
                <li>
                  via Email
                </li>
              </ul>
              <a href="tel:{{$application->mobile}}" class="basket-text basket-tel">{{ $application->mobile }}</a>
              <span class="current-employer">{{ $application->current_company }}</span>
              <div class="basket-text">{{ (@$application->candidate->career_history[0]->company_name) ?? '--' }}</div>
            </div>  
            <div class="ref-rating">
              <span class="rating-text">Referee's rating:</span>
              <ul class="rating-star clearfix rating-cursor">
                
               @if(!empty($application->rating_by_referee) && $application->rating_by_referee > 0)
                @for($i=1; $i<=$application->rating_by_referee ; $i++)
                  <li>
                  <a href="#">
                  <img src="{{asset('assets/images/rating.png')}}" alt="rating"></a>
                  </li>
                @endfor
                @endif

                @if(empty($application->rating_by_referee) && $application->rating_by_referee  <= 0)

                @php
                $rating = 5;
                @endphp

                @elseif($application->rating_by_referee == 5)

                @php
                $rating = 0;
                @endphp


                @else 

                @php 
                $rating = 5 - $application->rating_by_referee;
                @endphp

                @endif

                @if($rating)
                @for($i=1; $i<=$rating ; $i++)
                <li>
                <a href="#">
                  <img src="{{asset('assets/images/rating-star2.png')}}" alt="rating">
                  </a>
                </li>
                @endfor
                @endif 


              </ul>
            </div>
          </div>
        </div>
        <div class="app-top view-right">
          <a href="#" class="button-link view-pro">View Profile</a>
        </div>
        <span class="applied">Applied: {{ display_date_time($application->created_at) }} </span>
        @if(@$application->job->status != 'cancelled')
        <div class="msg-outer">
          <ul class="main-resume">
            <li>
              <a href="{{ asset('storage/candidate/resume/'.$application->resume) }}" target="_blank"><img src="{{ asset('assets/images/img-resume.png')}}" alt="resume">Resume</a>
            </li>
            <li>
              <a href="{{ asset('storage/candidate/cover_letter/'.$application->cover_letter) }}" target="_blank"><img src="{{ asset('assets/images/cv-img.png')}}" alt="cv">Cover Letter</a>
            </li>
          </ul>
          <ul class="msg-buttons">
            <li>
              @php
                 $spcId =  my_id();
                 $room_data = ['jobId'=>$application->job_id,'appId'=>$application->id,'canId'=>$application->candidate_id,'spcId'=>$spcId];
                 $roomId =  base64_encode(json_encode($room_data));
              @endphp
              <a href="{{url('specialist/chat/'.$roomId)}}" class="button-link msg-candidate">Message Candidate</a>
              <span class="info-img"><img src="{{ asset('assets/images/info-img.png')}}" alt="info">
                <span class="info-candidatemsg">Click message candidate button to enquire about this job profile</span>
              </span>
            </li>
            <li>
                <!-- $spcId =  my_id();
                 $room_data = ['jobId'=>$application->job_id,'appId'=>$application->id,'adminId'=>'1','spcId'=>$spcId];
                 $roomId =  base64_encode(json_encode($room_data)); -->
              @php
               
                 $spcId =  my_id();
                 $room_data = ['jobId'=>$application->job_id,'appId'=>$application->id,'spcId'=>$spcId,'adminId'=>'1'];
                 $roomId =  base64_encode(json_encode($room_data));
              @endphp
              <a href="{{url('specialist/chat/'.$roomId)}}" class="button-link">Message Admin</a>
              <span class="info-img adminblog"><img src="{{ asset('assets/images/info-img.png')}}" alt="info">
              <span class="info-adminmsg">Click message admin button to enquire about this job profile</span>

            </span>
            </li>
          </ul>
        </div>
        @endif
        @if(@$application->job->status != 'closed' && @$application->job->status != 'cancelled')
        <div class="rating-main">
          <div class="emp-rating">
            <span class="rating-text add-rating">Add rating:</span>
            <!-- <ul class="rating-star clearfix" id="stars">
              <li class="star rating-fill"><i class="fa fa-star" aria-hidden="true"></i>
              </li>
               <li class="star"><i class="fa fa-star" aria-hidden="true"></i>
              </li>
               <li class="star"><i class="fa fa-star" aria-hidden="true"></i>
              </li>
               <li class="star"><i class="fa fa-star" aria-hidden="true"></i>
              </li>
               <li class="star"><i class="fa fa-star" aria-hidden="true"></i>
              </li>
            </ul> -->
             <!-- Rating Stars Box -->
            <div class='rating-stars text-center'>
              <ul id='stars'>
                <li class='star {{ ($application->rating_by_specialist >0 && $application->rating_by_specialist >= 1 ) ? "selected": "" }}' title='Poor' data-value='1'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($application->rating_by_specialist >0 && $application->rating_by_specialist >= 2 ) ? "selected": "" }}' title='Fair' data-value='2'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($application->rating_by_specialist >0 && $application->rating_by_specialist >= 3 ) ? "selected": "" }}' title='Good' data-value='3'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($application->rating_by_specialist >0 && $application->rating_by_specialist >= 4 ) ? "selected": "" }}' title='Excellent' data-value='4'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($application->rating_by_specialist >0 && $application->rating_by_specialist >= 5 ) ? "selected": "" }}' title='WOW!!!' data-value='5'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
              </ul>
            </div>
          </div>
          <div class="push-wrapper">
            <div class="msg-employer">
              <a href="#" class="button-link emp-button">Message Employer</a>
              <span class="info-img"><img src="{{ asset('assets/images/info-img.png') }}" alt="info"></span>
            </div>
            @if($application->recommended_by)
            <button type="button" class="button push-btn button-link">
             Shared with Employer
            </button>
            @else
            <button type="button" class="button push-btn button-link" onclick="return confirm_popup_CLOSED('{{route("specialist.job.application.share-with-employer",[encrypt($application->id)])}}','Want to Share with Employer');">
              Share with Employer
            </button>
            @endif
          </div>
        </div>
        <form class="notes-form clearfix" method="POST" action="{{ route('specialist.update.specialist_notes', [$application->id]) }}">
          @csrf 
          <div class="profile-input salary-box notes-area">
            <label>Enter Salary</label>
            <input type="number" name="salary" id="salary" value="{{ $application->salary }}"  {{ ($application->salary) ? "readonly" : '' }}>  
          </div>
          <label>My notes</label>
          <div class="profile-input notes-area">
            <textarea name="specialist_notes">{{ @$application->specialist_notes }}</textarea>
            <input type="hidden" name="status" id="status_application" value="{{ $application->status }}">
            <input type="hidden" name="rating_by_specialist" id="rating_by_specialist" value="{{ $application->rating_by_specialist}}">
            <input type="hidden" name="recommended_by" id="recommended_by">
          </div>
          <label>My personal notes</label>
          <div class="profile-input notes-area">
            <textarea name="specialist_personal_notes">{{ @$application->specialist_personal_notes }}</textarea>
          </div>
          @if(@$application->status !=='hired')
          <button class="button button-link notes-save" type="submit">
            Save
          </button>
          @endif
        </form>
      @endif
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">

$(function(){
  var status =  $('#select-application-status').val();
   if(status == 'hired'){
      $('.salary-box').show();
   }else{
    $('.salary-box').hide();
   }
});

$('.sts-select').on('selectmenuchange', function(){
 var status =  $('#select-application-status').val();
 //price_update('abc','helo', 'text');
 if(status == 'hired'){
    $('.salary-box').show();
 }else{
  $('.salary-box').hide();
 }
});



$('.sts-select').on('selectmenuchange', function(){
 var status =  $('#select-application-status').val();
 if(status){
  $('#status_application').val(status);
 }   
});

$('.push-btn').on('click', function(){
   $('#recommended_by').val(1); 
});


function responseMessage(msg) {
 $('#rating_by_specialist').val(msg);
}


</script>
@endpush