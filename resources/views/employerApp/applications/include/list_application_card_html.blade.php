<div class="job-content-inner shadow">
      <div class="application-tabs-content">
          <div id="emp-active" class="employer-content employer-current dashboard-main apps-wrapper">
            <div class="employer-inner">
                 @if($jobs->count())
                 @foreach($jobs AS $obj_job)
                      <div class="project-job">
                        <div class="project-details">
                          <div class="left-detail">
                            <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
                            <h3>{{ optional($obj_job->position)->name}}</h3>
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
                            <span class="basket-text basket-work">Specialist assigned: <strong>{{ @$obj_job->specialist->name }}</strong></span>
                            <span class="basket-text basket-vac">Number of applications: <strong>{{ $obj_job->applications() }}</strong></span>
                            <span class="basket-text">Posted date: <strong>{{display_date_time($obj_job->created_at)}}</strong></span>
                          </div>
                          <div class="right-detail">
                            @php
                               $empId =  my_id();
                               $room_data = ['jobId'=>$obj_job->id,'spcId'=>$obj_job->primary_specialist_id,'empId'=>$empId];
                               $roomId =  base64_encode(json_encode($room_data));
                            @endphp
                            <a href="{{url('employer/chat/'.$roomId)}}" class="msg-specialist">Message Specialist</a>
                          </div>
                          <a class="ref-button" href="{{ route('employer.application.detail', [$obj_job->slug])}}"> button </a>
                        </div>
                      </div>
                 @endforeach
                 @else
                 {!! record_not_found_msg() !!}
                 @endif     
            </div>
          </div>
        </div>    
</div>
@if($jobs->count())
{{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif