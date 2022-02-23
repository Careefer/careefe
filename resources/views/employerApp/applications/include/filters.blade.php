<form class="app-form" id="job_filters" method="GET" action="">
  <label>Filter:</label>
    <div class="app-selectbox id-select-wrap">
      <select class="careefer-select2" name="job-id" data-placeholder = 'Job Id'>
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
      <select class="careefer-select2" name="position" data-placeholder = 'Position'>
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
      <select class="careefer-select2" name="specialist" data-placeholder = 'Specialist'>
         <option value="">Specialist</option>
         @foreach($filter_specialist_ids as $specialist_id => $specialist_name)
           @php
             $selected = '';
             if(isset($filter_data['specialist']) && $filter_data['specialist'] == $specialist_id)
             {
               $selected = 'selected="selected"';
             }
           @endphp
           <option {{$selected}}  value="{{$specialist_id}}">{{$specialist_name}}</option>
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
         <button type="button" onclick="redirect_url($(this),'{{route('employer.applications', 'active')}}',true)" class="reset-button button">
            reset
         </button>
      </li>
      @endif
    </ul>
</form>