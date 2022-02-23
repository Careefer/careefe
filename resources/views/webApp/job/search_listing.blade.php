@extends('layouts.web.web')
@section('title','Job Listing')
@section('page-class','job-list-wrap')
@section('content')
	<div class="list-job-wrap">
		<div class="container">
			<h1>Jobs</h1>
			<div class="jobs-top-wrapper clearfix">
				<div class="job-form">
			     	@include('webApp.partials.job_search_form')
			     	@include('webApp.partials.create_job_alert_form')
				</div>
			     @include('webApp.partials.recently_searched')
			</div>
			<div class="jobs-main clearfix">
				@include('webApp.job.include.search_job_filters')
				<div class="job-top-wrap">
					<div class="ajax-search-job-html-bind">
						@include('webApp.job.include.search_job_html')
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="bottom-image">
		Image
	</div>

	@php
		$k  = $f = $l = '';
		if(isset($params['k']) && !empty($params['k']))
		{
			$k = $params['k'];
		}
		if(isset($params['f']) && !empty($params['f']))
		{	
			$arr['f'] = $params['f'];
			$f = http_build_query($arr);
		}
		if(isset($params['l']) && !empty($params['l']))
		{
			$l = $params['l'];
		}

	@endphp


	@push('js')
	<script type="text/javascript">
			var current_url = "{{route('web.job.search.listing')}}?k={{$k}}&{{$f}}&l={{$l}}";
	</script>>
	@endpush
@endsection
