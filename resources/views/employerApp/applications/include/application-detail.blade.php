<div class="job-content-inner shadow">
  <div class="dashboard-main appliactions-list">
    <div class="btn-back">
      <a href="{{ route('employer.application.detail', @$application->job->slug) }}"><img src="{{ asset('assets/images/back-btn.png') }}" alt="back">Back</a>
    </div>
    <div class="project-job">
      <div class="top-block">
        <div class="top-main">
          <em class="job-id">Job Id: {{ @$application->job->job_id }}</em>
          <span class="pending">Job Status: <span class="{{ @$application->job->status }}">{{ @$application->job->status }}</span></span>
        </div>
        <div class="project-details">
          <div class="left-detail">
             <h3>{{ optional($application->job->position)->name }}</h3>
              <span class="basket-text">
                 @if($application->job->cities())
                  {{implode(', ',$application->job->cities())}}
               @endif,

               <!-- states -->
               @if($application->job->state())
                  <strong>{{implode(', ',$application->job->state())}}</strong>
               @endif,

               <!-- country -->
               <strong>
                  {{ ($application->job->country) ? $application->job->country->name:''}}
               </strong>
              </span>
            <span class="basket-text basket-work">Specialist assigned: <strong>{{ @$application->job->specialist->name }}</strong></span>
            <span class="basket-text">Posted Date: <strong>{{display_date_time($application->job->created_at)}}</strong></span>
          </div>
        </div>
      </div>
    </div>
    <div class="app-detail-wrapper">
      <div class="list-content">
        <div class="application-wrapper">
          <em class="app-id">Application Id: {{ $application->application_id }}</em>
          <div class="app-status">
             @php 
              //$application_status = ['applied' => 'Applied','in_progress' =>'In Progress', 'unsuccess' => 'Unsuccess', 'success'=>'Success', 'candidate_declined'=> 'Candidate Declined', 'hired' => 'Hired','cancelled'=> 'Cancelled']; 
            @endphp

            <Span class="status-text">Application Status:</Span>
            <div class="status-wrapper">
              <select class="sts-select" id="select-application-status">
                @foreach($application_status as $key=>$val)
                @php
                   $selected = '';
                   if(isset($application->status) && $application->status == $key)
                   {
                     $selected = 'selected="selected"';
                   }
                 @endphp
                <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
                @endforeach 
              </select>
            </div>
          </div>
        </div>
        <div class="reference-wrapper">
          <div class="ref-info">
            <span class="ref-name">{{ $application->name }}</span>
            <span class="basket-text">
              {{ (@$application->candidate->current_location) ? $application->candidate->current_location->address : '--' }}, <strong>
                {{ (@$application->candidate->get_location_by_id($application->candidate->current_location->location_id)->location) ? $application->candidate->get_location_by_id($application->candidate->current_location->location_id)->location : '--' }}</strong>
            </span>
            <a href="mailto:{{ $application->email }}" class="ref-mail">{{ $application->email }}</a>
            <a href="tel:{{ $application->mobile }}" class="basket-text basket-tel">{{ $application->mobile }}</a>
          </div>
          <div class="ref-rating">
            <span class="rating-text">Specialist rating:</span>
            <ul class="rating-star clearfix">
              
             @if(!empty($application->rating_by_specialist) && $application->rating_by_specialist > 0)
              @for($i=1; $i<=$application->rating_by_specialist ; $i++)
                <li><img src="{{asset('assets/images/rating.png')}}" alt="rating"></li>
              @endfor
              @endif

              @if(empty($application->rating_by_specialist) && $application->rating_by_specialist  <= 0)

              @php
              $rating = 5;
              @endphp

              @elseif($application->rating_by_specialist == 5)

              @php
              $rating = 0;
              @endphp


              @else 

              @php 
              $rating = 5 - $application->rating_by_specialist;
              @endphp

              @endif

              @if($rating)
              @for($i=1; $i<=$rating ; $i++)
              <li>
                <img src="{{asset('assets/images/rating-star2.png')}}" alt="rating">
              </li>
              @endfor
              @endif  

            </ul>
          </div>
        </div>
      </div>
      @if(@$application->job->status == 'cancelled')
        <div class="app-top">
          <span class="applied">Applied on: {{ display_date_time($application->created_at) }} </span>
        </div>
      @else
      <div class="app-top">
        <span class="applied">Applied on: {{ display_date_time($application->created_at) }} </span>
        <ul class="emp-msg-btn">
          <!-- <li>
            <a href="#" class="button-link view-pro">View Profile</a>
          </li> -->
          <li>
            @php
               $empId =  my_id();
               $room_data = ['jobId'=>$application->job->id,'appId'=>$application->id,'spcId'=>$application->job->primary_specialist_id,'empId'=>$empId];
               $roomId =  base64_encode(json_encode($room_data));
            @endphp
            <a href="{{url('employer/chat/'.$roomId)}}" class="button-link msg-specialist">Message Specialist</a>
            <span class="info-img"><img src="{{ asset('assets/images/info-img.png') }}" alt="info"></span>
          </li>
        </ul>
      </div>
      <div class="msg-outer">
        <ul class="main-resume">
          <li>
            <a href="{{ asset('storage/candidate/resume/'.$application->resume) }}" target="_blank"><img src="{{ asset('assets/images/img-resume.png') }}" alt="resume">CV</a>
          </li>
          <input type="hidden" id="resume_url" value="{{ asset('storage/candidate/resume/'.$application->resume) }}">

          <input type="hidden" id="filename" value="{{ $application->application_id.'_'.$application->name  }}">


          <li>
            <a href="{{ asset('storage/candidate/cover_letter/'.$application->cover_letter) }}" target="_blank"><img src="{{ asset('assets/images/cv-img.png') }}" alt="cv">Cover Letter</a>
            <input type="hidden" id="cover_url" value="{{ asset('storage/candidate/resume/'.$application->resume) }}">
          </li>
        </ul>
        <div class="export-select app-selectbox">
          <select id="export-selectbox" placeholder="Export">
            <option value="">Export</option>
            <option value="1">Download CV</option>
            <option value="2">Download Cover letter</option>
            <option value="3">Download specialist ratings, notes & other details</option>
          </select>
        </div>
      </div>
      <div class="notes-wrapper">
        <h4>Notes from Specialist</h4>
        <p>
          {{ @$application->specialist_notes }}
        </p>
      </div>
      @if(@$application->job->status != 'closed')
      <div class="rating-main">
        <div class="emp-rating">
          <span class="rating-text add-rating">Add rating:</span>
          <!-- Rating Stars Box -->
          <div class='rating-stars text-center'>
            <ul id='stars'>
              <li class='star {{ ($application->rating_by_employer >0 && $application->rating_by_employer >= 1 ) ? "selected": "" }}' title='Poor' data-value='1'>
                <i class='fa fa-star fa-fw'></i>
              </li>
              <li class='star {{ ($application->rating_by_employer >0 && $application->rating_by_employer >= 2 ) ? "selected": "" }}' title='Fair' data-value='2'>
                <i class='fa fa-star fa-fw'></i>
              </li>
              <li class='star {{ ($application->rating_by_employer >0 && $application->rating_by_employer >= 3 ) ? "selected": "" }}' title='Good' data-value='3'>
                <i class='fa fa-star fa-fw'></i>
              </li>
              <li class='star {{ ($application->rating_by_employer >0 && $application->rating_by_employer >= 4 ) ? "selected": "" }}' title='Excellent' data-value='4'>
                <i class='fa fa-star fa-fw'></i>
              </li>
              <li class='star {{ ($application->rating_by_employer >0 && $application->rating_by_employer >= 5 ) ? "selected": "" }}' title='WOW!!!' data-value='5'>
                <i class='fa fa-star fa-fw'></i>
              </li>
            </ul>
          </div>  
        </div>
      </div>
      <form class="notes-form clearfix" method="POST" action="{{ route('employer.update.employer_notes', [$application->id]) }}">
        <div class="profile-input salary-box notes-area">
        <label>Enter Salary</label>
        <input type="number" name="salary" id="salary" value="{{ $application->salary }}"  {{ ($application->salary) ? "readonly" : '' }}>  
        </div>  
        <label>My Notes</label>
        @csrf
        <div class="profile-input notes-area">
          <textarea name="employer_notes">{{ @$application->employer_notes }}</textarea>
          <input type="hidden" name="status" id="status_application" value="{{ $application->status }}">
          <input type="hidden" name="rating_by_employer" id="rating_by_employer" value="{{ $application->rating_by_employer}}">
        </div>
        @if(@$application->status !=='hired')
        <button class="button button-link notes-save" type="submit">
          Save
        </button>
        @endif
      </form>
      @else
      <div class="rating-main">
        <div class="emp-rating">
          <span class="rating-text add-rating">Rating:</span>
          <!-- Rating Stars Box -->
          <div class='rating-stars text-center'>
          <ul class="rating-star clearfix">
              
              @if(!empty($application->rating_by_employer) && $application->rating_by_employer > 0)
               @for($i=1; $i<=$application->rating_by_employer ; $i++)
                 <li><img src="{{asset('assets/images/rating.png')}}" alt="rating"></li>
               @endfor
               @endif
 
               @if(empty($application->rating_by_employer) && $application->rating_by_employer  <= 0)
 
               @php
               $rating = 5;
               @endphp
 
               @elseif($application->rating_by_employer == 5)
 
               @php
               $rating = 0;
               @endphp
 
 
               @else 
 
               @php 
               $rating = 5 - $application->rating_by_employer;
               @endphp
 
               @endif
 
               @if($rating)
               @for($i=1; $i<=$rating ; $i++)
               <li>
                 <img src="{{asset('assets/images/rating-star2.png')}}" alt="rating">
               </li>
               @endfor
               @endif  
 
             </ul>
          </div>  
        </div>
      </div>
      @endif

      @endif
     

      @if( @$application->referred_by->lastest_company->company_name  == auth()->user()->company_detail->company_name)
      <span class="remark">Remark: The candidate is referred by your employee "{{ $application->referred_by->name }}" The employee may get in touch with you in this regard.</span>
      @endif
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
$(function(){
  var status =  $('#select-application-status').val();
   if(status == 'hired'){
      $('.salary-box').show();
   }else{
    $('.salary-box').hide();
   }
});

$('.sts-select').on('selectmenuchange', function(){
 var status =  $('#select-application-status').val();
 //price_update('abc','helo', 'text');
 if(status == 'hired'){
    $('.salary-box').show();
 }else{
  $('.salary-box').hide();
 }

 if(status){
  $('#status_application').val(status);
 }   
});


$('#export-selectbox').on('selectmenuchange', function(){
  var type = $('#export-selectbox').val();
  var basic_name = $('#filename').val();
  if(type)
  {
    if(type == 1)
    {
      var filename = basic_name + '_CV.pdf'; 
      var text = $('#resume_url').val(); 
      download(filename, text); 
    }else if(type == 2){
      var filename = basic_name + '_CoverLetter.pdf'; 
      var text = $('#basic_name').val(); 
      download(filename, text); 
    }else if(type == 3){

     window.location.href = "{{ route('employer.export.application-detail', [$application->id]) }}";
    }
  }
});

function download(file, text) { 
  //creating an invisible element 
  var element = document.createElement('a'); 
  element.setAttribute('href', 'data:text/plain;charset=utf-8, ' 
                       + encodeURIComponent(text)); 
  element.setAttribute('download', file); 

  //the above code is equivalent to 
  // <a href="path of file" download="file name"> 

  document.body.appendChild(element); 

  //onClick property 
  element.click(); 

  document.body.removeChild(element); 
}

function responseMessage(msg) {
 $('#rating_by_employer').val(msg);
}

</script>
@endpush