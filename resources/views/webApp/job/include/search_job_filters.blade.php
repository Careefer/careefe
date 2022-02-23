<div class="jobs-filter">
	<div class="filter-wrap">
		<span class="filter-text">Filter</span>
		<button class="reset-all button" type="button" onclick="redirect_url($(this),window.current_url,true);">
			Reset All
		</button>
	</div>
	<form name="search_job_filters_frm" id="search_job_filters_frm">
		<ul class="job-filter-inner">
			<li>
				<h4 class="filter-dropdown">Posted Date</h4>
				<div class="filter-selectbox-wrap filter-option">
					<select class="filter-selectbox job-filter-posted-date" name="p-date">
						<option value="">Select</option>
						<option value="last-1-day" {{(isset($params['p-date']) && $params['p-date'] == 'last-1-day')?'selected="selected"':''}}>Last 1 day</option>
						<option value="last-3-days" {{(isset($params['p-date']) && $params['p-date'] == 'last-3-days')?'selected="selected"':''}}>Last 3 days</option>
						<option value="last-7-days" {{(isset($params['p-date']) && $params['p-date'] == 'last-7-days')?'selected="selected"':''}}>Last 7 days</option>
						<option value="last-15-days" {{(isset($params['p-date']) && $params['p-date'] == 'last-12-days')?'selected="selected"':''}}>Last 15 days</option>
						<option value="last-30-days" {{(isset($params['p-date']) && $params['p-date'] == 'last-30-days')?'selected="selected"':''}}>Last 30 days</option>
						<option value="all" {{(isset($params['p-date']) && $params['p-date'] == 'all')?'selected="selected"':''}}>All</option>
					</select>
				</div>
			</li>
			@if($work_types->count())
				<li>
					<h4 class="filter-dropdown">Work Type</h4>
					<ul class="filter-option loc-checkbox">
						@foreach($work_types as $wt_slug => $w_val)
						<li>
							<label class="filter-container">{{$w_val}}
								@php
									$checked = '';
									if(isset($params['w-t']) && in_array($wt_slug,$params['w-t']))
									{
										$checked = 'checked="checked"';
									}
								@endphp	

								<input {{$checked}} type="checkbox" value="{{$wt_slug}}" name="w-t[]" onchange="return apply_filter_search_job();">
								<span class="filter-checkmark"></span>
							</label>
						</li>
						@endforeach
					</ul>
				</li>
			@endif
			@if($top_cities && is_array($top_cities))
			<li>
				<h4 class="filter-dropdown">Location</h4>
				<ul class="filter-option loc-checkbox">
					@foreach($top_cities as $city_slug => $city_name)
						@php
							$checked = '';
							if(isset($params['c']) && in_array($city_slug,$params['c']))
							{
								$checked = 'checked="checked"';
							}
						@endphp	
					<li>
						<label class="filter-container">{{$city_name}}
							<input {{$checked}} type="checkbox" name="c[]" onchange="return apply_filter_search_job();" value="{{$city_slug}}">
							<span class="filter-checkmark"></span>
						</label>
					</li>
					@endforeach
				</ul>
			</li>
			@endif
			<li>
				<h4 class="filter-dropdown">Referral Bonus</h4>
				<div class="filter-option range-slider-wrapper">
					<!-- <span class="bonus-value">$2L</span> -->
					@php
						$from_val = $to_val = 0;
						$max_val = $max_referral_bonus_amt;
						if(isset($params['rb']) && !empty($params['rb']))
						{	
							$rb_arr = explode('-',$params['rb']);
							$from_val = isset($rb_arr[0])?$rb_arr[0]:0;		
							$to_val = isset($rb_arr[1])?$rb_arr[1]:0;		
						}
						else
						{
							$to_val = $max_referral_bonus_amt;
						}
					@endphp
					<div id="slider-range-data" data-max-val="{{$max_val}}" data-from-val="{{$from_val}}" data-to-val="{{$to_val}}"></div>
					<div id="min-data"></div>
					<div id="max-data"></div>
				</div>
				<input type="hidden" value="{{$from_val}}-{{$to_val}}" name="rb" id="job_search_rb_filter">
			</li>
			<li>
				<h4 class="filter-dropdown">Salary</h4>
				<div class="filter-option range-slider-wrapper">
					@php
						$from_val = $to_val = 0;
						$max_val = $salary_max;
						if(isset($params['sal']) && !empty($params['sal']))
						{	
							$sal_arr = explode('-',$params['sal']);
							$from_val = isset($sal_arr[0])?$sal_arr[0]:0;		
							$to_val = isset($sal_arr[1])?$sal_arr[1]:0;		
						}
						else
						{
							$to_val = $salary_max;
						}
					@endphp	
					<div id="slider-range" data-max-val="{{$max_val}}" data-from-val="{{$from_val}}" data-to-val="{{$to_val}}"></div>
					<div id="min"></div>
					<div id="max"></div>
				</div>
				<input type="hidden" value="{{$from_val}}-{{$to_val}}" name="sal" id="job_search_sal_filter">
			</li>
			@if($designation->count())
				<li>
					<h4 class="filter-dropdown">Position</h4>
					<ul class="filter-option loc-checkbox">
						@foreach($designation as $d_slug => $d_val)
						<li>
							<label class="filter-container">{{$d_val}}
								@php
									$checked = '';
									if(isset($params['dg']) && in_array($d_slug,$params['dg']))
									{
										$checked = 'checked="checked"';
									}
								@endphp	

								<input {{$checked}} type="checkbox" value="{{$d_slug}}" name="dg[]" onchange="return apply_filter_search_job();">
								<span class="filter-checkmark"></span>
							</label>
						</li>
						@endforeach
					</ul>
				</li>
			@endif
			<li>
				<h4 class="filter-dropdown">Experience</h4>
				<div class="filter-option range-slider-wrapper">
					@php
						$from_val = 0; 
						$to_val = 30;

						if(isset($params['exp']) && !empty($params['exp']))
						{	
							$exp_arr = explode('-',$params['exp']);
							$from_val = isset($exp_arr[0])?$exp_arr[0]:0;		
							$to_val = isset($exp_arr[1])?$exp_arr[1]:0;		
						}
					@endphp 
					<div id="experience-range-slider" data-max-val="60000" data-from-val="0" data-to-val="30"></div>
					  <div id="exp-min">0</div>
					  <div id="exp-max">30</div>
				</div>
				<input type="hidden" value="{{$from_val}}-{{$to_val}}" name="exp" id="job_search_exp_filter">
			</li>
			@if($skills->count())
				<li>
					<h4 class="filter-dropdown">Skills</h4>
					<ul class="filter-option loc-checkbox">
						@foreach($skills as $skill_slug => $skill_name)
						<li>
							<label class="filter-container">{{$skill_name}}
								@php
									$checked = '';
									if(isset($params['sk']) && in_array($skill_slug,$params['sk']))
									{
										$checked = 'checked="checked"';
									}
								@endphp	

								<input {{$checked}} type="checkbox" value="{{$skill_slug}}" name="sk[]" onchange="return apply_filter_search_job();">
								<span class="filter-checkmark"></span>
							</label>
						</li>
						@endforeach
					</ul>
				</li>
			@endif
			
			@if($educations->count())
				<li>
					<h4 class="filter-dropdown">Education</h4>
					<ul class="filter-option loc-checkbox">
						@foreach($educations as $edu_slug => $edu_name)
						<li>
							<label class="filter-container">{{$edu_name}}
								@php
									$checked = '';
									if(isset($params['edu']) && in_array($edu_slug,$params['edu']))
									{
										$checked = 'checked="checked"';
									}
								@endphp	

								<input {{$checked}} type="checkbox" value="{{$edu_slug}}" name="edu[]" onchange="return apply_filter_search_job();">
								<span class="filter-checkmark"></span>
							</label>
						</li>
						@endforeach
					</ul>
				</li>
			@endif
			
			@if($industries->count())
				<li>
					<h4 class="filter-dropdown">Industry</h4>
					<ul class="filter-option loc-checkbox">
						@foreach($industries as $ind_slug => $ind_name)
						<li>
							<label class="filter-container">{{$ind_name}}
								@php
									$checked = '';
									if(isset($params['ind']) && in_array($ind_slug,$params['ind']))
									{
										$checked = 'checked="checked"';
									}
								@endphp	

								<input {{$checked}} type="checkbox" value="{{$ind_slug}}" name="ind[]" onchange="return apply_filter_search_job();">
								<span class="filter-checkmark"></span>
							</label>
						</li>
						@endforeach
					</ul>
				</li>
			@endif

			<li>
				<h4 class="filter-dropdown">Company</h4>
				<ul class="filter-option loc-checkbox">
					<div id="top-company-wrap">
						@include('webApp.job.include.top_filtered_company_html')
					</div>
				</ul>
			</li>
		</ul>
	</form>
</div>