@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
         @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            
          <div class="profile msg-wrapper" id="message-tab">
                  <div class="profile-content-inner shadow">
                    <h2>Messages</h2>
                    <ul class="msg-list">

                      @forelse($allThreads as $thread)
                        @if(!empty($thread->specialist))
                          <li class="msg1 msg-box">
                            <a href="{{url('candidate/chat/'.$thread->room_id)}}">
                            <div class="msg-top">
                              @php 
                                 $obj_job = $thread->job;

                                 $logo_path = public_path('storage/employer/company_logo/'.$obj_job->company->logo);

                                 if(file_exists($logo_path))
                                 {
                                    $logo_path = asset('storage/employer/company_logo/'.$obj_job->company->logo);
                                 }
                                 else
                                 {
                                    $logo_path = asset('assets/images/loc-img2.png');
                                 }
                              @endphp
                              <span class="msg-title">{{optional($obj_job->position)->name}}</span>
                              <em class="msg-id">Job Id: {{$thread->job->job_id}}</em>
                            </div> <span class="apache-img apche-wrap">
                              <img src="{{asset('assets/images/loc-img2.png')}}" alt="company">
                               <!-- <img src="{{$logo_path}}" alt="company"> -->
                              {{$obj_job->company->company_name}}</span>
                            <div class="msg-info clearfix">
                              <span class="msg-img">
                                @if(!empty($thread->specialist->image))
                                <img src="{{asset('storage/specialist/profile_pic/'.$thread->specialist->image)}}" alt="message">
                                @else
                               <img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message">
                                @endif
                              </span>
                              <div class="msg-detail">
                                <span class="msg-name">{{$thread->specialist->name}}</span>
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
                            <button type="button"  class="button del" onclick="return confirm_popup('{{route("candidate.deleteThread",[encrypt($thread->id)])}}','Want to delete this thread');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                            </button>
                          </li>
                        @endif

                      @if(!empty($thread->admin))
                      <li class="msg1 msg-box">
                        <a href="{{url('candidate/chat/'.$thread->room_id)}}">
                        <div class="msg-top">
                          @php 
                             $obj_job = $thread->job;
                          @endphp
                          <span class="msg-title">{{optional($obj_job->position)->name}}</span>
                          <em class="msg-id">Job Id: {{$thread->job->job_id}}</em>
                        </div> <span class="apache-img apche-wrap"><img src="{{asset('assets/images/loc-img2.png')}}" alt="company">{{$obj_job->company->company_name}}</span>
                        <div class="msg-info clearfix">
                          <span class="msg-img">
                            <img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message">
                          </span>
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
                        <button type="button"  class="button del" onclick="return confirm_popup('{{route("candidate.deleteThread",[encrypt($thread->id)])}}','Want to delete this thread');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
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