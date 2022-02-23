<div class="job-content-inner shadow">
  <div class="dashboard-main">
    <div class="btn-back">
      <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('employer.applications', 'active')}}',true)"><img src="{{asset('assets/images/back-btn.png')}}" alt="back">Back</a>
    </div>
    <div class="project-job">
      <div class="top-block">
        <div class="top-main">
          <em class="job-id">Job Id: {{ $jobs->job_id }}</em>
          <span class="pending">Job Status: <span class="{{ $jobs->status }}">{{ ucfirst($jobs->status) }}</span></span>
        </div>
        <div class="project-details">
          <div class="left-detail">
             @if($jobs->company->company_name)
                <h3 onclick="redirect_url($(this),'{{route('web.company.detail',[$jobs->company->slug])}}',null,true)">
                      {{$jobs->company->company_name}}
                </h3>
            @endif
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
            <span class="basket-text basket-work">Specialist assigned: <strong> {{ @$jobs->specialist->name }} </strong></span>
            <div class="emp-date-wrap">
              <span class="basket-text basket-vac">Number of applications: <strong>{{ $jobs->emp_applications() }}</strong></span>
              <span class="basket-text">Posted Date: <strong>{{display_date_time($jobs->created_at)}}</strong></span>
            </div>
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
    <form class="app-form list-form" id="filters" method="GET">
      <label>Filter:</label>
      <div class="app-form-inner">
        <div class="selected-list">

        @php 
             $application_status = ['applied' => 'Applied', 'in_progress' => 'In Progress with Specialist', 'in_progress_with_employer'=>'In Progress with Employer', 'unsuccess' => 'Unsuccess', 'success'=>'Success', 'candidate_declined'=> 'Candidate Declined', 'hired' => 'Hired','cancelled'=> 'Cancelled']; 
        @endphp

          <div class="app-selectbox status-select">
            <select class="select-status" name="application_status">
              <option value="">Application Status</option>
              @foreach($application_status as $key=>$val)

              @php
                 $selected = '';
                 if(isset($filter_data['application_status']) && $filter_data['application_status'] == $key)
                 {
                   $selected = 'selected="selected"';
                 }
               @endphp

              <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
              @endforeach
            </select>
            </div>

          <div class="app-selectbox candidate-select">
            <select class="can-select" name="candidate">
              <option value="">Candidate name</option>
              @if($candidates->count())
              @foreach($candidates as $key => $val)
                @php
                 $selected = '';
                 if(isset($filter_data['candidate']) && $filter_data['candidate'] == $key)
                 {
                   $selected = 'selected="selected"';
                 }
                @endphp
              <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
              @endforeach
              @endif
            </select>
          </div>
          <div class="app-selectbox cou-wrap job-select-wrap">
            <select name="location" class="loadAjaxSuggestion">
              <option value="{{ @$filters['location']}}">Enter</option>
            </select>
          </div>
        </div>
        <div class="wrapper-btn">
          <ul class="form-button">
          <li>
            <button type="button" class="button-link apply-btn" onclick="submit_form($(this),$('#filters'),true)">
              Apply
            </button>
          </li>
          @if($filter_data)
          <li>
            <button type="button" class="reset-button button" onclick="redirect_url($(this),'{{route('employer.application.detail', [@$jobs->slug])}}',true)">
              Reset
            </button>
          </li>
          @endif
          </ul>

          <div class="sort-option clearfix">
          @php 
          $sortBy = ["recency"=> "Recent", "alphabetical"=>"Alphabetical", "specialist"=>"Specialist Ratings", "employer"=>"Employer Rating"];
          @endphp 
          <select class="sort-selectbox" name="sortBy">
            <option>Sort</option>
            @foreach($sortBy as $key=> $val)
            @php
               $selected = '';
               if(isset($filter_data['sortBy']) && $filter_data['sortBy'] == $key)
               {
                 $selected = 'selected="selected"';
               }
            @endphp    
            <option {{$selected}} value="{{ $key }}"> {{ $val }}</option>
            @endforeach
          </select>
          </div>

        </div>
      </div>
    </form>
    <div class="spc-job-ajax-render-section">
    @include('employerApp.applications.include.card_application_detail')
    </div>
  </div>
</div>
