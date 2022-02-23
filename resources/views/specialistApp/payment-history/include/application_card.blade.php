<ul class="referral-detail ref-detail-sent">
	@foreach($applications as $app)
	<li>
		<div class="application-wrapper clearfix">
			<em class="app-id">Application Id: {{ $app->application_id}}</em>
			<span class="app-status">Application Status: <span class="success-text">{{ $app->status }}</span></span>
		</div>
		<div class="ref-info">
			<span class="ref-name">{{ $app->name }}</span>
			<a href="mailto:{{ $app->email }}" class="ref-mail">{{ $app->email }}</a>
			<ul class="ref-list clearfix">
				<li>
					{{ display_date_time($app->created_at) }}
				</li>
				<li>
					via Email
				</li>
				<li>
					{{ (@$app->candidate->current_location) ? $app->candidate->get_location_by_id($app->candidate->current_location->location_id)->location : '--' }}
				</li>
			</ul>
			<div class="payment-status clearfix">
				<span class="pending">Payment: <span class="pending-color">
					@if($type == 'specialist-payment')
						{{ $app->specialistIsPayment->payment_status }}		
					@elseif($type == 'referal-payment')
						{{ $app->refereSpecialistIsPayment->payment_status }}
					@endif
				</span></span>
			</div>
			<ul class="application-btn">
				<li class="msg-admin">
					@php
					   $spcId =  my_id();
					   $room_data = ['jobId'=>$job->id,'appId'=>$app->id,'adminId'=>'1','spcId'=>$spcId];
					   $roomId =  base64_encode(json_encode($room_data));
					@endphp
					<a href="{{url('specialist/chat/'.$roomId)}}" class="button-link">Message Admin</a>
				</li>
				<li class="due-bal">
					@if($type == 'specialist-payment')
						{{ $app->specialistIsPayment->payment_status_label}} : ${{ $app->specialistIsPayment->amount}}
					@elseif($type == 'referal-payment')
						{{ $app->refereSpecialistIsPayment->payment_status_label}} : ${{ $app->refereSpecialistIsPayment->amount}}
					@endif
				</li>
			</ul>
		</div>
	</li>
	@endforeach
</ul>
@if($applications->count())
   {{ $applications->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif