<div class="jobs-list">
	<div class="results-wrap">
		@if($jobs->count())
			<span class="result-no">{{$record_from}}-{{$record_to}} of {{$total_records}} results</span>
			<form class="relevance-wrapper">
				<label>Sort by</label>
				<div class="relevance-inner">
					<select class="emp-job-sort-by" id="relevance" name="sort">
						<option selected="selected" value="">All</option>
						<option value="relevance" {{(isset($params['sort']) && $params['sort'] == 'relevance')?'selected="selected"':''}}>Relevance</option>
						<option value="posted-date" {{(isset($params['sort']) && $params['sort'] == 'posted-date')?'selected="selected"':''}}>Posted date</option>
						<option value="referral-amount" {{(isset($params['sort']) && $params['sort'] == 'referral-amount')?'selected="selected"':''}}>Referral amount</option>
					</select>
				</div>
			</form>
		@endif
	</div>
	
	@php
		$job_view_cutoff = site_config('display_total_job_view_after');
	@endphp

	@if($jobs->count())
		@foreach($jobs as $obj_job)
			<div class="project-job">
				<a href="{{route('web.job_detail',[$obj_job->slug])}}" target="_blank">
				<div class="top-block">
					<div class="project-details">

						<div class="left-detail left-details-icons">
							
								<h2>
									@if(isset($obj_job->position->name))
										{{$obj_job->position->name}}
									@endif
									<em>		
										@if(isset($obj_job->job_nature->title))
											@php
												$job_nature_icon = public_path('storage/job_nature_icons/'.$obj_job->job_nature->icon);
											@endphp	
												@if(file_exists($job_nature_icon))
													<img src="{{asset('storage/job_nature_icons/'.$obj_job->job_nature->icon)}}" alt="hot-job">
												@endif
											{{$obj_job->job_nature->title}}
										@endif
									</em>
								</h2>
							
							@if(isset($obj_job->company->company_name))
								<h4 class="apache-img apche-wrap">
									<img src="{{asset('assets/web/images/loc-img2.png')}}" alt="company">
									
										{{$obj_job->company->company_name}}
									
								</h4>
							@endif
							<em class="apache-img apche-wrap flag-icon"><img
							src="{{asset('assets/web/images/flag-icon.png')}}" alt="location">{{$obj_job->experience_min.'-'.$obj_job->experience_max}}
							years</em>
							<span class="apache-img apche-wrap">
								<img src="{{asset('assets/web/images/loc-img.png')}}" alt="location">
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
							<div class="fulltime-wrap">
								<strong>
								<img class="wallet-img" src="https://thesst.com/SIS554/public/assets/web/images/wallet.jpg" alt="location">
									  	@php
											$currency_sign = '';

											if($obj_job->country->currency_sign)
											{
												$currency_sign = $obj_job->country->currency_sign->symbol;
											}

											echo $currency_sign.number_format($obj_job->salary_min)." - ".$currency_sign.number_format($obj_job->salary_max);

									  	@endphp
								</strong>
								@if($obj_job->work_type)
									<span class="apache-img">
										<img src="{{asset('assets/web/images/full-time-icon.png')}}" alt="full-time">{{$obj_job->work_type->name}}
									</span>
								@endif
							</div>
						</div>
					
						<div class="right-detail right-deatils-logo">
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
							
								<img src="{{$logo_path}}" alt="">
							
							@if($obj_job->referral_bonus_amt)
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

									{{--${{$obj_job->referral_bonus_amt}}--}}
								</span>
								<em class="ref-text">Referral Bonus</em>
							@endif
						</div>
					</div>
					<h3>Summary</h3>
					@if($obj_job->summary)
						<p>{{$obj_job->summary}}</p>
					@endif
				</div>
				</a>
				<div class="bottom-block">
					@if($obj_job->total_views >= $job_view_cutoff)
						<span class="view-detail">Views:
							<strong>
								{{($obj_job->total_views)?$obj_job->total_views:0}}
							</strong>
						</span>
					@endif
					<span>Posted:
						<strong>{{time_Ago($obj_job->created_at)}}</strong>
					</span>
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
			</div>
		@endforeach
	@else
	<center><h4 class="color-red">Result not found</h4></center>
	@endif
</div>
@if($jobs->count())
	{{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif