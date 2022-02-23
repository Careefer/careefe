@extends('layouts.web.web')
@section('content')
    @php
      $currency_sign = '';

      if($obj_job->country->currency_sign)
      {
        $currency_sign = $obj_job->country->currency_sign->symbol;
      }
    @endphp
    <div class="dashboard-wrapper employer-main">
      <div class="container">
        <h1 class="heading-tab">My Account</h1>
        <div class="main-tab-wrapper clearfix">
          @include('layouts.web.left_menue')
          <div class="main-tabs-content">
            <div class="emp-content emp-current shadow emp-view-job dashboard-main apps-wrapper" id="emp-jobs">
              <div class="top-content">
                <div class="btn-back">
                  <a href="javascript:void(0);" onclick="redirect_url($(this),'{{ route('employer.job.listing') }}',true);"><img src="{{asset('assets/web/images/back-btn.png')}}" alt="back">Back</a>
                </div>
                <button class="edit-btn button" type="button" onclick="redirect_url($(this),'{{ route('employer.job.edit',[$obj_job->id]) }}');">
                  <img src="{{asset('assets/web/images/edit-icon.png')}}" alt="edit">Edit
                </button>
              </div>
                <div class="form-msg">
                  @if(session('success'))
                    <h4 class="success_msg">{{session('success')}}</h4>
                  @endif
                </div>
              <div class="emp-job-content">
                <div class="project-job">
                  <div class="top-main">
                    <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
                    <span class="pending">Job Status:

                        @php
                          $color_class = 'color-red';
                          if($obj_job->status == 'active')
                          {
                            $color_class = 'color-green';
                          }
                          elseif($obj_job->status == 'on_hold')
                          {
                            $color_class = 'color-orange';
                          }
                        @endphp
                    
                        <span class="pending-color {{$color_class}}">
                            {{ucwords(str_replace('_',' ',$obj_job->status))}}
                        </span>
                    </span>
                  </div>
                  <div class="project-details">
                    <div class="left-detail">
                      <h3>{{$obj_job->summary}}</h3>
                      <span class="apache-img apche-wrap flag-icon"><img src="{{asset('assets/web/images/flag-icon.png')}}" alt="location">{{$obj_job->experience_min.'-'.$obj_job->experience_max}} yrs</span>
                      <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                          <!-- cities -->
                          @if($obj_job->cities())
                            {{implode(',',$obj_job->cities())}}
                          @endif,

                          <!-- states -->
                          @if($obj_job->state())
                            {{implode(',',$obj_job->state())}}
                          @endif,

                          <!-- country -->
                          {{($obj_job->country)?$obj_job->country->name:''}}
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
                      <div class="sent-referral-wrap">
                        <span class="basket-text">Posted Date &amp; Time: <strong>
                            @php
                              echo date('d M, Y h:i a',strtotime($obj_job->created_at))
                            @endphp IST
                        </strong></span>
                        <span class="basket-text">Views: <strong>{{($obj_job->total_views)?$obj_job->total_views:0}}</strong></span>
                      </div>
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
                <div class="detail-job">
                  <h4>Comments from Careefer Admin</h4>
                  <p>
                    This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, , nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum gravida nibh vel velit auctor aliquet.
                  </p>
                  <h4>Job Summary</h4>
                  <p>
                    {{$obj_job->summary}}
                  </p>
                  <h4>Job Description</h4>
                  <p>
                    {{$obj_job->description}}
                  </p>
                  <ul class="job-view-list">
                    <li class="clearfix">
                      <strong class="job-left">No. of Vacancies</strong><span class="job-right">{{$obj_job->vacancy}}</span>
                    </li>
                    <li class="clearfix">
                      <strong class="job-left">Salary</strong><span class="job-right"><span class="job-dollar">{{$currency_sign}}</span>{{number_format($obj_job->salary_min)}} &nbsp;-&nbsp; <span class="job-dollar">{{$currency_sign}}</span>{{number_format($obj_job->salary_max)}}</span>
                    </li>
                    <li class="clearfix">
                      <strong class="job-left">Commission</strong>
                      <span class="job-right">
                        @php
                          $amount = '';
                          if($obj_job->commission_type == 'amount')
                          {
                            $amount.=$currency_sign;
                          }

                          $amount .= $obj_job->commission_amt;

                          if($obj_job->commission_type == 'percentage')
                          {
                            $amount.='%';                            
                          }
                          echo $amount;
                        @endphp
                      </span>
                    </li>
                    <li class="clearfix">
                      <strong class="job-left">Work Type</strong><span class="job-right">{{($obj_job->work_type)?$obj_job->work_type->name:'Not specified'}}</span>
                    </li>
                    <li class="clearfix">
                      <strong class="job-left">Skills</strong><span class="job-right">
                        @if($obj_job->skills())
                          {{implode(', ',$obj_job->skills())}}
                        @else
                        Not specified
                        @endif
                      </span>
                    </li>
                    <li class="clearfix">
                      <strong class="job-left">Education</strong><span class="job-right">
                        @if($obj_job->educations())
                          {{implode(', ',$obj_job->educations())}}
                        @else
                        Not specified
                        @endif
                      </span>
                    </li>
                    <li class="clearfix">
                      <strong class="job-left">Functional Area</strong><span class="job-right">
                        @if($obj_job->functional_area())
                          {{implode(', ',$obj_job->functional_area())}}
                        @else
                          Not specified
                        @endif
                      </span>
                    </li>
                  </ul>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-image">
      Image
    </div>
@endsection
