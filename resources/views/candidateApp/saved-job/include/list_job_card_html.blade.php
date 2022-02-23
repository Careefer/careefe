<div class="job-content-inner shadow">
      <h2>My Job</h2>
      <ul class="job-tabs-list clearfix">
         <li data-tab="new-job-content" class="basket-list {{($job_type == 'saved')?'basket-current':''}} " onclick="redirect_url($(this),'{{route("candidate.saved_job",["saved"])}}',true)">
            Saved Jobs
         </li>
         <li data-tab="new-job-content" class="basket-list {{($job_type == 'applied')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("candidate.saved_job",["applied"])}}',true)">
            Applied Jobs
         </li>

         <li data-tab="new-job-content" class="basket-list {{($job_type == 'approve')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("candidate.saved_job",["approve"])}}',true)">
            Approve Applications
         </li>
      </ul>
      <div class="job-tabs-content">
         <div id="save-job-content" class="job-content job-current">
         @if($job_type == 'approve')
         <p>
               This is the list of jobs where you have been referred by someone else.  Please review the details below and approve the application(s) to apply to the job(s).
            </p>
         @endif   

         @if( !empty($jobs) && $jobs->count())
            @foreach($jobs AS $obj_job)
               @php
                  $obj_application = $obj_job;
                  $obj_job = $obj_job->job;
               @endphp
               <div class="project-job">
                  <div class="top-block top-desktop">
                     <div class="project-details">
                        <div class="left-detail">
                           <h2>{{optional($obj_job->position)->name}}</h2>

                            @if(isset($obj_job->company->company_name))
                                 <h4 class="apache-img apche-wrap" 
                                 onclick="redirect_url($(this),'{{route('web.company.detail',
                                 [$obj_job->company->slug])}}',null,true)"><img src="{{ asset('assets/web/images/company.svg') }}" alt="company">
                                       {{$obj_job->company->company_name}}
                                 </h4>
                            @else
                               <h4 class="apache-img apche-wrap" ><img src="{{ asset('assets/web/images/company.svg') }}" alt="company">
                               That job is no longer available.
                               </h4>
                            @endif

                           <em class="apache-img apche-wrap flag-icon">
                              <img src="{{asset('assets/web/images/time.svg') }}" alt="location">{{$obj_job->experience_min.'-'.$obj_job->experience_max}} years
                           </em>
                              
                           <span class="apache-img apche-wrap">
                              <img src="{{asset('assets/web/images/location.svg')}}" alt="location">
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

                           <div class="fulltime-wrap">
                              <strong>
                              <img class="wallet-img" src="https://thesst.com/SIS554/public/assets/web/images/wallet.jpg" alt="location">
                                 @php
                                    $currency_sign = '';

                                    if($obj_job->country->currency_sign)
                                    {
                                       $currency_sign = $obj_job->country->currency_sign->symbol;
                                    }

                                 @endphp
                                 {!!$currency_sign." ".number_format($obj_job->salary_min) !!} - 
                                 {{ number_format($obj_job->salary_max) }}

                                 {{--$  {{ $obj_job->salary_min  }} - {{ $obj_job->salary_max }} Lacs --}}
                              </strong>
                              <span
                              class="apache-img"><img src="{{ asset('assets/images/full-time-icon.png') }}"
                                 alt="full-time">{{$obj_job->work_type->name}}
                              </span>
                           </div>
               
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
                  <div class="top-block mobile-top">
                     <div class="project-details">
                        <div class="left-detail">

                           <h2>{{optional($obj_job->position)->name}}</h2>

                           @if(isset($obj_job->company->company_name))
                              <h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                                 <img src="{{ asset('assets/web/images/company.svg') }}" alt="company">
                                    {{$obj_job->company->company_name}}
                              </h4>
                            @endif

                           <a href="#" class="project-logo">
                           <img src="{{ asset('assets/images/project-apache.png') }}" alt="project-apache">
                           </a>

                           <em class="apache-img apche-wrap flag-icon">
                           <img src="{{ asset('assets/images/flag-icon.png') }}" alt="location">{{$obj_job->experience_min.'-'.$obj_job->experience_max}} years
                            </em>

                            <span class="apache-img apche-wrap">
                              <img src="{{ asset('assets/images/loc-img.png') }}" alt="location">
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
                           <div class="fulltime-wrap">
                              <strong>$ {{ $obj_job->salary_min  }} - {{ $obj_job->salary_max }}</strong><span
                              class="apache-img"><img src="assets/images/full-time-icon.png"
                                 alt="full-time"> {{$obj_job->work_type->name}}</span>
                           </div>
                        </div>
                        <div class="right-detail">
                           <span class="ref-bonus">
                              @if($obj_job->referral_bonus_amt)
                                 {{get_amount($obj_job->referral_bonus_amt)}}
                              @else
                              --   
                              @endif
                           </span>
                           <em class="ref-text">Referral Bonus</em>
                        </div>
                     </div>
                  </div>
                  @if($job_type == 'saved')
                  <div class="bottom-block unsave-block">
                     <span>Posted: <strong>{{time_Ago($obj_job->created_at)}}</strong></span>
                     <!-- <button class="save-star"><img src="{{ asset('assets/images/save-star2.png') }}"
                        alt="save-star">Unsave
                     </button> -->

                     @if(auth()->guard('candidate')->check())
                        @php
                           $candidate_id = base64_encode(auth()->guard('candidate')->user()->id);

                           $job_id = base64_encode($obj_job->id);

                        @endphp
                        <span class="save-star" onclick="make_job_favorite($(this),'{{$candidate_id}}','{{$job_id}}')">

                              @if(is_favorite_job(auth()->guard('candidate')->user()->id,$obj_job->id))
                                 <img src="{{asset('assets/web/images/save-star.png')}}"
                                 alt="save-star">
                              @else
                                 <img src="{{asset('assets/web/images/save-star2.png')}}">
                              @endif
                           Save
                        </span>
                     @endif

                  </div>
                  @elseif($job_type == 'applied')
                  <div class="bottom-block apply-bottom">
                     <ul class="app-menu clearfix">
                        <li>
                           <span>Application ID: </span><strong>{{ $obj_application->application_id}}</strong>
                        </li>
                        <li>
                           <span>Applied on: </span><strong class="super">{{display_date_time($obj_application->created_at)}}</strong>
                        </li>
                        <li>
                           <span>Status:</span><strong>{{ $obj_application->status}}</strong>
                        </li>
                     </ul>
                        @php
                           $canId =  my_id();
                           $room_data = ['jobId'=>$obj_application->job_id,'appId'=>$obj_application->id,'canId'=>$canId,'spcId'=>$obj_application->specialist_id];
                           $roomId =  base64_encode(json_encode($room_data));
                        @endphp

                        @if(isset($obj_job->company->company_name))    
                           <a href="{{url('candidate/chat/'.$roomId)}}" class="msg-specialist">Message Specialist</a>
                        @endif   
                     </div>
                    @elseif($job_type == 'approve')
                    <div class="bottom-block unsave-block">
                        <ul class="vacancy-menu">
                           <li>
                              <span>Referred: </span><strong>{{display_date_time($obj_application->created_at)}}</strong>
                           </li>
                           <li>
                              <span>Referred by: </span><strong>{{ @$obj_application->referred_by->name }}</strong>
                           </li>
                        </ul>
                        <ul class="btn-list">
                           <li class="reject-link bottom-btn">
                              <a href="#" class="button-link">Reject</a>
                           </li>
                           <li class="approve-link bottom-btn">
                              <a href="#" class="button-link">Approve</a>
                           </li>
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
@if(!empty($jobs) && $jobs->count())
   {{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif