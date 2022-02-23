@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
         @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            
         
        <div class="emp-content emp-current emp-msg-detail shadow" id="emp-message">
                  <div class="msg-main">
                    <span class="btn-back"><a href="{{route('employer.messages')}}"><img src="{{asset('assets/images/back-btn.png')}}" alt="back">Back</a></span>
                    {{--<button type="button" class="button del emp-delete"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                    </button>--}}
                  </div>
                  <div class="msg-detail-inner" id="delete-msg">
                    @if($job)
                    <div class="msg-top-box clearfix">
                      <div class="msg-left-box">
                        <em class="job-id">Job Id: {{$job->job_id}}</em></br>
                        <span class="job-id">Job Status: <span class="{{ @$job->status }}">{{ ucfirst( @$job->status)}}</span></span> 
                        <h3>{{optional($job->position)->name}}</h3>
                        <span class="apache-img apche-wrap"><img src="{{asset('assets/images/loc-img.png')}}" alt="location">
                         @if($job->cities())
                            {{implode(', ',$job->cities())}}
                         @endif,
                         @if($job->state())
                          {{implode(', ',$job->state())}}
                         @endif,
                          {{($job->country)?$job->country->name:''}}
                         </span>
                      </div>

                      @if(!empty($JobApplication))
                      <div class="msg-right-box">
                        <div class="application-wrapper clearfix">
                          <em class="app-id">Application Id: {{ $JobApplication->application_id}}</em>
                          <span class="app-status">Application Status: 
                            <span class="success-text">
                              @if($JobApplication->status == 'applied') 
                              Applied
                              @elseif($JobApplication->status == 'in_progress')
                              In Process
                              @elseif($JobApplication->status == 'unsuccess')
                              Unsuccess
                              @elseif($JobApplication->status == 'success')
                              Success
                              @elseif($JobApplication->status == 'candidate_declined')
                              Candidate Declined
                              @elseif($JobApplication->status == 'hired')
                              Hired
                              @elseif($JobApplication->status == 'cancelled')
                              Cancelled
                              @elseif($JobApplication->status == 'in_progress_with_employer')
                               In Progress With Employer
                              @endif

                            </span></span>
                        </div>
                        <div class="ref-info">
                          <span class="ref-name">{{ $JobApplication->name}}</span>
                          <a href="mailto:vaibhav.sharma@gmail.com" class="ref-mail">{{ $JobApplication->email}}</a>
                          <ul class="ref-list clearfix">
                            <li>
                              {{display_date_time($JobApplication->created_at)}}
                            </li>
                            <li>
                                {{ !empty($JobApplication->email) ? 'via Email' : '' }}
                            </li>
                            <li>
                               @php
                                  if(!empty($JobApplication->candidate))
                                  {
                                    $candidate = $JobApplication->candidate;
                                    if(!empty($candidate->current_location))
                                    {
                                       $c_id = $candidate->current_location->location_id;
                                       $current_loation = $candidate->get_location_by_id($c_id);
                                       echo isset($current_loation->location) ? $current_loation->location : '';
                                    } 
                                  }
                                @endphp
                              </li>
                          </ul>
                          <div class="payment-status clearfix">
                           <!--  <span class="pending">Payment: <span class="pending-color">Pending</span></span>
                            <span class="due-bal"> Due Balance: <span>$150</span></span> -->
                             <span class="pending">Payment: <span class="pending-color">
                              {{ $JobApplication->employerIsPayment ? $JobApplication->employerIsPayment->payment_status_label:''  }}</span>
                             </span>
                             <span class="due-bal">
                              {{ $JobApplication->employerIsPayment ? $JobApplication->employerIsPayment->payment_status_label:''}}: <span>{{ $JobApplication->employerIsPayment ? $JobApplication->employerIsPayment->amount :''}}</span>
                             </span>

                          </div>
                        </div>
                      </div>
                      @endif
                    </div>
                    @endif
                    <ul class="message-content">
                      @foreach($messageConversations as $messageConversation)
                        @if($messageConversation->sender_type == 'specialist')
                      <li class="msg-box">
                        <div class="msg-info clearfix">
                           @if(!empty($room->specialist->image))
                          <span class="msg-img"><img src="{{asset('storage/specialist/profile_pic/'.$room->specialist->image)}}" alt="message"></span>
                          @else
                          <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message"></span>
                          @endif
                          <div class="msg-detail">
                            <div class="msg-name-wrapper">
                              <span class="msg-name">{{ $room->specialist->name}}</span>
                              <em class="msg-date">{{messageDetailDateTime($messageConversation->created_at)}}</em>
                            </div>
                            <!-- <em class="msg-heading">Aenean sollicitudin, lorem quis bibendum auctor,</em>
                            <p>
                              This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi <em>elit consequat ipsum,</em> This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin.
                            </p> -->
                            <p>
                                {{$messageConversation->message}}
                            </p>
                          </div>
                        </div>
                      </li>
                       @endif

                       @if($messageConversation->sender_type == 'candidate')
                        <li class="msg-box">
                          <div class="msg-info clearfix">
                            @if(!empty($room->candidate->image))
                            <span class="msg-img"><img src="{{asset('storage/candidate/profile_pic/'.$room->candidate->image)}}" alt="message"></span>
                            @else
                              <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message"></span>
                            @endif
                            <div class="msg-detail">
                              <div class="msg-name-wrapper">
                                <span class="msg-name">{{ $room->candidate->name}}</span>
                                <em class="msg-date">{{messageDetailDateTime($messageConversation->created_at)}}</em>
                              </div>
                             
                              <p>
                                  {{$messageConversation->message}}
                              </p>
                            </div>
                          </div>
                        </li>
                        @endif

                        @if($messageConversation->sender_type == 'employer')
                          <li class="msg-box">
                            <div class="msg-info clearfix">
                              @if(!empty($job->company->logo))
                              <span class="msg-img"><img src="{{asset('storage/employer/company_logo/'.$job->company->logo)}}" alt="message"></span>
                              @else
                              <span class="msg-img"><img src="{{asset('storage/employer/company_logo/default.png')}}" alt="message"></span>
                              @endif
                              <div class="msg-detail">
                                <div class="msg-name-wrapper">
                                  <span class="msg-name">{{ $room->employer->name}}</span>
                                  <em class="msg-date">{{messageDetailDateTime($messageConversation->created_at)}}</em>
                                </div>
                                 <p>
                                    {{$messageConversation->message}}
                                 </p>
                              </div>
                            </div>
                          </li>
                        @endif

                         @if($messageConversation->sender_type == 'admin')
                        <li class="msg-box">
                          <div class="msg-info clearfix">
                             <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message"></span>
                            <div class="msg-detail">
                              <div class="msg-name-wrapper">
                                <span class="msg-name">{{ $room->admin->name}}</span>
                                <em class="msg-date">{{messageDetailDateTime($messageConversation->created_at)}}</em>
                              </div>
                               <p>
                                  {{$messageConversation->message}}
                               </p>
                            </div>
                          </div>
                        </li>
                        @endif
                      @endforeach
                    </ul>
                    <form class="message-form clearfix" method="post" action="{{route('employer.send_message')}}">
                      @csrf
                      <div class="msg-textarea profile-input">
                        <textarea name="message" id="message" placeholder="Reply...." onkeyup="enableSendButton();"></textarea>
                        <input type="hidden" name="roomId" value="{{$roomId}}">
                      </div>
                      <button class="button-link button msg-send" disabled="disabled" type="submit">
                        Send
                      </button>
                    </form>
                  </div>
                </div> 
                @if(!empty($messageConversations) && $messageConversations->count())
                {{ $messageConversations->appends(request()->except('page'))->links('layouts.web.pagination') }} 
                @endif    


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
<script type="text/javascript">
  function enableSendButton(){
     var txt = $("#message").val(); 
     if(txt == '')
     {
        $('.msg-send').attr('disabled','disabled');
     }
     if(txt)
     {
       $('.msg-send').removeAttr('disabled');
     }
   }
</script>

@endpush
@endsection