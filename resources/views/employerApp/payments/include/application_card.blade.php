<ul class="referral-detail ref-detail-sent">
   @foreach($applications as $app)
   <li>
      <div class="application-wrapper clearfix">
         <em class="app-id">Application Id: {{ $app->application_id}}</em>
         <span class="app-status">Application Status: <span class="success-text">{{ $app->status }}</span></span>
      </div>
      <div class="ref-info">
         <span class="ref-name">{{ $app->name }}</span>
         <a href="mailto:{{ $app->email }}" class="ref-mail">{{ $app->email }}</a>
         <div class="payment-status clearfix">
            <span class="pending">Payment: <span class="pending-color">{{ $app->employerIsPayment->payment_status }}</span></span>
         </div>
         <ul class="application-btn">
            <li class="msg-admin">
               @php
                 $empId =  my_id();
                 $room_data = ['jobId'=>$jobs->id,'appId'=>$app->id,'adminId'=>'1','empId'=>$empId];
                 $roomId =  base64_encode(json_encode($room_data));
               @endphp
               <a href="{{url('employer/chat/'.$roomId)}}" class="button-link">Message Admin</a>
            </li>
            <li class="due-bal">
               {{ $app->employerIsPayment->payment_status_label }} : {{ $app->employerIsPayment->amount }}
            </li>
         </ul>
      </div>
   </li>
   @endforeach
</ul>
@if($applications->count())
   {{ $applications->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif