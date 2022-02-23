@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
         @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="notification" id="notification-tab">
               <div class="profile-content-inner shadow">
                  <div class="not-top">
                     <h2>Notifications</h2>
                     <div class="manage-wrapper">
                        <span class="manage-dropdown"><img src="{{asset('assets/images/manage-img.png')}}" alt="manage">Manage</span>
                        <div class="manage-list">
                           <span class="email-me">Email me for</span>
                           <ul class="switch-list">
                              @foreach($all_setting_notifications as $all_setting_notification)
                              <li>
                                 {{$all_setting_notification->notifications->name}} <label class="switch-wrapper">
                                 <input type="checkbox" @if($all_setting_notification->status==1) checked @endif>
                                 <span class="switch-slider" data-id="{{$all_setting_notification->id}}"></span> </label>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                  </div>
                  <ul class="not-list">
                     @forelse($all_notifications as $notification)
                     <li>
                        <a href="#">
                           <h3>{{$notification->data['first_name']." ".$notification->data['last_name']}}</h3>
                           <p>
                              {{$notification->data['notification']}}
                           </p>
                           <span class="msg-date">{{displayMessagedate($notification->created_at)}}<span>{{displayTime($notification->created_at)}}</span></span>
                        </a>
                     </li>
                     @empty
                     <p style="text-align: center;padding-top: 20px;"> NO Notification </p>
                     @endforelse 
                  </ul>
               </div>
               @if(!empty($all_notifications) && $all_notifications->count())
               {{ $all_notifications->appends(request()->except('page'))->links('layouts.web.pagination') }} 
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
@php  
$user_type = Auth::getDefaultDriver();
$url = $user_type.'/notification-status'; 
@endphp
<script>
   $(document).ready(function()
   {
       $(".switch-slider").on("click",function(e){
         var id = $(this).attr('data-id');
   
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
             url : '{{ url($url) }}',
             type : "POST",
             data:{id:id},
             success : function(data){
              
             }
           });
         }); 
   });
</script>
@endpush
@endsection