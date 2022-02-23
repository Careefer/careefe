<div class="profile-content profile-current referrals referrals-sent" id="referral-tab">
	<div class="profile-content-inner shadow">
		@if($page == 'sent-detail')
		<div class="btn-back">
			<a href="{{ route('specialist.referral-section', ['sent']) }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
		</div>
		@elseif($page == 'receive-detail')
		<div class="btn-back">
			<a href="{{ route('specialist.referral-section', ['received']) }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
		</div>
		@endif
		<div class="refer-tabs-content">
			<div id="sent-content" class="refer-content refer-current refer-common">
				<div class="project-job">
					<div class="project-outer clearfix">
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
										<span class="dollar-icon">{{$currency_sign}}</span>
										{{$job->salary_min }}  - {{$job->salary_max }} 
									</strong>
									@if($page == 'sent-detail')	
									<span class="ref-no">Referral Sent: {{ $job->specialist_referral_sent()}}</span>
									@elseif($page == 'receive-detail')
									<ul class="ref-total">
										<li>
											Successful Referral:{{ $job->specialist_referral_recevie()}}
										</li>
										<li>
											Total Referrals:{{ $job->specialist_referral_sent()}}
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
									{{--$20--}}
								</span>
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
										<span class="dollar-icon">{{$currency_sign}}</span> 
										{{$job->salary_min }}  - {{$job->salary_max }}
									</strong>
									@if($page == 'sent-detail')	
									<span class="ref-no">Referral Sent: {{ $job->specialist_referral_sent()}}</span>
									@elseif($page == 'receive-detail')
									<ul class="ref-total">
										<li>
											Successful Referrals:{{ $job->specialist_referral_recevie()}}
										</li>
										<li>
											Total Referrals:{{ $job->specialist_referral_sent()}}
										</li>
									</ul>
									@endif
								</div>
							</div>
							<div class="right-detail">
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
									{{--$20--}}
								</span>
								<em class="ref-text">Referral Bonus</em>
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
						@if($page == 'sent-detail')	
						@include('specialistApp.referral-detail.include.application_card')
						@elseif($page == 'receive-detail')
						@include('specialistApp.referral-detail.include.application_receive_card')
						@endif
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<form class="app-form list-form" id="filters" method="GET">
		<input type="hidden" name="sortby" value="" id="input-sort">
	</form>	

	<!-- <ul class="pagination-wrapper inner-pagination">
		<li class="prev-btn page-btn">
			<a href="#">Previous button</a>
		</li>
		<li>
			<a href="#">1</a>
		</li>
		<li class="active">
			<a href="#">2</a>
		</li>
		<li>
			<a href="#">3</a>
		</li>
		<li class="pagination-dot">
			<span>...</span>
		</li>
		<li class="pagination-hide">
			<a href="#">4</a>
		</li>
		<li class="pagination-hide">
			<a href="#">5</a>
		</li>
		<li class="pagination-hide">
			<a href="#">6</a>
		</li>
		<li class="pagination-hide">
			<a href="#">7</a>
		</li>
		<li class="pagination-hide">
			<a href="#">8</a>
		</li>
		<li class="pagination-hide">
			<a href="#">9</a>
		</li>
		<li>
			<a href="#">10</a>
		</li>
		<li class="next-btn page-btn">
			<a href="#">Next button</a>
		</li>
	</ul> -->
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