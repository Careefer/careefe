@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="emp-content emp-current pay-employer dashboard-main ref-received emp-pay-detail" id="emp-payment">
               <div class="job-content-inner refer-common shadow">
                  <div class="btn-back">
                     <a href="{{ route('employer.payments') }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
                  </div>
                  <div class="project-job">
                     <div class="pay-top">
                        <div class="top-block">
                           <div class="top-main">
                              <em class="job-id">Job Id: {{$jobs->job_id}}</em>
                              <span class="pending">Status: <span class="pending-color">{{ $jobs->status}}</span></span>
                           </div>
                           <div class="project-details">
                              <div class="left-detail">
                                 <h3>{{optional($jobs->position)->name}}</h3>
                                 <span class="basket-text">
                                    <!-- cities -->
                                   @if($jobs->cities())
                                      {{implode(', ',$jobs->cities())}}
                                   @endif,

                                   <!-- states -->
                                   @if($jobs->state())
                                      <strong>{{implode(', ',$jobs->state())}}</strong>
                                   @endif,

                                   <!-- country -->
                                   <strong>
                                      {{($jobs->country)?$jobs->country->name:''}}
                                   </strong>
                                 </span>
                                 <span class="basket-text basket-work">Specialist: <strong>{{ (@$jobs->primary_specialist ? $jobs->primary_specialist->name : (@$jobs->secondary_specialist ? $jobs->secondary_specialist->name: ''))}}</strong></span>
                                 <span class="basket-text">Posted Date &amp; Time: <strong>{{ display_date_time($jobs->created_at) }}</strong></span>

                              </div>
                              <div class="right-detail">
                                @php
                                   $empId =  my_id();
                                   $room_data = ['jobId'=>$jobs->id,'spcId'=>$jobs->primary_specialist_id,'empId'=>$empId];
                                   $roomId =  base64_encode(json_encode($room_data));
                                @endphp
                                 <a href="{{url('employer/chat/'.$roomId)}}" class="msg-specialist">Message Specialist</a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="pay-bottom">
                        <span class="hired">Total Hired: <strong>3</strong></span>
                        <ul class="pay-list">
                           <li>
                              <span>Total Paid:</span><strong>$15</strong>
                           </li>
                           <li>
                              <span>Total Outstanding:</span><strong>$15</strong>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="select-outer">
                     <div class="pay-selectbox">

                      @php 
                            $sortBy = ["alphabetical"=> "Alphabetical",
                             "due_balance"=>"Due Balance"];
                          @endphp 
                            <select class="pay-sort" id="sorting" name="sorting">
                              <option>sort</option>
                              @foreach($sortBy as $key=> $val)
                              @php
                                 $selected = '';
                                 if(isset($filter_data) && $filter_data == $key)
                                 {
                                   $selected = 'selected="selected"';
                                 }
                              @endphp
                               <option {{$selected}} value="{{ $key }}"> {{ $val }}</option>
                               @endforeach
                            </select>


                        <!-- <select class="pay-sort">
                           <option>Sort</option>
                           <option>Option</option>
                           <option>Option</option>
                        </select> -->
                     </div>
                     <a href="{{ route('employer.export-payments', [$jobs->id]) }}" type="button" class="export-btn button" target="_blank"><img src="{{ asset('assets/images/export-img.png') }}" alt="export">Export
                     </a>
                  </div>
                  <div class="spc-job-ajax-render-section">
                     @include('employerApp.payments.include.application_card')
                  </div>
               </div>  
            </div>
         </div>
      </div>
   </div>
   <form class="app-form list-form" id="filters" method="GET">
    <input type="hidden" name="sortby" value="" id="input-sort">
  </form> 
</div>
<div class="bottom-image">
   Image
</div>

@push('script')
<script type="text/javascript">
  $('#sorting').on('selectmenuchange', function() {
     var sortBy = $("select[name='sorting']").val();
     if(sortBy){
      $('#input-sort').val(sortBy);
      $('#filters').submit(); 
     }
  });
</script>
@endpush
@endsection
