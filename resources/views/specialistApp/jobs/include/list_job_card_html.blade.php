<div class="job-content-inner shadow">
      <h2>Job Basket</h2>
      <ul class="basket-tabs job-tabs-list clearfix">
         <li data-tab="new-job-content" class="basket-list {{($job_type == 'new')?'basket-current':''}} " onclick="redirect_url($(this),'{{route("specialist.jobs",["new"])}}',true)">
            New Jobs
         </li>
         <li data-tab="new-job-content" class="basket-list {{($job_type == 'accepted')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("specialist.jobs",["accepted"])}}',true)">
            Accepted Jobs
         </li>
         <li data-tab="new-job-content" class="basket-list {{($job_type == 'declined')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("specialist.jobs",["declined"])}}',true)">
            Declined Jobs
         </li>
      </ul>
      <div class="basket-tabs-content">
         <div id="new-job-content" class="basket-content basket-current dashboard-main">
         @if($jobs->count())
            @foreach($jobs AS $obj_job)
               @php
                  $obj_job = $obj_job->job;
               @endphp
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: {{$obj_job->job_id}}</em>

                        <h3>{{optional($obj_job->position)->name}}</h3>

                         @if(isset($obj_job->company->company_name))
                              <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                                    {{$obj_job->company->company_name}}
                              </h4>
                         @else
                              <h4>
                                 That employer is no longer exists.
                              </h4>     
                         @endif
                           
                        <span class="basket-text">
                           <!-- cities -->
                           @if($obj_job->cities())
                              {{implode(', ',$obj_job->cities())}}
                           @endif,

                           <!-- states -->
                           @if($obj_job->state())
                              <strong>{{implode(', ',$obj_job->state())}}</strong>
                           @endif,

                           <!-- country -->
                           <strong>
                              {{($obj_job->country)?$obj_job->country->name:''}}
                           </strong>
                        </span>

                        <span class="basket-text basket-vac">
                           Number of Vacancies: <strong>{{$obj_job->vacancy}}</strong>
                        </span>

                        @if(isset($obj_job->work_type->name))
                        <span class="basket-text basket-work">Work Type:
                           <strong>{{$obj_job->work_type->name}}</strong>
                        </span>
                        @endif

                        <span class="basket-text">
                           Received: 
                           <strong>
                              {{display_date_time($obj_job->updated_at)}}
                           </strong>
                        </span>
                     </div>
                     <div class="right-detail">
                        @php
                           $logo_path = ''; 
                           if(isset($obj_job->company->company_name)) {
                              $logo_path = public_path('storage/employer/company_logo/'.$obj_job->company->logo);
                           }
                          

                           if(file_exists($logo_path))
                           {
                              $logo_path = asset('storage/employer/company_logo/'.$obj_job->company->logo);
                           }
                           else
                           {
                              $logo_path = asset('storage/employer/company_logo/default.png');
                           }
                        @endphp

                        @if(isset($obj_job->company->company_name)) 
                        <a href="javascript:void(0);" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                           <img src="{{$logo_path}}" alt="project-apache">
                        </a>
                        @endif

                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">
                              @if($obj_job->specialist_bonus_amt)

                                 @php 
                                        $fromIsoCode = '';
                                        $fromCurrencySign = '';
                                        if($obj_job->country->currency_sign)
                                        {
                                          $fromCurrencySign = $obj_job->country->currency_sign->symbol;
                                          $fromIsoCode = $obj_job->country->currency_sign->iso_code;
                                        }

                                       $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$obj_job->specialist_bonus_amt);
                                       if($rateConversion)
                                       {
                                          echo $rateConversion;
                                       }
                                     @endphp
                                 {{--{{get_amount($obj_job->specialist_bonus_amt)}}--}}
                              @else
                              --   
                              @endif
                              </span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">
                                 @if($obj_job->referral_bonus_amt)

                                      @php 
                                        $fromIsoCode = '';
                                        $fromCurrencySign = '';
                                        if($obj_job->country->currency_sign)
                                        {
                                          $fromCurrencySign = $obj_job->country->currency_sign->symbol;
                                          $fromIsoCode = $obj_job->country->currency_sign->iso_code;
                                        }

                                       $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$obj_job->referral_bonus_amt);
                                       if($rateConversion)
                                       {
                                          echo $rateConversion;
                                       }
                                     @endphp
                                    {{--{{get_amount($obj_job->referral_bonus_amt)}}--}}
                                 @else
                                 --   
                                 @endif
                              </span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">

                        <em class="job-id">Job Id: {{$obj_job->job_id}}</em>

                        <h3>{{optional($obj_job->position)->name}}</h3>

                        @if(isset($obj_job->company->company_name))
                           <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                                 {{$obj_job->company->company_name}}
                           </h4>

                           <a href="javascript:void(0);"  class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                              <img src="{{$logo_path}}" alt="project-apache">
                           </a>
                        @endif

                       
                        <span class="basket-text">
                           <!-- cities -->
                           @if($obj_job->cities())
                              {{implode(', ',$obj_job->cities())}}
                           @endif,

                           <!-- states -->
                           @if($obj_job->state())
                              {{implode(', ',$obj_job->state())}}
                           @endif,

                           <!-- country -->
                           
                              {{($obj_job->country)?$obj_job->country->name:''}}
                           
                        </span>

                        <span class="basket-text basket-vac">
                           Number of Vacancies: <strong>{{$obj_job->vacancy}}</strong>
                        </span>

                        <span class="basket-text basket-work">
                           Work Type: <strong>{{$obj_job->work_type->name}}</strong>
                        </span>
                        <span class="basket-text">
                           Received:
                           <strong>
                              {{display_date_time($obj_job->updated_at)}}
                           </strong>
                        </span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">
                                 @if($obj_job->specialist_bonus_amt)
                                    {{get_amount($obj_job->specialist_bonus_amt)}}
                                 @else
                                 --   
                                 @endif
                              </span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">
                                 @if($obj_job->referral_bonus_amt)
                                    {{get_amount($obj_job->referral_bonus_amt)}}
                                 @else
                                 --   
                                 @endif
                              </span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>

               @if(isset($obj_job->company->company_name)) 
               <div class="bottom-block unsave-block">
                 
                    <a href="{{route('web.job_detail',[$obj_job->slug])}}" class="project-logo" class="detail-view" target="_blank">View Detail</a>
                
                
                  
                    <ul class="btn-list">
                     <li>
                        @php
                           $spcId =  my_id();
                           $room_data = ['jobId'=>$obj_job->id,'spcId'=>$spcId,'adminId'=>'1'];
                           $roomId =  base64_encode(json_encode($room_data));
                        @endphp
                        <a href="{{url('specialist/chat/'.$roomId)}}" class="msg-specialist">Message Admin</a>
                     </li>
                     @if($job_type == 'new')
                     <li class="reject-link bottom-btn">
                        <a href="javascript:void(0);" onclick="return confirm_popup('{{route("specialist.make_job_decline",[encrypt($obj_job->id)])}}','Want to decline this job');" class="button-link">Decline</a>
                     </li>
                     <li class="approve-link bottom-btn">
                        <a href="javascript:void(0)" onclick="return confirm_popup('{{route("specialist.make_job_accept",[encrypt($obj_job->id)])}}','Want to accept this job');" class="button-link">Accept</a>
                     </li>
                     @endif
                  </ul>
               </div>
               @endif
               
            </div>
            @endforeach
         @else
         {!! record_not_found_msg() !!}
         @endif
      </div>
   </div>
</div>
@if($jobs->count())
   {{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif
