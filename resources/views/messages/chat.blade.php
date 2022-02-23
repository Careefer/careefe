@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('candidates.candidate.index') }}">Candidates</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View Chat</span>
                </li>
            </ul>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase">
                            <i class="fa fa-edit"></i>&nbspView Chat
                        </h4>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                       <div class="col-md-12">
                          @if(!empty($room->specialist))
                             <span><strong>User Type : </strong></span><span><strong>Specialist</strong></span>
                          @endif
                          @if(!empty($room->candidate))
                             <span><strong>User Type : </strong></span><span><strong>Candidate</strong></span>
                          @endif
                          @if(!empty($room->employer))
                             <span><strong>User Type : </strong></span><span><strong>Employer</strong></span>
                          @endif
                       </div>
                       
                      <!--  job card  -->
                        @if($job)
                        <div class="col-md-6 msg">
                           <p>Position : {{optional($job->position)->name}}</p>
                           <p>Employer Name : {{optional($job->employer)->name}}</p>
                           @if(!empty($job->company->logo))
                              <img src="{{asset('storage/employer/company_logo/'.$job->company->logo)}}" alt="Avatar" class="img-circle" style="float: right;">
                               @else
                             <img src="{{asset('storage/employer/company_logo/default.png')}}" alt="logo" style="float: right;">
                             @endif
                           <p>Job Id : {{$job->job_id}}</p>
                           <p>Job Location : 
                            @if($job->cities())
                                 {{implode(', ',$job->cities())}}
                            @endif,
                            @if($job->state())
                                 <strong>{{implode(', ',$job->state())}}</strong>
                              @endif,
                               <strong>{{($job->country)?$job->country->name:''}}</strong>
                           </p>
                           <p>Referral Bonus : 
                            @if($job->referral_bonus_amt)
                                   {{get_amount($job->referral_bonus_amt)}}
                                @else
                                --   
                            @endif
                           </p>
                           <p>Specialist Bonus : 
                            @if($job->specialist_bonus_amt)
                                   {{get_amount($job->specialist_bonus_amt)}}
                                @else
                                --   
                            @endif
                           </p>
                        </div> 
                        @endif
                      <!--  end job card  --> 

                      <!-- Application card -->
                       @if(!empty($JobApplication))
                        <div class="col-md-6 msg">
                          <p>Application Id : {{ $JobApplication->application_id}}</p>
                          <p>Applicant Name : {{ $JobApplication->name}}</p>
                          <p>Application Status : {{ $JobApplication->status}}</p>
                          <p>Email : {{ $JobApplication->email}}</p>
                          <p>Applied Date : {{display_date_time($JobApplication->created_at)}}</p>
                          <p>Applied Medium : {{ !empty($JobApplication->email) ? 'Via Email' : ''}}</p>
                          <p>Applicant Location : 
                            @php
                              if(!empty($JobApplication->candidate))
                              {
                                $candidate = $JobApplication->candidate;
                                if(!empty($candidate->current_location))
                                {
                                  $c_id = $candidate->current_location->location_id;
                                  $current_loation = $candidate->get_location_by_id($c_id);
                                  $location = isset($current_loation) ? $current_loation->location :'';
                                  echo $location;
                                }
                              }
                            @endphp  
                          </p>
                          <p></p>
                        </div>
                       @endif 
                      <!-- Application card --> 

                      @foreach($messageConversations as $messageConversation)

                        @if($messageConversation->sender_type == 'specialist')  
                           <div class="col-md-12 msg">
                            @if(!empty($room->specialist->image))
                             <img src="{{asset('storage/specialist/profile_pic/'.$room->specialist->image)}}" alt="Avatar" class="img-circle">
                              @else
                            <img src="{{asset('storage/default-user-image/dummy.png')}}" alt="Avatar">
                            @endif
                             <span><strong>{{ $room->specialist->name}}</strong></span>
                             <p>{{$messageConversation->message}}</p>
                             <span class="time-right">{{display_date_time($messageConversation->created_at)}}</span>
                           </div>
                       @endif

                       @if($messageConversation->sender_type == 'candidate')
                            <div class="col-md-12 msg">
                             @if(!empty($room->candidate->image))
                              <img src="{{asset('storage/candidate/profile_pic/'.$room->candidate->image)}}" alt="Avatar" class="img-circle">
                               @else
                             <img src="{{asset('storage/default-user-image/dummy.png')}}" alt="Avatar">
                             @endif
                              <span><strong>{{ $room->candidate->name}}</strong></span>
                              <p>{{$messageConversation->message}}</p>
                              <span class="time-right">{{display_date_time($messageConversation->created_at)}}</span>
                            </div>
                       @endif

                       @if($messageConversation->sender_type == 'employer')
                          <div class="col-md-12 msg">
                             @if(!empty($job->company->logo))
                              <img src="{{asset('storage/employer/company_logo/'.$job->company->logo)}}" alt="Avatar" class="img-circle">
                               @else
                             <img src="{{asset('storage/employer/company_logo/default.png')}}" alt="logo">
                             @endif
                              <span><strong>{{ $room->employer->name}}</strong></span>
                              <p>{{$messageConversation->message}}</p>
                              <span class="time-right">{{display_date_time($messageConversation->created_at)}}</span>
                            </div>
                       @endif

                       @if($messageConversation->sender_type == 'admin')
                            <div class="col-md-12 msg">
                                <img src="{{asset('storage/default-user-image/dummy.png')}}" alt="Avatar">
                                <span><strong>{{ $room->admin->name}}</strong></span>
                                <p>{{$messageConversation->message}}</p>
                                <span class="time-right">{{display_date_time($messageConversation->created_at)}}</span>
                              </div>
                       @endif

                       @endforeach

                       <div class="col-md-12 msg">
                            <form  method="post" action="{{ route('messages.message.store')}}">
                              @csrf
                              <div>
                                <textarea name="message" class="form-control" id="message" rows="4" cols="10" placeholder="Reply...." onkeyup="enableSendButton();"></textarea>
                                <input type="hidden" name="roomId" value="{{$roomId}}">
                              </div><br>
                              <button class="btn btn-info msg-send"" disabled="disabled" type="submit">
                                Send
                              </button>
                            </form>   
                        </div>
                        @if(!empty($messageConversations) && $messageConversations->count())
                        {{ $messageConversations->links() }} 
                        @endif
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
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
@push('css')
    <style>
        body {
                margin: 0 auto;
         }
        .msg {
          border: 2px solid #dedede;
          background-color: #f1f1f1;
          border-radius: 5px;
          padding: 10px;
          margin: 10px 0;
        }


        .msg img {
          float: left;
          max-width: 60px;
          width: 100%;
          margin-right: 20px;
          border-radius: 50%;
        }
    </style>
@endpush
@endsection