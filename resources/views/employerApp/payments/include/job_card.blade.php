@if($jobs->count())
@foreach($jobs AS $obj_job)
<div class="project-job">
	<div class="pay-top">
		<div class="top-block">
			<div class="top-main">
				<em class="job-id">Job Id: {{$obj_job->job_id}}</em>
				<span class="pending">Status: <span class="pending-color"> {{ $obj_job->status }}</span></span>
			</div>
			<div class="project-details">
				<div class="left-detail">
					<h3>{{optional($obj_job->position)->name}}</h3>
					<span class="basket-text">
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
					<span class="basket-text basket-work">Specialist: <strong> {{ (@$obj_job->primary_specialist ? $obj_job->primary_specialist->name : (@$obj_job->secondary_specialist ? $obj_job->secondary_specialist->name: ''))}}</strong></span>
					<span class="basket-text">Posted Date &amp; Time: <strong>{{ display_date_time($obj_job->created_at) }}</strong></span>

				</div>
				<div class="right-detail">
					@php
					   $empId =  my_id();
					   $room_data = ['jobId'=>$obj_job->id,'spcId'=>$obj_job->primary_specialist_id,'empId'=>$empId];
					   $roomId =  base64_encode(json_encode($room_data));
					@endphp
					<a href="{{url('employer/chat/'.$roomId)}}" class="msg-specialist">Message Specialist</a>
				</div>

			</div>
		</div>
		<a class="ref-button" href="{{ route('employer.payment-detail', [$obj_job->id]) }}"> button </a>
	</div>
	<div class="pay-bottom">
		<span class="hired">Total Hired: <strong>{{ $obj_job->emp_total_hired()}}</strong></span>
		<ul class="pay-list">
			<li>
				<span>Total Paid:</span><strong>$ {{$obj_job->employerTotalPayment()}}</strong>
			</li>
			<li>
				<span>Total Outstanding:</span><strong>$ {{$obj_job->employerOutstandingPayment()}}</strong>
			</li>
		</ul>
	</div>
</div>
@endforeach
@else
{!! record_not_found_msg() !!}
@endif    
@if($jobs->count())
{{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif