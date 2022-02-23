<div class="jobs-wrapper">
  <div class="container">
	<div class="job-inner-wrapper">
	  <div class="top-wrapper clearfix">
		<h2>Find your dream job today!</h2>
		<ul>
		  <li>
			<a href="javascript:void(0);" id="r_jobs">Recent Jobs </a>
		  </li>
		  <li>
			<a href="javascript:void(0);" id="p_jobs">Popular jobs</a>
		  </li>
		</ul>
	  </div>
		<table class="job-table" id="home_recent_jobs">
			<tr>
			  <th></th>
			  <th class="regular">Position</th>
			  <th>City</th>
			  <th class="regular">Work Type</th>
			  <th>Salary</th>
			  <th>Referral Bonus</th>
			</tr>
			@if($recent_jobs->count())
				@foreach($recent_jobs as $obj_r_job)
					<tr>
						<td class="company-logo">
							  	<a {{($obj_r_job->company)?'target="_blank"':''}} href="{{($obj_r_job->company)?route('web.company.detail',$obj_r_job->company->slug):'javascript:void(0);'}}">
							  		@php
							  			$logo_path = public_path('storage/employer/company_logo/'.$obj_r_job->company->logo);

										if(file_exists($logo_path))
										{
											$logo_path = asset('storage/employer/company_logo/'.$obj_r_job->company->logo);
										}
										else
										{
											$logo_path = asset('storage/employer/company_logo/default.png');
										}
							  		@endphp		
							  		<img src="{{$logo_path}}" alt="company-logo">
							  	</a>
						  	
						</td>
						<td class="position">
						  	<a {{($obj_r_job->slug)?'target="_blank"':''}} href="{{($obj_r_job->slug)?route('web.job_detail',$obj_r_job->slug):'javascript:void(0);'}}">
						  		{{isset($obj_r_job->position->name)?$obj_r_job->position->name:'--'}}
						  	</a>
						  	<span>
							  	@if($obj_r_job->company)
							  		{{$obj_r_job->company->company_name}}
							  	@endif
						  	</span>
						</td>
					   <td class="city">
				  		@php

				  			if($obj_r_job->cities())
				  			{
				  				$cities_arr = $obj_r_job->cities();

				  				if(count($cities_arr) > 1)
				  				{	
				  					reset($cities_arr);
				  					$cities = $cities_arr[key($cities_arr)].' , '.end($cities_arr).'..';
				  				}
				  				else
				  				{
				  					$cities = implode(',',$cities_arr);
				  				}
				  				echo $cities;
				  			}
				  		@endphp
					  </td>
					  <td class="type">
					  	@if($obj_r_job->work_type)
					  		{{$obj_r_job->work_type->name}}
					  	@endif
					  </td>
					  <td class="salary">

					  	@php
							$currency_sign = '';

							if($obj_r_job->country->currency_sign)
							{
								$currency_sign = $obj_r_job->country->currency_sign->symbol;
							}

							echo $currency_sign.number_format($obj_r_job->salary_min)." - ".$currency_sign.number_format($obj_r_job->salary_max);

					  	@endphp
					  </td>
					  	<td class="bonus">
							  <span>
							@if($obj_r_job->referral_bonus_amt)

							  @php 
								 $fromIsoCode = '';
								 $fromCurrencySign = '';
								 if($obj_r_job->country->currency_sign)
								 {
								 	$fromCurrencySign = $obj_r_job->country->currency_sign->symbol;
								 	$fromIsoCode = $obj_r_job->country->currency_sign->iso_code;
								 }

								$rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$obj_r_job->referral_bonus_amt);
								if($rateConversion)
								{
									echo $rateConversion;
								}
							 @endphp

							<!-- <span>
								{{$currency_sign.$obj_r_job->referral_bonus_amt}} -->
							</span>
							@else
							<p class="color-red">Not specified</p>
							@endif
						</td>
					</tr>
				@endforeach
			@endif
		</table>
		<table style="display: none;" class="job-table" id="home_popular_jobs">
			<tr>
			  <th></th>
			  <th class="regular">Position</th>
			  <th>City</th>
			  <th class="regular">Work Type</th>
			  <th>Salary</th>
			  <th>Referral Bonus</th>
			</tr>
			@if($popular_jobs->count())
				@foreach($popular_jobs as $obj_p_job)
					<tr>
					  <td class="company-logo">
						  	<a {{($obj_p_job->company)?'target="_blank"':''}} href="{{($obj_p_job->company)?route('web.company.detail',$obj_p_job->company->slug):'javascript:void(0);'}}">
						  	
						  		@php
						  			$logo_path = public_path('storage/employer/company_logo/'.$obj_p_job->company->logo);

									if(file_exists($logo_path))
									{
										$logo_path = asset('storage/employer/company_logo/'.$obj_p_job->company->logo);
									}
									else
									{
										$logo_path = asset('storage/employer/company_logo/default.png');
									}
						  		@endphp	
						  		<img src="{{$logo_path}}" alt="company-logo">
						  	</a>
					  	
					  </td>
					  <td class="position">
					  	
				  		<a {{($obj_p_job->slug)?'target="_blank"':''}} href="{{($obj_p_job->slug)?route('web.job_detail',$obj_p_job->slug):'javascript:void(0);'}}">
					  		{{isset($obj_p_job->position->name)?$obj_p_job->position->name:'--'}}
					  	</a>
					  <span>
					  	@if($obj_p_job->company)
					  		{{$obj_p_job->company->company_name}}
					  	@endif
					  </span>
						</td>
					  <td class="city">
				  		@php

				  			if($obj_p_job->cities())
				  			{
				  				$cities_arr = $obj_p_job->cities();

				  				if(count($cities_arr) > 1)
				  				{	
				  					reset($cities_arr);
				  					$cities = $cities_arr[key($cities_arr)].' , '.end($cities_arr).'..';
				  				}
				  				else
				  				{
				  					$cities = implode(',',$cities_arr);
				  				}
				  				echo $cities;
				  			}
				  		@endphp
					  </td>
					  <td class="type">
					  	@if($obj_p_job->work_type)
					  		{{$obj_p_job->work_type->name}}
					  	@endif
					  </td>
					  <td class="salary">

					  	@php
							$currency_sign = '';

							if($obj_p_job->country->currency_sign)
							{
								$currency_sign = $obj_p_job->country->currency_sign->symbol;
							}

							echo $currency_sign.$obj_p_job->salary_min." - ".$currency_sign.$obj_p_job->salary_max;

					  	@endphp
					  	<td class="bonus">
							@if($obj_p_job->referral_bonus_amt)
							<span>
								{{$currency_sign.$obj_p_job->referral_bonus_amt}}
							</span>
							@else
							<p class="color-red">Not specified</p>
							@endif
						</td>
					</tr>
				@endforeach
			@endif
		</table>
	  <div class="view-job-wrapper">
		<a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.companies.listing')}}',true)" class="view-jobs">View more jobs</a>
	  </div>
	</div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#r_jobs,#p_jobs').click(function(){
			if($(this).attr('id') == 'p_jobs')
			{
				$('#home_popular_jobs').show();
				$('#home_recent_jobs').hide();
			}
			else
			{
				$('#home_popular_jobs').hide();
				$('#home_recent_jobs').show();
			}
		})
	})
</script>