<div class="company-slider">
	<div class="companies-slide1">
		<ul class="companies">
			@if($companies->count())
				@foreach($companies as $index => $obj_company)
					<li>
						<a href="{{route('web.company.detail',[$obj_company->slug])}}">
							<span class="companies-img">
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
								<img src="{{$logo_path}}" alt="company-logo" class="brand-img">
							</span>
							<strong class="company-title">
								{{$obj_company->company_name}}
							</strong>
							<span class="jobs-num">
								{{number_format($obj_company->active_jobs->count())}} Jobs
							</span>
						</a>
					</li>
				@endforeach
			@else
				<li><h3 class="color-red">Data not found</h3></li>
			@endif
		</ul>
	</div>
</div>
{{ $companies->appends(request()->except('page'))->links('layouts.web.pagination') }} 
