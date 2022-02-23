@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
         @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            
          <div class="profile-content profile-current msg-detail-wrap" id="message-tab">
                  <div class="profile-content-inner shadow">
                    <div class="msg-main">
                      <span class="btn-back"><a href="{{route('candidate.messages')}}"><img src="{{asset('assets/images/back-btn.png')}}" alt="back">Back</a></span>
                      {{--<button type="button" class="button del msg-delete"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                      </button>--}}
                    </div>
                    <div class="msg-detail-inner">
                      <ul class="message-list clearfix">
                        <li>
                          <div class="project-details desktop-top">
                            <div class="left-detail">
                              <em class="job-id">Job Id: {{$JobApplication->job->job_id}}</em></br>
                              <span class="job-id">Job Status: <span class="{{ @$job->status }}">{{ ucfirst( @$JobApplication->job->status)}}</span></span> 
                              @php 
                                 $obj_job = $JobApplication->job;
                              @endphp
                              <h3>{{optional($obj_job->position)->name}}</h3>
                              <h4 class="apache-img apche-wrap"><img src="{{asset('assets/web/images/company.svg')}}" alt="company"> {{$obj_job->company->company_name}}</h4>
                              <span class="apache-img apche-wrap"><img src="{{asset('assets/web/images/location.svg')}}" alt="location">
                                <!-- cities -->
                              @if($obj_job->cities())
                                 {{implode(', ',$obj_job->cities())}}
                              @endif,
                              <!-- states -->
                              @if($obj_job->state())
                                 <strong>{{implode(', ',$obj_job->state())}}</strong>
                              @endif,
                                <strong>{{($obj_job->country)?$obj_job->country->name:''}}</strong>
                              </span>
                            </div>
                            <div class="right-detail">
                              @php
                                 $logo_path = public_path('storage/employer/company_logo/'.$obj_job->company->logo);

                                 if(file_exists($logo_path))
                                 {
                                    $logo_path = asset('storage/employer/company_logo/'.$obj_job->company->logo);
                                 }
                                 else
                                 {
                                    $logo_path = asset('storage/employer/company_logo/default.png');
                                 }
                              @endphp
                              <a href="javascript:void(0);" class="project-logo" onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',null,true)">
                                 <img src="{{$logo_path}}" alt="project-apache">
                              </a>
                              <span class="ref-bonus">
                                @if($obj_job->referral_bonus_amt)

                                      @php 
                                       $fromIsoCode = '';
                                       $fromCurrencySign = '';
                                       if($obj_job->country->currency_sign)
                                       {
                                        $fromCurrencySign = $obj_job->country->currency_sign->symbol;
                                        $fromIsoCode = $obj_job->country->currency_sign->iso_code;
                                       }

                                      $rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$obj_job->referral_bonus_amt);
                                      if($rateConversion)
                                      {
                                        echo $rateConversion;
                                      }
                                     @endphp

                                  {{-- {{get_amount($obj_job->referral_bonus_amt)}}--}}
                                @else
                                --   
                                @endif
                              </span>
                              <em class="ref-text">Referral Bonus</em>
                            </div>
                          </div>
                          <div class="project-details mobile-top">
                            <div class="left-detail">
                              <em class="job-id">Job Id: {{$JobApplication->job->job_id}}</em>
                              @php 
                                 $obj_job = $JobApplication->job;
                              @endphp
                              <h3>{{optional($obj_job->position)->name}}</h3>
                              <h4 class="apache-img apche-wrap"><img src="{{asset('assets/web/images/company.svg')}}" alt="company">{{$obj_job->company->company_name}}</h4>
                              <a href="#" class="project-logo"><img src="{{asset('assets/images/project-apache.png')}}" alt="project-apache"></a>
                              <span class="apache-img apche-wrap"><img src="{{asset('assets/images/loc-img.png')}}" alt="location">
                                 <!-- cities -->
                              @if($obj_job->cities())
                                 {{implode(', ',$obj_job->cities())}}
                              @endif,
                              <!-- states -->
                              @if($obj_job->state())
                                 <strong>{{implode(', ',$obj_job->state())}}</strong>
                              @endif,
                                <strong>{{($obj_job->country)?$obj_job->country->name:''}}</strong>
                              </span>
                            </div>
                            <div class="right-detail">
                              <span class="ref-bonus">
                                @if($obj_job->referral_bonus_amt)
                                   {{get_amount($obj_job->referral_bonus_amt)}}
                                @else
                                --   
                                @endif
                              </span>
                              <em class="ref-text">Referral Bonus</em>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="application-wrapper clearfix">
                            <em class="app-id">Application Id: {{ $JobApplication->application_id}}</em>
                            
                            <span class="app-id">Application Status: <span class="success-text">
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
                            <a href="mailto:{{ $JobApplication->email}}" class="ref-mail">{{ $JobApplication->email}}</a>
                            <ul class="ref-list clearfix">
                              <li>
                                {{display_date_time($JobApplication->created_at)}}
                              </li>
                              <li>
                                {{ !empty($JobApplication->email) ? 'via Email' : ''}}
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
                                       echo isset($current_loation->location) ? $current_loation->location :'';
                                    } 
                                  }
                                @endphp 
                              </li>
                            </ul>
                            <div class="payment-status clearfix">
                              @php $myId =  my_id();  @endphp
                                @if($JobApplication->refer_by == $myId)
                                   <span class="pending">Payment: <span class="pending-color">{{ $JobApplication->candidateIsPayment ? $JobApplication->candidateIsPayment->payment_status_label:''  }}</span></span>
                                  <span class="due-bal"> {{ $JobApplication->candidateIsPayment ? $JobApplication->candidateIsPayment->payment_status_label:''}}: <span>{{ $JobApplication->candidateIsPayment ? $JobApplication->candidateIsPayment->amount :''}}</span></span>
                                @endif
                            </div>
                          </div>
                        </li>
                      </ul>
                      <ul class="message-content">
                       @foreach($messageConversations as $messageConversation)
                          
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
                                    {{--@if(!empty($room->employer->image))
                                    <span class="msg-img"><img src="{{asset('storage/employer/company_logo/'.$room->employer->image)}}" alt="message"></span>
                                    @else
                                    <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.jpg')}}" alt="message"></span>
                                    @endif--}}
                                     <span class="msg-img"><img src="{{asset('storage/default-user-image/dummy.png')}}" alt="message"></span>
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
                      @if($JobApplication->job->status != 'cancelled' && $JobApplication->job->status != 'cancelled')
                      <form class="message-form clearfix" method="post" action="{{route('candidate.send_message')}}">
                        @csrf
                        <div class="msg-textarea profile-input">
                          <textarea name="message" id="message" placeholder="Reply...." onkeyup="enableSendButton();"></textarea>
                          <input type="hidden" name="roomId" value="{{$roomId}}">
                          {{--<input type="hidden" name="spc_id" value="{{ $JobApplication->specialist_id}}">
                          <input type="hidden" name="job_id" value="{{$JobApplication->job_id}}">
                          <input type="hidden" name="application_id" value="{{ $JobApplication->id}}">--}}
                        </div>
                        <button class="button-link button msg-send" disabled="disabled" type="submit">
                          Send
                        </button>
                      </form>
                      @endif
                    </div>
                  </div>
                  @if(!empty($messageConversations) && $messageConversations->count())
                  {{ $messageConversations->appends(request()->except('page'))->links('layouts.web.pagination') }} 
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