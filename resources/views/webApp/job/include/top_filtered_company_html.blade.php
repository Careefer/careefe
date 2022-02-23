@if(count($top_job_companies) > 0)
	@foreach($top_job_companies as $company_val)
	<li>
		<label class="filter-container">{{$company_val->company_name}}
			@php
				$checked = '';
				if(isset($params['emp']) && in_array($company_val->slug,$params['emp']))
				{
					$checked = 'checked="checked"';
				}
			@endphp	
			<input {{$checked}} type="checkbox" value="{{$company_val->slug}}" name="emp[]" onchange="return apply_filter_search_job();">
			<span class="filter-checkmark"></span>
		</label>
	</li>
	@endforeach
@else
	<li>
		<label class="color-red">
			No results containing all your search terms were found.
		</label>
	</li>
@endif
		