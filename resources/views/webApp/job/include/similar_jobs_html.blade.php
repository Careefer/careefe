@if($obj_job->similar_jobs()->count())
	<h2 class="jobs-heading">Similar Jobs</h2>
	<ul class="similar-jobs-wrapper clearfix">
		@foreach($obj_job->similar_jobs()->take(4) as $c_job_obj)
		@if($obj_job->id!=$c_job_obj->id)
		<li class="shadow">
			<div class="left-detail">
				@if(isset($c_job_obj->position->name))
					<a href="{{route('web.job_detail',[$c_job_obj->slug])}}" target="_blank">
						<h3>{{$c_job_obj->position->name}}</h3>
					</a>
				@endif
				
				@if(isset($c_job_obj->company->company_name))
					<h4 class="apache-img apche-wrap">
						<img src="{{asset('assets/web/images/company.svg')}}" alt="company">
						<a target="_blank" href="{{route('web.company.detail',[$c_job_obj->company->slug])}}">
						{{$c_job_obj->company->company_name}}
						</a>
					</h4>
				@endif
				<div class="similar-inner">
					<em class="apache-img apche-wrap flag-icon"><img src="{{asset('assets/web/images/time.svg')}}" alt="location">{{$c_job_obj->experience_min.'-'.$c_job_obj->experience_max}}&nbsp&nbspyears</em>
					<span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
						<!-- cities -->
						@if($c_job_obj->cities())
                        	{{implode(', ',$c_job_obj->cities())}}
                        @endif,

                        <!-- states -->
                        @if($c_job_obj->state())
                        	<strong>{{implode(', ',$c_job_obj->state())}}</strong>
                        @endif,
							
						<!-- country -->
                        <strong>
                        	{{($c_job_obj->country)?$c_job_obj->country->name:''}}
                        </strong>
					</span>
				</div>
				<strong class="apache-img apche-wrap project-price">
					<span class="dollar-icon">
						@php
							$currency_sign = '';

							if($c_job_obj->country->currency_sign)
							{
								$currency_sign = $c_job_obj->country->currency_sign->symbol;
							}

					  	@endphp
						{{$currency_sign}}
					</span> 
					{{$c_job_obj->salary_min.'-'.$c_job_obj->salary_max}}
				</strong>
			</div>
			@if($c_job_obj->referral_bonus_amt)
			<div class="right-detail">
				<span class="ref-bonus">

					 		@php 
								 $fromIsoCode = '';
								 $fromCurrencySign = '';
								 if($c_job_obj->country->currency_sign)
								 {
								 	$fromCurrencySign = $c_job_obj->country->currency_sign->symbol;
								 	$fromIsoCode = $c_job_obj->country->currency_sign->iso_code;
								 }

								$rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$c_job_obj->referral_bonus_amt);
								if($rateConversion)
								{
									echo $rateConversion;
								}
							 @endphp

					{{--${{$c_job_obj->referral_bonus_amt}}--}}
				</span>
				<em class="ref-text">Referral Bonus</em>
			</div>
			@endif
		</li>
		@endif
		@endforeach
	</ul>
	<a href="javascript:void(0);" onclick='redirect_url($(this),"{{$similar_job_url}}",true)' class="view-link">View All</a>
@endif