<div class="job-content-inner shadow">
  <h2>Referrals</h2>
  <ul class="refer-tabs-list job-tabs-list clearfix">
    <li data-tab="spe-sent" class="referral-list"  onclick="redirect_url($(this),'{{route('specialist.referral-section', 'sent')}}',true)">
      Referrals Sent
    </li>
    <li data-tab="spe-receive" class="referral-list referral-current"  onclick="redirect_url($(this),'{{route('specialist.referral-section', 'recevied')}}',true)">
      Referrals Received
    </li>
  </ul>
  <div class="refer-tabs-content">
    <div id="spe-receive" class="referral-content refer-common referral-current">
        @if($jobs->count())
            @foreach($jobs AS $obj_job)
               @php
                  $obj_job = $obj_job->job;
               @endphp
              <div class="project-job">
                <div class="project-details top-desktop">
                  <div class="left-detail">
                    <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
                    <h3>{{optional($obj_job->position)->name}}</h3>
                    @if($obj_job->company->company_name)
                    <h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img src="{{ asset('assets/images/loc-img2.png') }}"
                    alt="company">{{$obj_job->company->company_name}}</h4>
                    @endif
                    <em class="apache-img apche-wrap flag-icon"><img
                    src="{{ asset('assets/images/flag-icon.png') }}" alt="location">{{$obj_job->experience_min }}  - {{$obj_job->experience_max }}
                    years</em>
                    <span class="apache-img apche-wrap"><img src="{{ asset('assets/images/loc-img.png') }}"
                      alt="location">
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
                    <div class="sent-referral-wrap">
                      <strong class="apache-img apche-wrap project-price">
                        @php
                          $currency_sign = '';

                          if($obj_job->country->currency_sign)
                          {
                            $currency_sign = $obj_job->country->currency_sign->symbol;
                          }

                        @endphp
                        <span class="dollar-icon">{{$currency_sign}}</span> 
                        {{$obj_job->salary_min }}  - {{$obj_job->salary_max }} 
                      </strong>
                      <ul class="ref-total">
                        <li>
                          Successful Referrals:{{ $obj_job->specialist_referral_recevie()}}
                        </li>
                        <li>
                          Total Referrals:{{ $obj_job->specialist_referral_sent()}}
                        </li>
                      </ul>
                    </div>
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
                            $logo_path = asset('storage/employer_logos/default.png');
                         }
                      @endphp
                    <a href="#" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img
                    src="{{$logo_path}}" alt="project-apache"></a>
                    <span class="ref-bonus">
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
                        {{--$20--}}
                    </span>
                    <em class="ref-text">Referral Bonus</em>
                  </div>
                  <a class="ref-button" href="{{ route('specialist.referral-receive-detail', [$obj_job->id]) }}"> button </a>
                </div>
                <div class="project-details top-mobile">
                  <div class="left-detail">
                    <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
                    <h3>{{optional($obj_job->position)->name}}</h3>
                    @if($obj_job->company->company_name)
                    <h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img src="{{ asset('assets/images/loc-img2.png') }}"
                    alt="company">{{$obj_job->company->company_name}}</h4>
                    @endif
                    <a href="#" class="project-logo"><img
                    src="{{ asset('assets/images/project-apache.png') }}" alt="project-apache"></a>
                    <em class="apache-img apche-wrap flag-icon"><img
                    src="assets/images/flag-icon.png" alt="location">{{$obj_job->experience_min }}  - {{$obj_job->experience_max }}
                    years</em>
                    <span class="apache-img apche-wrap"><img src="{{ asset('assets/images/loc-img.png') }}"
                      alt="location">
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
                    <div class="sent-referral-wrap">
                      <strong class="apache-img apche-wrap project-price">
                        @php
                          $currency_sign = '';

                          if($obj_job->country->currency_sign)
                          {
                            $currency_sign = $obj_job->country->currency_sign->symbol;
                          }

                        @endphp
                        <span class="dollar-icon">{{$currency_sign }}</span> 
                        {{$obj_job->salary_min }}  - {{$obj_job->salary_max }}</strong>
                      <ul class="ref-total">
                        <li>
                          Successful Referrals:2
                        </li>
                        <li>
                          Total Referrals:2
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="right-detail">
                    <span class="ref-bonus">
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
                      {{-- $20--}}
                    </span>
                    <em class="ref-text">Referral Bonus</em>
                  </div>
                  <a class="ref-button" href="{{ route('specialist.referral-receive-detail', [$obj_job->id]) }}"> button </a>
                </div>
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