<div class="list-main-frame">
<div class="employer-inner emp-job-content">
  @if($jobs->count())
    @foreach($jobs as $key => $obj_job)
      <div class="project-job">
        <div class="top-block">
          <div class="top-main">
            <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
            <span class="pending">Job Status: <span class="pending-color">Partially fulfilled</span></span>
          </div>
          <div class="project-details">
            <div class="left-detail">
              @if($obj_job->position)
                <h3>{{$obj_job->position->name}}</h3>
              @endif
              <span class="apache-img apche-wrap flag-icon"><img src="{{asset('assets/web/images/flag-icon.png')}}" alt="location">{{$obj_job->experience_min.'-'.$obj_job->experience_max}} yrs</span>
              <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/loc-img.png')}}" alt="location">
                
                <!-- cities -->
                @if($obj_job->cities())
                  {{implode(', ',$obj_job->cities())}}
                @endif,

                <!-- states -->
                @if($obj_job->state())
                  <strong>{{implode(', ',$obj_job->state())}}</strong>
                @endif,

                <!-- country -->
                <strong>{{($obj_job->country)?$obj_job->country->name:''}}</strong>
              </span>
              <span class="basket-text basket-work">Specialist:
                <strong>
                    @if($obj_job->specialist)
                      {{ucwords($obj_job->specialist->name)}}
                    @else
                    <label class="color-red">Not specified</label> 
                    @endif
                </strong>
              </span>
              <span class="basket-text">Posted Date &amp; Time: <strong>
                  @php
                    echo date('d M, Y h:i a',strtotime($obj_job->created_at))
                  @endphp IST
              </strong></span>
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
        @php

        @endphp
        <a class="ref-button" href="{{route('employer.job.view',[$obj_job->id])}}">button</a>
      </div>                          
    @endforeach
  @else
  <center><h2 class="color-red">Data not found</h2></center>
  @endif
</div>
</div>
{{ $jobs->appends(request()->except('page'))->links('layouts.web.pagination') }}