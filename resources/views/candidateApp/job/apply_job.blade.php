@extends('layouts.web.web')
@section('title','Apply Job')
@section('page-class','apply-wrapper')
@section('content')

   <div class="apply-main">
      <div class="container">
      <h1>Apply</h1>
          <div class="notice">
            <div class="form-msg"></div>
            </div>
         <form class="inner-behalf" method="post" id="candidate_apply_job_frm">
            {{csrf_field()}}
            <div class="friends-top-wrapper clearfix shadow-main">
               <div class="company-det">
                  @if(isset($obj_job->position->name))
                     <h3>
                        {{$obj_job->position->name}}
                     </h3>
                  @endif
                  <h4 onclick="redirect_url($(this),'{{route('web.company.detail',[$obj_job->company->slug])}}',true)">
                     <img src="{{asset('assets/web/images/company.svg')}}" alt="apache">
                     {{$obj_job->company->company_name}}
                  </h4>
               </div>
               <em class="job-id">Job Id: {{$obj_job->job_id}}</em>
            </div>
            <div class="upload-cv-wrapper shadow-main upload-top">
               <div class="radio-main clearfix">
                  <h4>Upload Your CV:</h4>
                  <div class="radio-wrapper clearfix">
                     <div class="cv-file-wrap">
                        <label class="radio-container radio-cv radio-active input-err" data-cv-type="old" onclick="onChageType('hide',0)">CV from Profile
                           <input type="radio" name="cv_type" value="old" checked="checked">
                           <span class="radio-checkmark"></span>
                        </label>
                        <span class="cv-title show-cv">
                           {{my_detail()->resume}}
                        </span>
                     </div>
                     <div class="cv-file-wrap">
                        <label class="radio-container radio-cv" data-cv-type="new" onclick="onChageType('show',0)">New CV
                           <input type="radio" name="cv_type" value="new" id="cv_type_new" >
                           <span class="radio-checkmark"></span>
                        </label>
                        <!-- <span class="cv-title cv-file candidate-new-cv input-err">
                              <input type="file" name="new_cv">
                        </span> -->
                     </div>
                  </div>
               </div>
               <div class="drag-file-wrapper cv-wrapper file-wrapper">
                  <div class="drag-cv">
                     <div ondrop="radio_check_cv_letter_type();" onchange="radio_check_cv_letter_type();" class="browse-text dropzone"
                        data-file-type="application/pdf,.doc,.docx"
                        data-max-size="2"
                        data-url="{{route('candidate.save_dragged_cover_letter')}}?drag=true"
                        id="drap_file_section1"
                        data-input-file-name = 'new_cv';
                        >
                          <span class="browse-img">
                              <img src="{{asset('assets/images/browse-cv.png')}}" alt="browse">
                           </span>
                          <span class="drag-files">
                          Drag and drop CV here
                           </span>
                          <span class="file-size">
                              Supported formats doc, docx, pdf, Max. upload size:  2mb
                           </span>
                     </div>
                  </div>
                  <div class="browse-cv input-err">
                     <span class="browse-or">Or</span>
                     <label for="browse-file2" onchange="radio_check_cv_letter_type();">Upload here</label>
                     <input id="browse-file2" name="new_cv" type="file" style="display:none" onchange="radio_check_cv_letter_type();">
                  </div>
               </div>
            </div>
            <div class="friend-detail-form shadow-main">

               @php
                  $current_company = '';
                  $obj_user = auth()->guard('candidate')->user();

                  if(isset($obj_user->current_company->company_name))
                  {
                     $current_company = $obj_user->current_company->company_name;
                  }
               @endphp
               <h4>Details</h4>
               <div class="form-detail clearfix">
                  <div class="form-input">
                     <label>Candidate Name
                        <span class="req-icon">*</span>
                     </label>
                     <input type="text" name="name" required="required" placeholder="Please enter name" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter name'" value="{{$obj_user->name}}" maxlength="100">
                  </div>
                  <div class="form-input">
                     <label>Candidate Email
                        <span class="req-icon">*</span>
                     </label>
                     <input type="email" name="email" placeholder="Please enter email" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter email'" value="{{$obj_user->email}}" maxlength="100">
                  </div>
               </div>
               <div class="form-detail clearfix">
                  <div class="form-input">
                     <label>Candidate Mobile Number
                        <span class="req-icon">*</span>
                     </label>
                     <input type="text" name="mobile" placeholder="Please enter mobile number" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter mobile number'" value="{{$obj_user->phone}}"  maxlength="15">
                  </div>
                  <div class="form-input">
                     <label>
                     Current Employer
                     </label>
                     <input type="text" name="current_company" placeholder="Please enter current company" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter current company'" value="{{$current_company}}">
                  </div>
               </div>
            </div>
            <div class="upload-cv-wrapper shadow-main upload-bottom">
               <div class="radio-main clearfix">
                  <h4>Upload Your Cover Letter</h4>
                  <div class="radio-wrapper clearfix">
                     <label class="radio-container input-err" onclick="onChageType('hide',1)">Cover Letter from Profile
                        <input type="radio" name="cover_letter_type" value="old" checked="checked">
                        <span class="radio-checkmark"></span>
                     </label>
                     <label class="radio-container" onclick="onChageType('show',1)">New Cover Letter
                        <input type="radio" name="cover_letter_type" value="new" id="cl_type_new">
                        <span class="radio-checkmark"></span>
                     </label>
                  </div>
               </div>
               <div class="drag-file-wrapper file-wrapper">
                  <div class="drag-cv">
                     <div ondrop="radio_check_new_cover_letter_type();" onclick="radio_check_new_cover_letter_type();" class="browse-text dropzone"
                        data-file-type="application/pdf,.doc,.docx"
                        data-max-size="2"
                        data-url="{{route('candidate.save_dragged_cover_letter')}}?drag=true"
                        id="drap_file_section2"
                        data-input-file-name = 'new_cover_letter';
                        >
                          <span class="browse-img">
                              <img src="{{asset('assets/images/browse-cv.png')}}" alt="browse">
                           </span>
                          <span class="drag-files">
                          Drag and drop CV here
                           </span>
                          <span class="file-size">
                              Supported formats doc, docx, pdf, Max. upload size:  2mb
                           </span>
                     </div>
                  </div>
                  <div class="browse-cv input-err">
                     <span class="browse-or">Or</span>
                     <label for="browse-file2" onclick="radio_check_new_cover_letter_type();">Upload here</label>
                     <input id="browse-file2" name="new_cover_letter" type="file" style="display:none" onclick="radio_check_new_cover_letter_type();">
                  </div>
               </div>
            </div>
            <div class="done-btn">
               @php
                  $url = route("candidate.apply_job.post",$obj_job->slug);
                  if(request()->get('ref'))
                  {
                     $url.='?ref='.request()->get('ref');
                  }
               @endphp
               <button id="apply_job_btn" class="button" type="button" onclick="apply_job('{{$url}}');">
               Submit
               </button>
            </div>
         </form>
      </div>
   </div>
   <div class="bottom-image">
      Image
   </div>

   @push('css')
        <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/fancy_fileupload.css')}}" media="screen">
   @endpush

   @push('js')
      <script src="{{asset('assets/web/js/jquery.ui.widget.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.fileupload.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.iframe-transport.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.fancy-fileupload.js')}}"></script>
      <script>
         Dropzone.autoDiscover = false;
         $(document).ready(function() {
             $(document).on("click","#NXReportButton",function() {
                location.href = '{{ route("web.job_detail",$obj_job->slug) }}';
            });
         }); 
         
      </script>
   @endpush

@endsection
