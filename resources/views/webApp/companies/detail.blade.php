@extends('layouts.web.web')
@section('title','Company Detail')
@section('content')
	<div class="company-detail-wrapper">
		<div class="container">
			<div class="details-wrapper">
				<div class="detail-left-wrapper">
					<span class="cmp-logo">
						@php
							$logo_path = public_path('storage/employer/company_logo/'.$obj_company->logo);

							if(file_exists($logo_path))
							{
								$logo_path = asset('storage/employer/company_logo/'.$obj_company->logo);
							}
							else
							{
								$logo_path = asset('storage/employer/company_logo/default.png');
							}
						@endphp
						<img src="{{$logo_path}}" alt="apache">
					</span>
					<span class="emp-number">{{$obj_company->employees->count()}} Employees</span>
				</div>
				<div class="detail-right-wrapper">
					<div class="company-detail">
						@if($obj_company->active_jobs->count())
							<a href="javascript:void(0);" class="active-jobs">	 							{{number_format($obj_company->active_jobs->count())}} Active Jobs
							</a>
						@endif
						<h2>{{$obj_company->company_name}}</h2>
						<span class="company-type apache"><img src="{{asset('assets/web/images/it.svg')}}" alt="company">								{{$obj_company->industry->name}}
						</span>
						<span class="company-loc apache">
							<img src="{{asset('assets/web/images/country.svg')}}" alt="country">
								@if($obj_company->head_office)
									{{$obj_company->head_office->location}}
								@else
								<p class="color-red">Not specified</p>		
								@endif
						</span>
						<span class="company-location apache">
							<img src="{{asset('assets/web/images/location.svg')}}" alt="location">
							@if($obj_company->branch_locations()->count())
								{{implode('; ',$obj_company->branch_locations()->toarray())}}
							@endif
						</span>
						<span class="company-website apache">
							<img src="{{asset('assets/web/images/globe.svg')}}" alt="website">
								@if($obj_company->website_url)
									<a href="{{$obj_company->website_url}}" target="_blank">
										{{$obj_company->website_url}}
									</a>
								@else
									<p class="color-red">Not specified</p>
								@endif
						</span>
					</div>
					<h3>About Company</h3>
					<p>
						@if($obj_company->about_company)
							{{$obj_company->about_company}}
						@else
							<p class="color-red">Not specified</p>
						@endif
					</p>
				</div>
			</div>
			<div class="job-outer-wrapper" id="active-job-link">

				<div class="active-jobs-wrapper">
					<h2>Active Jobs</h2>
					<table class="active-job-table job-table">
						<tr>
							<th class="regular">Position</th>
							<th>City</th>
							<th class="regular">Work Type</th>
							<th>Salary</th>
							<th>Referral Bonus</th>
						</tr>
						@if($obj_company->active_jobs->count())

							@foreach($obj_company->active_jobs->take(10) as $obj_job)
								<tr>
									<td class="position">
										<a {{($obj_job->slug)?'target="_blank"':''}} href="{{($obj_job->slug)?route('web.job_detail',$obj_job->slug):'javascript:void(0);'}}">
											@if($obj_job->position)
												{{$obj_job->position->name}}
											@else
												<p class="color-red">Not specified</p>
											@endif
										</a>
									</td>
									<td class="city">
										@if($obj_job->cities())
			                            	{{implode(', ',$obj_job->cities())}}
										@else
											<p class="color-red">Not specified</p>
			                          	@endif
									</td>
									<td class="type">
										@if($obj_job->work_type)
											{{$obj_job->work_type->name}}
										@else
											<p class="color-red">Not specified</p>
										@endif
									</td>
									<td class="salary">
										@php
											$currency_sign = '';

											if($obj_job->country->currency_sign)
											{
												$currency_sign = $obj_job->country->currency_sign->symbol;
											}

										@endphp
										{{$currency_sign.number_format($obj_job->salary_min)}}-
										{{$currency_sign.number_format($obj_job->salary_max)}}
									</td>
									<td class="bonus">
										@if($obj_job->referral_bonus_amt)
										<span>

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


											{{--{{$currency_sign.$obj_job->referral_bonus_amt}}--}}
										</span>
										@else
										<p class="color-red">Not specified</p>
										@endif
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5">
									<center>
										<p class="color-red">Data not found.!!</p>
									</center>
								</td>
							</tr>
						@endif
					</table>
					<div class="view-job-wrapper">
						<a href="javascript:void(0);"  onclick="redirect_url($(this),'{{route('web.companies.listing')}}',true)" class="view-jobs">View more jobs</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom-image">
		Image
	</div>
@endsection