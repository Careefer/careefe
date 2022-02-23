<ul class="referral-detail">
	@foreach($applications as $app)
	<li>
		<div class="ref-info">
			<span class="ref-name">{{ $app->name }}</span>
			<a href="mailto:{{ $app->email}}" class="ref-mail">{{ $app->email }}</a>
			<ul class="ref-list clearfix">
				<li>
					{{ display_date_time($app->created_at) }}
				</li>
				<li>
					via Email
				</li>
			</ul>
		</div>
		@if($job->status !== "closed")
		<a href="#" class="remind-btn button-link">Remind</a>
		@endif
	</li>
	@endforeach
	<!-- <li>
		<div class="ref-info">
			<span class="ref-name">Shyam Singh</span>
			<a href="mailto:shyam.singh@gmail.com" class="ref-mail">shyam.singh@gmail.com</a>
			<ul class="ref-list clearfix">
				<li>
					20 march, 2019
				</li>
				<li>
					via Email
				</li>
			</ul>
		</div>
		<a href="#" class="remind-btn button-link">Remind</a>
	</li> -->
</ul>
@if($applications->count())
   {{ $applications->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif