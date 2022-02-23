@extends('layouts.web.web')
@section('content')
<div class="dashboard-wrapper">
   <div class="container">
      <h1 class="heading-tab">My Accounts</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
            <div class="dashboard-content job-basket dashboard-current" id="corrent-tab">
            <h2>Applications</h2>
            <ul class="app-tabs job-tabs-list clearfix hrz-scroll">
               <li data-tab="act-content" class="apps-list {{($application_type == 'active')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("specialist.applications",["active"])}}',true)">
                  Active Jobs
               </li>
               <li data-tab="hold-content" class="apps-list {{($application_type == 'on-hold')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("specialist.applications",["on-hold"])}}',true)">
                  On hold Jobs
               </li>
               <li data-tab="closed-content" class="apps-list {{($application_type == 'closed')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("specialist.applications",["closed"])}}',true)">
                  Closed Jobs
               </li>
               <li data-tab="cancel-content" class="apps-list {{($application_type == 'cancelled')?'basket-current':''}}" onclick="redirect_url($(this),'{{route("specialist.applications",["cancelled"])}}',true)">
                  Cancelled Jobs
               </li>
            </ul>
            <form class="app-form" id="job_filters" method="GET" action="">
                     <label>Filter:</label>
                     <div class="app-selectbox id-select-wrap">
                        <select class="id-select" name="job-id">
                           <option value="">Job Id</option>
                           @if($filter_job_ids)
                               @foreach($filter_job_ids as $job_id => $job_display_id)
                                 @php
                                   $selected= '';
                                   if(isset($filter_data['job-id']) && $filter_data['job-id'] == $job_id)
                                   {
                                     $selected = 'selected="selected"';
                                   }
                                 @endphp
                                 <option {{$selected}} value="{{$job_id}}">{{$job_display_id}}</option>
                               @endforeach
                           @endif
                        </select>
                     </div>
                     <div class="app-selectbox pos-select-wrap">
                        <select class="pos-select" name="position" data-placeholder = 'Position'>
                           <option value="">Position</option>
                           @foreach($filter_position_ids as $position_id => $position_name)
                             @php
                               $selected = '';
                               if(isset($filter_data['position']) && $filter_data['position'] == $position_id)
                               {
                                 $selected = 'selected="selected"';
                               }
                             @endphp
                             <option {{$selected}}  value="{{$position_id}}">{{$position_name}}</option>
                           @endforeach   
                        </select>
                     </div>
                     <div class="app-selectbox com-select-wrap">
                        <select class="careefer-select2" name="company">
                           <option>Company</option>
                           @foreach($filter_complany_ids as $company_id => $company_name)
                             @php
                               $selected = '';
                               if(isset($filter_data['company']) && $filter_data['company'] == $company_id)
                               {
                                 $selected = 'selected="selected"';
                               }
                             @endphp
                             <option {{$selected}}  value="{{$company_id}}">{{$company_name}}</option>
                           @endforeach

                        </select>
                     </div>
                     <div class="app-selectbox job-select-wrap">
                        <!-- <select class="job-select" data-search="true" placeholder="Location">
                          <option>Location</option>
                          <option>Option1</option>
                          <option>Option2</option>
                          <option>Option3</option>
                        </select> -->
                          <select name="location" class="loadAjaxSuggestion">
                            <option value="">Enter</option>
                          </select>
                     </div>
                     <ul class="form-button">
                        <li>
                           <button type="button" onclick="submit_form($(this),$('#job_filters'),true)" class="button-link apply-btn">
                              Apply
                           </button>
                        </li>
                        @if($filter_data)
                        <li>
                           <button type="button" onclick="redirect_url($(this),'{{route('specialist.applications', 'active')}}',true)" class="reset-button button">
                              Reset
                           </button>
                        </li>
                        @endif
                     </ul>
            </form>
            <div class="spc-job-ajax-render-section">   
               @include('specialistApp.applications.include.list_application_card_html')
             </div>  
            </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>
@endsection
