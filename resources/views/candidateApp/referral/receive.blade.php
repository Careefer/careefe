<div class="profile-content-inner shadow">
<h2>Referrals</h2>
@include('candidateApp.referral.bank-detail.include.top_bar_html')
<div class="refer-tabs-content">
	<div id="received-content" class="refer-content receive-detail refer-current refer-common">
		@if($jobs->count())
            @foreach($jobs AS $obj_job)
			<div class="project-job">
				<div class="project-details top-desktop">
					<div class="left-detail">
						<em class="job-id">Job Id: {{$obj_job->job_id}}</em>
						<h3>{{ optional($obj_job->position)->name}}</h3>
						@if($obj_job->company->company_name)
						<h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img src="{{ asset('assets/images/loc-img2.png') }}"
						alt="company"> {{$obj_job->company->company_name}}</h4>
						@endif
						<em class="apache-img apche-wrap flag-icon"><img
						src="{{ asset('assets/images/flag-icon.png') }}" alt="location">{{$obj_job->experience_min }}  - {{$obj_job->experience_max }}
						years</em>
						<span class="apache-img apche-wrap"><img src="{{ asset('assets/images/loc-img.png') }}" alt="location">
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
								{{number_format($obj_job->salary_min) }}  - {{number_format($obj_job->salary_max) }}
							</strong>
							<ul class="ref-total">
								<li>
									Successful Referral:{{ $obj_job->candidate_referral_receive_applications->count() }}
								</li>
								<li>
									Total Referrals:{{ $obj_job->candidate_referral_sent_applications->count() }}
								</li>
							</ul>
						</div>
					</div>
					<div class="right-detail">
						@php
                         $logo_path = public_path('storage/employer/company_logo/'.$obj_job->company->logo);

                         if(file_exists($logo_path))
                         {
                            $logo_path = asset('storage/employer/company_logo/'.$obj_job->company->logo);
                         }
                         else
                         {
                            $logo_path = asset('storage/employer/company_logo/default.png');
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
							{{--$ {{ $obj_job->referral_bonus_amt }}--}}
						</span>
						<em class="ref-text">Referral Bonus</em>
					</div>
					<a class="ref-button" href="{{ route('candidate.referral-receive-detail', [$obj_job->id]) }}"> button </a>
				</div>
				<div class="project-details top-mobile">
					<div class="left-detail">
						<em class="job-id">Job Id: {{$obj_job->job_id}}</em>
						<h3>{{optional($obj_job->position)->name}}</h3>
						@if($obj_job->company->company_name)
						<h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img src="{{ asset('assets/images/loc-img2.png') }}"
						alt="company">{{$obj_job->company->company_name}}</h4>
						@endif
						<a href="#" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)"><img
						src="{{$logo_path}}" alt="project-apache"></a>
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
							<strong class="apache-img apche-wrap project-price"><span class="dollar-icon">$</span>{{$obj_job->salary_min }}  - {{$obj_job->salary_max }}</strong>
							<ul class="ref-total">
								<li>
									Successful Referral: {{ $obj_job->candidate_referral_receive_applications->count() }}
								</li>
								<li>
									Total Referrals: {{ $obj_job->candidate_referral_sent_applications->count() }}
								</li>
							</ul>
						</div>
					</div>
					<div class="right-detail">
						<span class="ref-bonus">$ {{ $obj_job->referral_bonus_amt }}</span>
						<em class="ref-text">Referral Bonus</em>
					</div>
					<a class="ref-button" href="{{ route('candidate.referral-receive-detail', [$obj_job->id]) }}"> button </a>
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