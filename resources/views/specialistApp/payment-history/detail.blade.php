@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
         	<div class="profile-content profile-current referrals referrals-sent" id="referral-tab">
         		<div class="profile-content-inner shadow">
					<div class="btn-back">
						@if($type=='specialist-payment')
						<a href="{{ route('specialist.specialist-payment') }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
						@elseif($type=='referal-payment')
						<a href="{{ route('specialist.referral-payment') }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
						@endif
					</div>
					<div class="refer-tabs-content">
						<div id="sent-content" class="refer-content refer-current refer-common payment-detail-spe">
							<div class="project-job detail-history">
								<div class="project-job-inner">
									<div class="pay-top">
										<div class="project-details top-desktop">
											<div class="left-detail">
												<em class="job-id">Job Id: {{ $job->job_id}}</em>
												<h3>{{optional($job->position)->name}}</h3>
												@if($job->company->company_name)
												<h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$job->company->slug])}}',null,true)"><img src="{{ asset('assets/images/loc-img2.png') }}"
												alt="company">{{ $job->company->company_name }}</h4>
												@endif
												<em class="apache-img apche-wrap flag-icon"><img
												src="{{ asset('assets/images/flag-icon.png') }}" alt="location">{{$job->experience_min }}  - {{$job->experience_max }}
												years</em>
												<span class="apache-img apche-wrap"><img src="{{ asset('assets/images/loc-img.png') }}"
													alt="location">
													<!-- cities -->
							                     @if($job->cities())
							                        {{implode(', ',$job->cities())}}
							                     @endif,

							                     <!-- states -->
							                     @if($job->state())
							                        <strong>{{implode(', ',$job->state())}}</strong>
							                     @endif,

							                     <!-- country -->
							                     <strong>
							                        {{($job->country)?$job->country->name:''}}
							                     </strong>
												</span>
												<div class="sent-referral-wrap">
													<strong class="apache-img apche-wrap project-price">
														@php
															$currency_sign = '';

															if($job->country->currency_sign)
															{
																$currency_sign = $job->country->currency_sign->symbol;
															}

														@endphp
														<span class="dollar-icon">{{$currency_sign}}</span> {{$job->salary_min }}  - {{$job->salary_max }} </strong>
													@if($type == 'specialist-payment')
													<ul class="ref-total">
														<li>
															Successful Hires : {{ $job->specialist_referral_recevie()}}
														</li>
														<li>
															Applications Recommended :{{ $job->specialist_referral_sent()}}
														</li>
													</ul>
													@elseif($type == 'referal-payment')
													<ul class="ref-total">
														<li>
															Successful Hires : {{ $job->referre_referral_sent_applications->count() }}
														</li>
														<li>
															Applications Recommended :{{ $job->referre_referral_receive_applications->count()}}
														</li>
													</ul>
													@endif
												</div>
											</div>
											<div class="right-detail">
												@php
						                         $logo_path = public_path('storage/employer_logos/'.$job->company->logo);

						                         if(file_exists($logo_path))
						                         {
						                            $logo_path = asset('storage/employer_logos/'.$job->company->logo);
						                         }
						                         else
						                         {
						                            $logo_path = asset('storage/employer_logos/default.png');
						                         }
						                        @endphp

												<a href="#" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$job->company->slug])}}',null,true)"><img
												src="{{$logo_path}}" alt="project-apache"></a>
												@if($type == 'specialist-payment')
												<span class="ref-bonus">$ {{ $job->specialist_bonus_amt}}</span>
												@elseif($type == 'referal-payment')
												<span class="ref-bonus">
														@php 
														 $fromIsoCode = '';
														 $fromCurrencySign = '';
														 if($job->country->currency_sign)
														 {
														 	$fromCurrencySign = $job->country->currency_sign->symbol;
														 	$fromIsoCode = $job->country->currency_sign->iso_code;
														 }

														$rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$job->referral_bonus_amt);
														if($rateConversion)
														{
															echo $rateConversion;
														}
													 @endphp
													{{--$ {{ $job->referral_bonus_amt}}--}}
												</span>
												@endif
												<em class="ref-text">Referral Bonus</em>
											</div>
										</div>
										<div class="project-details top-mobile">
											<div class="left-detail">
												<em class="job-id">Job Id: {{ $job->job_id}}</em>
												<h3>{{optional($job->position)->name}}</h3>
												@if($job->company->company_name)
												<h4 class="apache-img apche-wrap" onclick="redirect_url($(this),'{{route('web.company.detail',[$job->company->slug])}}',null,true)"><img src="{{ asset('assets/images/loc-img2.png') }}"
												alt="company">{{ $job->company->company_name }}</h4>
												@endif
												<a href="#" class="project-logo"><img
												src="{{ asset('assets/images/project-apache.png') }}" alt="project-apache"></a>
												<em class="apache-img apche-wrap flag-icon"><img
												src="{{ asset('assets/images/flag-icon.png') }}" alt="location">{{$job->experience_min }}  - {{$job->experience_max }} years</em>
												<span class="apache-img apche-wrap"><img src="{{ asset('assets/images/loc-img.png') }}"
													alt="location">
													<!-- cities -->
							                     @if($job->cities())
							                        {{implode(', ',$job->cities())}}
							                     @endif,

							                     <!-- states -->
							                     @if($job->state())
							                        <strong>{{implode(', ',$job->state())}}</strong>
							                     @endif,

							                     <!-- country -->
							                     <strong>
							                        {{($job->country)?$job->country->name:''}}
							                     </strong>
												</span>
												<div class="sent-referral-wrap">
													<strong class="apache-img apche-wrap project-price">
														@php
															$currency_sign = '';

															if($job->country->currency_sign)
															{
																$currency_sign = $job->country->currency_sign->symbol;
															}

														@endphp
														<span class="dollar-icon">{{$currency_sign }}</span> {{$job->salary_min }}  - {{$job->salary_max }}
													</strong>
														@if($type == 'specialist-payment')
														<ul class="ref-total">
														<li>
															Successful Hires : {{ $job->specialist_referral_recevie()}}
														</li>
														<li>
															Applications Recommended :{{ $job->specialist_referral_sent()}}
														</li>
													</ul>
													@elseif($type == 'referal-payment')
													<ul class="ref-total">
														<li>
															Successful Hires : {{ $job->referre_referral_sent_applications->count() }}
														</li>
														<li>
															Applications Recommended :{{ $job->referre_referral_receive_applications->count()}}
														</li>
													</ul>
													@endif
												</div>
											</div>
											<div class="right-detail">
												@if($type == 'specialist-payment')
												<span class="ref-bonus">$ {{ $job->specialist_bonus_amt}}</span>
												@elseif($type == 'referal-payment')
												<span class="ref-bonus">
													@php 
														 $fromIsoCode = '';
														 $fromCurrencySign = '';
														 if($job->country->currency_sign)
														 {
														 	$fromCurrencySign = $job->country->currency_sign->symbol;
														 	$fromIsoCode = $job->country->currency_sign->iso_code;
														 }

														$rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$job->referral_bonus_amt);
														if($rateConversion)
														{
															echo $rateConversion;
														}
													 @endphp
													{{--$ {{ $job->referral_bonus_amt}}--}}
												</span>
												@endif
												<em class="ref-text">Referral Bonus</em>
											</div>
										</div>
									</div>
									<div class="pay-bottom">
										<ul class="pay-list">
											@if($type=='specialist-payment')
											<li>
												<span>Total Paid:</span><strong>$ {{ $job->getSpecialistTotalPayment() }}</strong>
											</li>
											<li>
												<span>Total Outstanding:</span><strong>$ {{ $job->getSpecialistOutstandingPayment() }}</strong>
											</li>
											@elseif($type=='referal-payment')
											<li>
												<span>Total Paid:</span><strong>$ {{ $job->getReferreSpecialistTotalPayment() }}</strong>
											</li>
											<li>
												<span>Total Outstanding:</span><strong>$ {{ $job->getReferreSpecialistOutstandingPayment() }}</strong>
											</li>

											@endif
										</ul>
									</div>
								</div>
								@php 
						          $sortBy = ["recency"=> "Recent", "alphabetical"=>"Alphabetical"];
						          @endphp 
								<div class="sort-option clearfix">
									<select class="sort-selectbox" id="sorting" name="sorting">
										<option value="">Sort</option>
										@foreach($sortBy as $key=> $val)
							            @php
							               $selected = '';
							               if(isset($filter_data) && $filter_data == $key)
							               {
							                 $selected = 'selected="selected"';
							               }
							            @endphp    
							            <option {{$selected}} value="{{ $key }}"> {{ $val }}</option>
							            @endforeach
									</select>
								</div>
								<div class="spc-job-ajax-render-section">
								@include('specialistApp.payment-history.include.application_card')
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		  </div>
        </div>
     </div>
</div>
<form class="app-form list-form" id="filters" method="GET">
		<input type="hidden" name="sortby" value="" id="input-sort">
</form>	
<div class="bottom-image">
   Image
</div>
@push('script')
<script type="text/javascript">
	$('#sorting').on('selectmenuchange', function() {
   	 var sortBy = $("select[name='sorting']").val();
   	 if(sortBy){
   	 	$('#input-sort').val(sortBy);
   	 	$('#filters').submit();	
   	 }
	});
</script>
@endpush
@endsection
