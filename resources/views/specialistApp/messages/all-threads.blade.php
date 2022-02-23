@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
         @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            
          
          <div class="dashboard spe-message" id="message-tab">
                  <div class="job-content-inner shadow">
                    <div class="msg-top-section">
                      <h2>Messages</h2>
                      @php
                         $spcId =  my_id();
                         $room_data = ['adminId'=>'1','spcId'=>$spcId];
                         $roomId =  base64_encode(json_encode($room_data));
                      @endphp
                      <a href="{{url('specialist/chat/'.$roomId)}}" class="button-link contact-admin">Contact Admin</a>
                    </div>
                    <ul class="msg-list">
                      @forelse($allThreads as $thread)
                        @if(!empty($thread->candidate))
                      <li class="msg1 msg-box">
                        <a href="{{url('specialist/chat/'.$thread->room_id)}}">
                        <div class="msg-top">
                          @php 
                             $obj_job = $thread->job;
                          @endphp
                          <span class="msg-title">{{optional($obj_job->position)->name}}</span>
                          <div class="msg-right">
                            <span class="applicant">Applicant: <strong>{{$thread->candidate->name}}</strong></span>
                            <em class="msg-id">Job Id: {{$thread->job->job_id}}</em>
                          </div>
                        </div>
                        <div class="message-loc">
                          <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/company.svg')}}" alt="company">{{$obj_job->company->company_name}}</span>
                          <span class="apache-img apche-wrap msg-location"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                             @if($obj_job->cities())
                                 {{implode(', ',$obj_job->cities())}}
                              @endif,
                              @if($obj_job->state())
                                 {{implode(', ',$obj_job->state())}}
                              @endif,
                                {{($obj_job->country)?$obj_job->country->name:''}}
                          </span>
                        </div>
                        <div class="msg-info clearfix">
                          <span class="msg-img">
                            @if(!empty($thread->candidate->image))
                              <img src="{{asset('storage/candidate/profile_pic/'.$thread->candidate->image)}}" alt="message">
                              @else
                              <img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message">
                            @endif
                          </span>
                          <div class="msg-detail">
                            <span class="msg-name">{{$thread->candidate->name}}</span>
                            <!-- <em class="msg-heading">Aenean sollicitudin, lorem quis bibendum auctor,</em>
                            <p>
                              Bibendum Aenean sollicitudin, lorem quis bibendum auctor, nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin.
                            </p> -->
                            <p>
                              {{$thread->last_message}}
                            </p>
                            <span class="msg-date">{{displayMessagedate($thread->last_message_date_time)}}<span>{{displayTime($thread->last_message_date_time)}}</span></span>
                          </div>
                        </div> </a>

                        <button type="button"  class="button del" onclick="return confirm_popup('{{route("specialist.deleteThread",[encrypt($thread->id)])}}','Want to delete this thread');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                        </button>
                      </li>
                      @endif

                      @if(!empty($thread->admin))
                      <li class="msg2 msg-box">
                        <a href="{{url('specialist/chat/'.$thread->room_id)}}">
                        <div class="msg-top">
                           @php 
                             $obj_job = $thread->job;
                          @endphp
                          <span class="msg-title">{{!empty($obj_job) ? $obj_job->position->name : ''}}</span>
                          <div class="msg-right">
                            <!-- <span class="applicant">Applicant: <strong>Amit Kumar</strong></span> -->
                            @if(!empty($obj_job))
                            <em class="msg-id">Job Id: {{$thread->job->job_id}}</em>
                            @endif
                          </div>
                        </div>
                        @if(!empty($obj_job))
                        <div class="message-loc">
                          <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/company.svg')}}" alt="company">{{$obj_job->company->company_name}}</span>
                          <span class="apache-img apche-wrap msg-location"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                            @if($obj_job->cities())
                                 {{implode(', ',$obj_job->cities())}}
                            @endif,
                            @if($obj_job->state())
                                 {{implode(', ',$obj_job->state())}}
                            @endif,
                                {{($obj_job->country)?$obj_job->country->name:''}}
                          </span>
                        </div>
                        @endif
                        <div class="msg-info clearfix">
                          <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message"></span>
                          <div class="msg-detail">
                            <span class="msg-name">Admin</span>
                            <!-- <em class="msg-heading">Aenean sollicitudin, lorem quis bibendum auctor,</em>
                            <p>
                              Bibendum Aenean sollicitudin, lorem quis bibendum auctor, nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin.
                            </p> -->

                            <p>
                              {{$thread->last_message}}
                            </p>
                            <span class="msg-date">{{displayMessagedate($thread->last_message_date_time)}}<span>{{displayTime($thread->last_message_date_time)}}</span></span>
                          </div>
                        </div> </a>
                        <button type="button"  class="button del" onclick="return confirm_popup('{{route("specialist.deleteThread",[encrypt($thread->id)])}}','Want to delete this thread');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                        </button>
                      </li>
                      @endif
                      
                      @if(!empty($thread->employer))
                      <li class="msg1 msg-box">
                        <a href="{{url('specialist/chat/'.$thread->room_id)}}">
                        <div class="msg-top">
                          @php 
                             $obj_job = $thread->job;
                          @endphp
                          <span class="msg-title">{{optional($obj_job->position)->name}}</span>
                          <div class="msg-right">
                           <!--  <span class="applicant">Applicant: <strong></strong></span> -->
                            <em class="msg-id">Job Id: {{$thread->job->job_id}}</em>
                          </div>
                        </div>
                        <div class="message-loc">
                          <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/company.svg')}}" alt="company">{{$obj_job->company->company_name}}</span>
                          <span class="apache-img apche-wrap msg-location"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                             @if($obj_job->cities())
                                 {{implode(', ',$obj_job->cities())}}
                              @endif,
                              @if($obj_job->state())
                                 {{implode(', ',$obj_job->state())}}
                              @endif,
                                {{($obj_job->country)?$obj_job->country->name:''}}
                          </span>
                        </div>
                        <div class="msg-info clearfix">
                          <span class="msg-img">
                            {{--@if(!empty($thread->candidate->image))
                              <img src="" alt="message">
                              @else
                              <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message"></span>
                            @endif--}}
                            <span class="msg-img"><img src="{{asset('storage/employer/company_logo/default.png')}}" alt="message"></span>
                          </span>
                          <div class="msg-detail">
                            <span class="msg-name">{{$thread->employer->name}}</span>
                            <!-- <em class="msg-heading">Aenean sollicitudin, lorem quis bibendum auctor,</em>
                            <p>
                              Bibendum Aenean sollicitudin, lorem quis bibendum auctor, nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin.
                            </p> -->
                            <p>
                              {{$thread->last_message}}
                            </p>
                            <span class="msg-date">{{displayMessagedate($thread->last_message_date_time)}}<span>{{displayTime($thread->last_message_date_time)}}</span></span>
                          </div>
                        </div> </a>
                       <button type="button"  class="button del" onclick="return confirm_popup('{{route("specialist.deleteThread",[encrypt($thread->id)])}}','Want to delete this thread');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                        </button>
                      </li>
                      @endif

                      @empty
                      <p></p>
                      @endforelse
                    </ul>
                  </div>
                   @if(!empty($allThreads) && $allThreads->count())
                  {{ $allThreads->appends(request()->except('page'))->links('layouts.web.pagination') }} 
                  @endif
                </div>


         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/fancy_fileupload.css')}}" media="screen">
<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/selectstyle.css')}}" media="screen">
@endpush
@push('js')
<script src="{{asset('assets/web/js/jquery.ui.widget.js')}}"></script>
<script src="{{asset('assets/web/js/jquery.fileupload.js')}}"></script>
<script src="{{asset('assets/web/js/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('assets/web/js/jquery.fancy-fileupload.js')}}"></script>
<script src="{{asset('assets/web/js/selectstyle.js')}}"></script>
<script src="{{asset('assets/web/js/inview.js')}}"></script>

@endpush
@endsection