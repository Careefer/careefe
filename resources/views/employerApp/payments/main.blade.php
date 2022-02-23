@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="emp-content pay-employer dashboard-main emp-current" id="emp-payment">
               @php 
                $sortBy = ["jobId"=> "Job Id",
                 "position"=>"Position", "location"=>"Location", "specialist"=>"Specialist", "applicant"=>"Applicant", "status"=>"status", "total-paid"=>"Total Paid", "total-pending"=>"Total Pending"];
               @endphp 
               <div class="job-content-inner refer-common shadow clearfix">
                  <h2>Payments</h2>
                  <div class="select-outer ">
                     <div class="pay-selectbox select-sort-pay">
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
                     </div>
                  </div>
                  <div class="spc-job-ajax-render-section">
                  @include('employerApp.payments.include.job_card')
                  </div> 
               </div>  
            </div>
         </div>
      </div>
   </div>
</div>
<form class="app-form list-form" id="filters" method="GET">
    <input type="hidden" name="sortby" value="" id="input-sort">
</form> 
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
