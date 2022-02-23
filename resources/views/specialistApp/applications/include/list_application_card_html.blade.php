<div class="job-content-inner shadow">
      <div class="application-tabs-content">
         <div id="act-content" class="apps-content apps-current dashboard-main apps-wrapper">
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
                        <h3>{{ optional($obj_job->position)->name}}</h3>

                       @if($obj_job->company->company_name)
                              <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                                    {{$obj_job->company->company_name}}
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
                        <span class="basket-text basket-vac">Vacancies: <strong>{{$obj_job->vacancy}}</strong></span>

                        <span class="basket-text basket-vac">Applications: <strong>{{ $obj_job->applications() }}</strong></span>


                        <span class="basket-text basket-work">Applications recommended: <strong> {{ $obj_job->recommended() }}</strong></span>

                        <span class="basket-text">Received: <strong>{{display_date_time($obj_job->created_at)}}</strong></span>

                     </div>
                     <div class="right-detail">
                         @php
                           $logo_path = public_path('storage/employer_logos/'.$obj_job->company->logo);

                           if(file_exists($logo_path))
                           {
                              $logo_path = asset('storage/employer_logos/'.$obj_job->company->logo);
                           }
                           else
                           {
                              $logo_path = asset('storage/employer/company_logo/default.png');
                           }
                        @endphp

                        <a href="#" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                           <img src="{{$logo_path}}" alt="project-apache"></a>
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
                              @endif </span>
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
                     <a class="ref-button" href="{{ route('specialist.application.detail', [$obj_job->slug])}}"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="top-main">
                     <em class="job-id">Job Id: {{ $obj_job->job_id }}</em>
                     <span class="pending">Job Status: <span class="pending-color">{{ ucfirst($obj_job->status)}}</span></span>
                  </div>
                  <div class="project-details">
                     <div class="left-detail">
                        <!-- <em class="job-id">Job Id: {{$obj_job->job_id}}</em> -->
                        <h3>{{optional($obj_job->position)->name}}</h3>

                        @if($obj_job->company->company_name)
                           <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                                 {{$obj_job->company->company_name}}
                           </h4>
                        @endif

                        <a href="javascript:void(0)" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img src="{{$logo_path}}" alt="project-apache"></a>


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

                        <span class="basket-text basket-vac">Vacancies: <strong>{{$obj_job->vacancy}}</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>{{display_date_time($obj_job->created_at)}}</strong></span>
                     </div>
                     <div class="right-detail">
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
                     <a class="ref-button" href="{{ route('specialist.application.detail', [$obj_job->slug])}}"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="{{ route('web.job_detail', [$obj_job->slug]) }}" class="detail-view" target="_blank">View Detail</a>
                  @if($application_type != 'cancelled')
                  <ul class="btn-list">
                     @php
                        $spcId =  my_id();
                        $room_data = ['jobId'=>$obj_job->id,'spcId'=>$spcId,'adminId'=>'1'];
                        $roomId =  base64_encode(json_encode($room_data));
                     @endphp
                     <li>
                        <a href="{{url('specialist/chat/'.$roomId)}}" class="msg-specialist">Message Admin</a>
                     </li>
                     @if($application_type != 'closed')
                     <li>
                        @php
                           $spcId =  my_id();
                           $room_data = ['jobId'=>$obj_job->id,'spcId'=>$spcId,'empId'=>$obj_job->employer_id];
                           $roomId =  base64_encode(json_encode($room_data));
                        @endphp
                        <a href="{{url('specialist/chat/'.$roomId)}}" class="msg-specialist">Message Employer</a>
                     </li>
                     @endif
                  </ul>
                  @endif
               </div>
               
            </div>
            @endforeach
            @else
            {!! record_not_found_msg() !!}
            @endif

          
         </div>
         <!-- <div id="hold-content" class="apps-content dashboard-main apps-wrapper">
            <form class="app-form">
               <label>Filter:</label>
               <div class="app-selectbox id-select-wrap2">
                  <select class="id-select2">
                     <option>Job Id</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox pos-select-wrap2">
                  <select class="pos-select2">
                     <option>Position</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox com-select-wrap2">
                  <select class="com-select2">
                     <option>Company</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox job-select-wrap">
                  <select class="job-select" data-search="true" placeholder="Job Location">
                     <option>Job Location</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <ul class="form-button">
                  <li>
                     <button type="button" class="button-link apply-btn">
                        Apply
                     </button>
                  </li>
                  <li>
                     <button type="button" class="reset-button button">
                        Reset
                     </button>
                  </li>
               </ul>
            </form>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div id="closed-content" class="apps-content dashboard-main apps-wrapper">
            <form class="app-form">
               <label>Filter:</label>
               <div class="app-selectbox id-select-wrap3">
                  <select class="id-select3">
                     <option>Job Id</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox pos-select-wrap3">
                  <select class="pos-select3">
                     <option>Position</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox com-select-wrap3">
                  <select class="com-select3">
                     <option>Company</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox job-select-wrap">
                  <select class="job-select" data-search="true" placeholder="Job Location">
                     <option>Job Location</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <ul class="form-button">
                  <li>
                     <button type="button" class="button-link apply-btn">
                        Apply
                     </button>
                  </li>
                  <li>
                     <button type="button" class="reset-button button">
                        Reset
                     </button>
                  </li>
               </ul>
            </form>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div id="cancel-content" class="apps-content dashboard-main apps-wrapper">
            <form class="app-form">
               <label>Filter:</label>
               <div class="app-selectbox id-select-wrap4">
                  <select class="id-select4">
                     <option>Job Id</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox pos-select-wrap4">
                  <select class="pos-select4">
                     <option>Position</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox com-select-wrap4">
                  <select class="com-select4">
                     <option>Company</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <div class="app-selectbox job-select-wrap">
                  <select class="job-select" data-search="true" placeholder="Job Location">
                     <option>Job Location</option>
                     <option>Option 1</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                  </select>
               </div>
               <ul class="form-button">
                  <li>
                     <button type="button" class="button-link apply-btn">
                        Apply
                     </button>
                  </li>
                  <li>
                     <button type="button" class="reset-button button">
                        Reset
                     </button>
                  </li>
               </ul>
            </form>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="project-job">
               <div class="top-block top-desktop">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="top-block top-mobile">
                  <div class="project-details">
                     <div class="left-detail">
                        <em class="job-id">Job Id: CF1278</em>
                        <h3>Project Manager</h3>
                        <h4>The Apache Software Foundation</h4>
                        <a href="#" class="project-logo"><img src="assets/images/project-apache.png" alt="project-apache"></a>
                        <span class="basket-text">Noida, <strong>India</strong></span>
                        <span class="basket-text basket-vac">Vacancies: <strong>15</strong></span>
                        <span class="basket-text basket-vac">Applications: <strong>25</strong></span>
                        <span class="basket-text basket-work">Applications recommended: <strong>8</strong></span>
                        <span class="basket-text">Received: <strong>12 May, 2019  06:30 pm IST</strong></span>
                     </div>
                     <div class="right-detail">
                        <ul class="basket-bonus">
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Specialist Bonus</em>
                           </li>
                           <li>
                              <span class="ref-bonus">$20</span>
                              <em class="ref-text">Referral Bonus</em>
                           </li>
                        </ul>
                     </div>
                     <a class="ref-button" href="applications-list.html"> button </a>
                  </div>
               </div>
               <div class="bottom-block unsave-block">
                  <a href="job-detail-specialist.html" class="detail-view" target="_blank">View Detail</a>
                  <ul class="btn-list">
                     <li>
                        <a href="#" class="msg-specialist">Message Admin</a>
                     </li>
                     <li>
                        <a href="#" class="msg-specialist">Message Employer</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div> -->
      </div>
</div>
@if($jobs->count())
   {{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif
