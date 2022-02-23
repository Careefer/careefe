@extends('layouts.web.web')
@section('content')
@section('body-class','my-job-listing')
  <div class="dashboard-wrapper employer-main">
          <div class="container">
            <h1 class="heading-tab">My Account</h1>
            <div class="main-tab-wrapper clearfix">
              @include('layouts.web.left_menue')
              <div class="main-tabs-content">
                <div class="emp-content dashboard-main apps-wrapper emp-current" id="emp-jobs">
                  <div class="job-content-inner shadow">
                    <div class="top-content">
                      <h2>My Jobs</h2>
                      <a onclick="redirect_url($(this),'{{ route('employer.job.add') }}');" href="javascript:void(0);" class="button-job"><img src="{{asset('assets/web/images/add-job.png')}}" alt="add-job">Add Job</a>
                    </div>
                    <form class="app-form jobs-appform" method="GET" action="" id="job_filters">
                      <label>Filter:</label>
                      <div class="app-selectbox id-select-wrap5">
                        <select class="careefer-select2" name="job-id" data-placeholder = 'Job Id'>
                          <option value="">Job Id</option>
                          @if($filter_job_ids)
                            @foreach($filter_job_ids as $job_id => $job_display_id)
                              @php
                                $selected= '';
                                if(isset($filter_data['job-id']) && $filter_data['job-id'] == $job_id)
                                {
                                  $selected = 'selected="selected"';
                                }
                              @endphp
                              <option {{$selected}} value="{{$job_id}}">{{$job_display_id}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="app-selectbox pos-select-wrap5">
                        <select class="careefer-select2" name="position" data-placeholder = 'Position'>
                          @if($filter_position_ids)
                              <option  value="">Positions</option>
                              @foreach($filter_position_ids as $position_id => $position_name)
                                @php
                                  $selected = '';
                                  if(isset($filter_data['position']) && $filter_data['position'] == $position_id)
                                  {
                                    $selected = 'selected="selected"';
                                  }
                                @endphp
                                <option {{$selected}}  value="{{$position_id}}">{{$position_name}}</option>
                              @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="app-selectbox job-status">
                        <select class="careefer-select2" name="job_status" data-placeholder = 'Job Status'>
                            <option value="">Job Status</option>
                          @if(is_array(JOB_STATUS))
                            @foreach(JOB_STATUS as $js_key => $job_status)
                                @php
                                  $selected = '';
                                  if(isset($filter_data['job_status']) && $filter_data['job_status'] == $js_key)
                                  {
                                    $selected = 'selected="selected"';
                                  }
                                @endphp
                              <option {{$selected}} value="{{$js_key}}">{{$job_status}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="app-selectbox com-select-wrap5">
                        <select class="careefer-select2" data-placeholder = 'Specialist' name="specialist">
                              <option value="">Specialist</option>
                            @if($filter_specialist->count())
                              @foreach($filter_specialist as $specialist_id => $name)
                                @php
                                  $selected = '';
                                  if(isset($filter_data['specialist']) && $filter_data['specialist'] == $specialist_id)
                                  {
                                    $selected = 'selected="selected"';
                                  }
                                @endphp
                              <option {{$selected}} value="{{$specialist_id}}">{{$name}}</option>
                              @endforeach
                            @endif
                        </select>
                      </div>
                      <div class="app-selectbox job-select-wrap">
                        <!-- <select class="job-select" data-search="true" placeholder="Location">
                          <option>Location</option>
                          <option>Option1</option>
                          <option>Option2</option>
                          <option>Option3</option>
                        </select> -->
                          <select name="location" class="loadAjaxSuggestion">
                            <option value="">Enter</option>
                          </select>
                      </div>
                      <ul class="form-button">
                        <li>
                          <button onclick="submit_form($(this),$('#job_filters'),true)" type="button" class="button-link apply-btn">
                            Apply
                          </button>
                        </li>
                        @if($filter_data)
                        <li>
                          <button onclick="redirect_url($(this),'{{route('employer.job.listing')}}',true)" type="button" class="reset-button button">
                            reset
                          </button>
                        </li>
                        @endif
                      </ul>
                    </form>
                    <div class="form-msg">
                      @if(session('success'))
                        <h4 class="success_msg">{{session('success')}}</h4>
                      @endif
                    </div>

                    <div class="employer-inner emp-job-content">
                      @if($jobs->count())
                        @foreach($jobs as $key => $obj_job)
                          <div class="project-job">
                            <div class="top-block">
                              <div class="top-main">
                                <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
                                <span class="pending">Job Status: <span class="{{ $obj_job->status }}">{{ ucfirst($obj_job->status) }}</span></span>
                              </div>
                              <div class="project-details">
                                <div class="left-detail">
                                  @if($obj_job->position)
                                    <h3>{{$obj_job->position->name}}</h3>
                                  @endif
                                  <span class="apache-img apche-wrap flag-icon"><img src="{{asset('assets/web/images/time.svg')}}" alt="time">{{$obj_job->experience_min.'-'.$obj_job->experience_max}} yrs</span>
                                  <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                                    
                                    <!-- cities -->
                                    @if($obj_job->cities())
                                      {{implode(', ',$obj_job->cities())}}
                                    @endif,

                                    <!-- states -->
                                    @if($obj_job->state())
                                      {{implode(', ',$obj_job->state())}}
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

                    <div class="spc-job-ajax-render-section">
                      @if(request()->ajax())
                        @include('employerApp.jobs.card_job')
                      @endif
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
