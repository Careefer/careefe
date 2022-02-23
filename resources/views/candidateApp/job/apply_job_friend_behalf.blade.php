@extends('layouts.web.web')
@section('title',"Friend's behalf")
@section('page-class','friends-cv-wrapper')
@section('content')
	<div class="freinds-behalf">
		<div class="container">
			<h1>Share friend's CV</h1>
			@if(session('success'))
				{!! success_msg() !!}
			@else
				<div class="form-msg"></div>
			@endif
			<form class="inner-behalf" id="friend_apply_job_frm">
            	{{csrf_field()}}
				<div class="friends-top-wrapper clearfix shadow-main">
					<div class="company-det">
						@if(isset($obj_job->position->name))
							<h3>
								{{$obj_job->position->name}}
							</h3>
						@endif
						<h4>
							<img src="{{asset('assets/web/images/company.svg')}}" alt="apache">
                     		{{$obj_job->company->company_name}}
						</h4>
					</div>
					<em class="job-id">Job Id: {{$obj_job->job_id}}</em>
				</div>
				<div class="upload-cv-wrapper shadow-main">
					<h4>Upload your friend’s CV</h4>
					<div class="drag-file-wrapper">
						<div class="drag-cv">
							<div class="browse-text dropzone"
		                        data-file-type="application/pdf,.doc,.docx"
		                        data-max-size="5"
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
	                              Supported formats doc, docx, pdf, Max. upload size: 5mb
	                           </span>
		                    </div>
						</div>
						<div class="browse-cv input-err">
							<span class="browse-or">Or</span>
							<label for="browse-file">Upload here</label>
							<input id="browse-file" name="new_cv" type="file" style="display:none">
						</div>
					</div>
				</div>
				<div class="friend-detail-form shadow-main">
					<h4>Detail</h4>
					<div class="form-detail clearfix">
						<div class="form-input">
							<label>Candidate Name<span class="req-icon">*</span></label>
                     		<input type="text" name="name" required="required" placeholder="Please enter name" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter name'" value="" maxlength="100">
						</div>
						<div class="form-input">
							<label>Candidate Email<span class="req-icon">*</span></label>
							<input type="email" name="email" placeholder="Please enter email" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter email'" value="" maxlength="100">
						</div>
					</div>
					<div class="form-detail clearfix">
						<div class="form-input">
							<label>Candidate Mobile Number<span class="req-icon">*</span></label>
							<input type="text" name="mobile" placeholder="Please enter mobile number" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter mobile number'" value=""  maxlength="15">
						</div>
						<div class="form-input">
							<label>Current Employer </label>
							<input type="text" name="current_company" placeholder="Please enter current company" onfocus="this.placeholder=''" onblur="this.placeholder='Please enter current company'">
						</div>
					</div>
				</div>
				<div class="upload-cv-wrapper shadow-main upload-bottom">
					<h4>Upload your friend’s Cover Letter</h4>
					<div class="drag-file-wrapper">
						<div class="drag-cv">
							<div class="browse-text dropzone"
		                        data-file-type="application/pdf,.doc,.docx"
		                        data-max-size="5"
		                        data-url="{{route('candidate.save_dragged_cover_letter')}}?drag=true"
		                        id="drap_file_section2"
		                        data-input-file-name = 'new_cover_letter';
		                        >
	                          	<span class="browse-img">
	                              <img src="{{asset('assets/images/browse-cv.png')}}" alt="browse">
	                           	</span>
	                          	<span class="drag-files">
								  Drag and drop cover letter here
								                           	</span>
	                          	<span class="file-size">
								  Accepted files: doc, docx, pdf
	                              Supported formats  doc, docx, pdf, Max. upload size: 5mb
	                           </span>
		                    </div>
						</div>
						<div class="browse-cv input-err">
							<span class="browse-or">Or</span>
							<label for="browse-file2">Upload here</label>
							<input id="browse-file2" name="new_cover_letter" type="file" style="display:none">
						</div>
					</div>
				</div>
				<div class="friends-rating shadow-main">
					<div class="inner-rating-wrap">
						<h4>Rate your friend</h4>
						<p>
						Provide a rating for your friend based on the suitability against the job role.
						 Your referral bonus is dependent upon how well you rate your friend.

						</p>
					</div>
					<ul class="friends-star clearfix">
						<li><img src="{{asset('assets/web/images/star2.png')}}" alt="rating">
						</li>
						<li><img src="{{asset('assets/web/images/star2.png')}}" alt="rating">
							<img src="{{asset('assets/web/images/grey-star.png')}}" alt="rating" class="star-hide">
						</li>
						<li><img src="{{asset('assets/web/images/star2.png')}}" alt="rating">
							<img src="{{asset('assets/web/images/grey-star.png')}}" alt="rating" class="star-hide">
						</li>
						<li><img src="{{asset('assets/web/images/grey-star.png')}}" alt="rating">
							<img src="{{asset('assets/web/images/star2.png')}}" alt="rating" class="star-hide">
						</li>
						<li><img src="{{asset('assets/web/images/grey-star.png')}}" alt="rating">
							<img src="{{asset('assets/web/images/star2.png')}}" alt="rating" class="star-hide">
						</li>
					</ul>
				</div>
				<div class="done-btn">
					@php
	                  $url = route("candidate.friend.apply_job.post",$obj_job->slug);
	                  if(request()->get('ref'))
	                  {
	                     $url.='?ref='.request()->get('ref');
	                  }
	               @endphp
					<button id="apply_job_btn" class="button" type="button" onclick="apply_friend_job('{{$url}}');">
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
   @endpush
   
@endsection
