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
                     <h2>My Alerts</h2>
                     <div class="manage-wrapper">
                        <button type="button"  class="button del unsubscribe-btn" >Unsubscribe All
                        </button>
                     </div>
                  </div>
                  <ul class="not-list not-listing">
                     @forelse($jobAlerts as $jobAlert)
                     <li>
                        <a href="#">
                           <h3> {{ !empty($jobAlert->industry->name) ? $jobAlert->industry->name:''}}</h3>
                           <button type="button"  class="button del delete-btn-label" onclick="return confirm_popup('{{route("candidate.deleteAlert",[encrypt($jobAlert->id)])}}','Want to delete this alert');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                           </button>
                           <p>
                               {{!empty($jobAlert->company->company_name) ? $jobAlert->company->company_name:''}}
                           </p>
                           <p>
                               {{!empty($jobAlert->position->name) ? $jobAlert->position->name:''}}
                           </p>
                           <span class="msg-date">{{displayMessagedate($jobAlert->created_at)}}<span>{{displayTime($jobAlert->created_at)}}</span></span>

                           <!-- <button type="button"  class="button del" onclick="return confirm_popup('{{route("candidate.deleteAlert",[encrypt($jobAlert->id)])}}','Want to delete this alert');"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                           </button> -->
                        </a>
                     </li>
                     @empty
                     <p style="text-align: center;padding-top: 20px;"> NO Alerts! </p>
                     @endforelse 
                  </ul>
               </div>
               @if(!empty($jobAlerts) && $jobAlerts->count())
               {{ $jobAlerts->appends(request()->except('page'))->links('layouts.web.pagination') }} 
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