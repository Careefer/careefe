@php

	$url = route('web.job_detail',[$obj_job->slug]);
	if(auth()->guard('candidate')->check())
	{	
		$my_id = auth()->guard('candidate')->user()->id;
		$url .='?ref='.base64_encode($my_id);
	}

	$page_title = $obj_job->company->company_name;
	$page_title .=' - '.$obj_job->position->name;
	
@endphp

@extends('layouts.web.web')
@section('title',$page_title)
@section('page-class','job-detail-wrap')
@section('content')

<div class="detail-job-wrapper">
	<div class="container">
		<div class="job-detail-main clearfix">
			<div class="job-detail-left">
				<div class="project-job shadow">
					<div class="top-block">
						<div class="project-details">
							<div class="left-detail">
								<h2>
									@if(isset($obj_job->position->name))
										{{$obj_job->position->name}}
									@endif
									<em>
										@if(isset($obj_job->job_nature->title))
											@php
												$job_nature_icon = public_path('storage/job_nature_icons/'.$obj_job->job_nature->icon);
											@endphp	
												@if(file_exists($job_nature_icon))
													<img src="{{asset('storage/job_nature_icons/'.$obj_job->job_nature->icon)}}" alt="hot-job">
												@endif
											{{$obj_job->job_nature->title}}
										@endif
									</em>
								</h2>
								@if(isset($obj_job->company->company_name))
									<h4 class="apache-img apche-wrap">
										<img src="{{asset('assets/web/images/company.svg')}}" alt="company">
										<a target="_blank" href="{{route('web.company.detail',[$obj_job->company->slug])}}">
											{{$obj_job->company->company_name}}
										</a>
									</h4>
								@endif
								<em class="apache-img apche-wrap flag-icon">
									<img src="{{asset('assets/web/images/time.svg')}}" alt="time">
										{{$obj_job->experience_min.'-'.$obj_job->experience_max}}&nbsp&nbspyears
								</em>
								<span class="apache-img apche-wrap">
									<img src="{{asset('assets/web/images/location.svg')}}" alt="location">
									<!-- cities -->
									@if($obj_job->cities())
			                        	{{implode(', ',$obj_job->cities())}}
			                        @endif,

			                        <!-- states -->
			                        @if($obj_job->state())
			                        	{{implode(', ',$obj_job->state())}}
			                        @endif,
										
									<!-- country -->
			                        
			                        	{{($obj_job->country)?$obj_job->country->name:''}}
			                        
								</span>
								<strong class="apache-img apche-wrap project-price">
									<span class="dollar-icon">
										  	@php
												$currency_sign = '';

												if($obj_job->country->currency_sign)
												{
													$currency_sign = $obj_job->country->currency_sign->symbol;
												}

												echo $currency_sign;

										  	@endphp
									</span>
									{{$obj_job->salary_min.'-'.$obj_job->salary_max}}
								</strong>	
								@if($obj_job->work_type)
									<span class="apache-img apche-wrap">
										<img src="{{asset('assets/web/images/job.svg')}}" alt="full-time">
										{{$obj_job->work_type->name}}
									</span>
								@endif
							</div>
							<div class="right-detail">
								<em class="job-id">Job Id: {{$obj_job->job_id}}</em>

								@php
									$logo_path = public_path('storage/employer/company_logo/'.$obj_job->company->logo);

									if(file_exists($logo_path))
									{
										$logo_path = asset('storage/employer/company_logo/'.$obj_job->company->logo);
									}
									else
									{
										$logo_path = asset('storage/employer/company_logo/default.png');
									}
								@endphp
								<a target="_blank" href="{{route('web.company.detail',[$obj_job->company->slug])}}" class="project-logo">
									<img src="{{$logo_path}}" alt="">
								</a>
							</div>
						</div>
					</div>
					<div class="bottom-block">
						<ul class="vacancy-menu">
							<li>
								<span>Vacancies: </span>
								<strong>
									{{$obj_job->vacancy}}
								</strong>
							</li>
							@php
								$a_cutoff = site_config('display_no_of_applicants_after');

								$efferal_cutoff = site_config('display_no_of_referrals_after');

								$efferal_cutoff = site_config('display_no_of_referrals_after');

								$job_view_cutoff = site_config('display_total_job_view_after');
							@endphp

							@if(($obj_job->no_of_referrals ? $obj_job->no_of_referrals : 0) >= $efferal_cutoff)
								<li>
									<span>Referrals: </span>
									<strong>
										{{($obj_job->no_of_referrals)?$obj_job->no_of_referrals:0}}
									</strong>
								</li>
							@endif

							@if(($obj_job->no_of_applications ? $obj_job->no_of_applications : 0) >= $a_cutoff)
								<li>
									<span>Applicants: </span>
										<strong>
											{{($obj_job->no_of_applications)?$obj_job->no_of_applications:0}}
										</strong>
								</li>
							@endif
						</ul>
						<div class="save-menu">
							@if(($obj_job->total_views ? $obj_job->total_views : 0) >= $job_view_cutoff)
								<span class="view-detail">Views:
									
										{{($obj_job->total_views)?$obj_job->total_views:0}}
									
								</span>
							@endif
							<span>Posted:
								<strong>{{time_Ago($obj_job->created_at)}}</strong>
							</span>

							@if(auth()->guard('candidate')->check())
								@php
									$candidate_id = base64_encode(auth()->guard('candidate')->user()->id);

									$job_id = base64_encode($obj_job->id);

								@endphp
								<span class="save-star" onclick="make_job_favorite($(this),'{{$candidate_id}}','{{$job_id}}')">

										@if(is_favorite_job(auth()->guard('candidate')->user()->id,$obj_job->id))
											<img src="{{asset('assets/web/images/save-star.png')}}"
											alt="save-star">
										@else
											<img src="{{asset('assets/web/images/save-star2.png')}}">
										@endif
									Save
								</span>
							@endif
						</div>
					</div>
				</div>
				
				<form class="alerts-form" method="post" id="create_job_alert_frm" action="{{route('web.create_job_alert',[$obj_job->slug])}}">
					{{csrf_field()}}
					<label>Create Alerts</label>
					<div class="input-err"><input type="email" name="email" placeholder="Please enter email address" required="required" maxlength="50" value="{{old('email')}}">
					@if($errors->has('email'))
						<span class="err_msg">{{$errors->first('email')}}</span>
					@endif
					</div>
					<button type="button" onclick="submit_form($(this),$('#create_job_alert_frm'))">
						Subscribe
					</button>
				</form>
				<div class="job-summary shadow">
					<h3>Job Summary</h3>
					<p>
						{{$obj_job->summary}}
					</p>
					<h3>Description</h3>
					<p>
						{{$obj_job->description}}
					</p>
					<ul class="desc-menu">
						@if($obj_job->work_type)
						<li class="clearfix">
							<img src="{{asset('assets/web/images/work-icon.png')}}" alt="work-type"><strong>Work Type:</strong>
							<span>{{$obj_job->work_type->name}}</span>
						</li>
						@endif

						@if($obj_job->skills())
							<li class="clearfix">
								<img src="{{asset('assets/web/images/skill-icon.png')}}" alt="skill"><strong>Skill:</strong>
								<span>
									{{implode(', ',$obj_job->skills())}}
								</span>
							</li>
						@endif

						@if($obj_job->educations())
						<li class="clearfix">
							<img src="{{asset('assets/web/images/edu-icon.png')}}" alt="education"><strong>Education:</strong>
							<span>{{implode(', ',$obj_job->educations())}}</span>
						</li>
						@endif

						@if($obj_job->functional_area())
						<li class="clearfix">
							<img src="{{asset('assets/web/images/functional-icon.png')}}" alt="functional-area"><strong>Functional Area:</strong>
							<span>{{implode(', ',$obj_job->functional_area())}}</span>
						</li>
						@endif

						@if($obj_job->industry)
						<li class="clearfix">
							<img src="{{asset('assets/web/images/industry-icon.png')}}" alt="industry"><strong>Industry:</strong>
							<span>{{$obj_job->industry->name}}</span>
						</li>
						@endif
					</ul>
					<h3>Company Profile</h3>
					<p>
						{{$obj_job->company->about_company}}
					</p>
				</div>
				<div class="jobs-company">
					<a href="javascript:void(0)" onclick='redirect_url($(this),"{{$company_job_url}}",true)'>
						View Jobs by this company
					</a>
				</div>
				@include('webApp.job.include.similar_jobs_html')
			</div>
			@php $disable_apply = false; @endphp
			
			@if($obj_job->status !== 'active')
				<div class="searched">
					<p class="color-red">This job is on hold, please check back later.</p>
				</div>
				@php $disable_apply = true; @endphp
			@endif
			<div class="job-detail-right shadow" style="{{($disable_apply == true)?'pointer-events: none;':''}}">
				<ul class="refer-tabs clearfix">
					<li class="refer-link">
						Refer 
					</li>
					@php
					$apply_url = route('candidate.apply_job',[$obj_job->slug]);
					if(request()->get('ref'))
					{
						$apply_url.='?ref='.request()->get('ref');
					}
					@endphp
					@if(auth()->guard('candidate')->check() && auth()->guard('specialist')->check())

						@if(!empty($check_applied))
						<li class="refer-link refer-current">
							Already Applied
						</li>
						@else
						  <li class="refer-link refer-current" onclick="redirect_url($(this),'{{$apply_url}}',null,true)">
								Apply
						  </li>
						@endif  
					@elseif(auth()->guard('specialist')->check())
					@else
					 @if(!empty($check_applied))
						<li class="refer-link refer-current">
							Already Applied
						</li>
						@else
						  <li class="refer-link refer-current" onclick="redirect_url($(this),'{{$apply_url}}',null,true)">
								Apply
						  </li>
						@endif 		
					@endif
				</ul>
				<ul id="refer-tab-1" class="refer-content refer-current">
					<li class="ref-block">
						@if($obj_job->referral_bonus_amt)
							<h4>Refer &amp; Earn</h4>
							<span class="ref-bonus">
							@php 
								 $fromIsoCode = '';
								  $fromCurrencySign = '';
								 if($obj_job->country->currency_sign)
								 {
									$fromCurrencySign = $obj_job->country->currency_sign->symbol;
									$fromIsoCode = $obj_job->country->currency_sign->iso_code;
								 }

								$rateConversion = currencyRateConversion($fromIsoCode,$fromCurrencySign,$obj_job->referral_bonus_amt);
								if($rateConversion)
								{
									echo $rateConversion;
								}
							 @endphp
							{{--${{$obj_job->referral_bonus_amt}}--}}
							</span>
						@endif
						<label class="filter-container">I work at <strong>{{$obj_job->company->company_name ? $obj_job->company->company_name:''}}</strong>
							<input type="checkbox">
							<span class="filter-checkmark"></span> </label>
						<p>
							By agreeing to the above I accept that I will be entitled to referral bonus from my employer and I will not receive any referral bonus from Careefer.
						</p>
						<em class="ref-condition">You can't change this option after 12 hours from now.</em>
					</li>
					<li class="share-block">
						<h5>Refer friend(s) via</h5>
						<ul class="share-links clearfix">
							<li>
								<a target="_blank" href="https://twitter.com/intent/tweet?text={{$page_title}}&url={{$url}}"><img src="{{asset('assets/web/images/twitter.png')}}" alt="social-links"></a>
							</li>
							<li>
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url}}"><img src="{{asset('assets/web/images/facebook.png')}}" alt="social-links"></a>
							</li>
							<li>
								<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{$url}}&title={{$page_title}}&summary={{$page_title}}"><img src="{{asset('assets/web/images/linkedin-icon.png')}}" alt="social-links"></a>
							</li>
							<li>
								<a target="_blank" href="https://wa.me/?text={{$url}}"><img src="{{asset('assets/web/images/whatsapp.png')}}" alt="social-links"></a>
							</li>
						</ul>
					</li>
					<li class="email-block">
						{!! success_msg() !!}
						<form class="email-form clearfix" method="post" action="{{route('candidate.refer_job_email')}}" id="refer_job_frm">
							{{csrf_field()}}

							<input type="hidden" name="job_id" value="{{$obj_job->id}}">

							<label>Email friend(s)</label>
							<div class="mail-input input-err">
								<input type="text" name="name" placeholder="Friend's Names" maxlength="100">
								@if($errors->has('name'))
									<span class="err_msg">{{$errors->first('name')}}</span>
								@endif
							</div>
							<div class="mail-input input-err">
								<input type="text" name="friend_email" placeholder="Friend's Email" maxlength="100">
								@if($errors->has('friend_email'))
									<span class="err_msg">{{$errors->first('friend_email')}}</span>
								@endif
							</div>
							<button type="button" class="button mail-btn" onclick="submit_form($(this),$('#refer_job_frm'))">
								Send
							</button>
						</form>
					</li>
					<li class="cv-block">
						<h5>Share friend's CV</h5>
						<div class="cv-wrapper">
							@php
								$apply_url = route('candidate.friend.apply_job',[$obj_job->slug]);
								if(request()->get('ref'))
								{
									$apply_url.='?ref='.request()->get('ref');
								}
							@endphp
							<a target="_blank" href="{{$apply_url}}">
								<label for="cv-upload" class="custom-file-upload mail-btn">
									Apply
								</label>
							</a>
						</div>
					</li>
					@if(auth()->guard('candidate')->check())
					<li class="copy-block">
						<input type="hidden" value="{{$url}}">
						<a href="javascript:void(0);" class="copy-link" onclick="return copy_text($(this));">
							<img src="{{asset('assets/web/images/copy-link.png')}}" alt="copy-link">Copy Referral Link
						</a>
					</li>
					@else
					<li class="copy-block">
						<a href="{{route('candidate.login')}}?redirect={{encrypt(url()->full())}}" class="copy-link">
							<img src="{{asset('assets/web/images/copy-link.png')}}" alt="copy-link">Copy Referral Link
						</a>
					</li>
					@endif
				</ul>
				<ul id="refer-tab-2" class="refer-content hide">
					<li class="ref-block">
						<h4>Refer &amp; Earn</h4>
						<span class="ref-bonus">$160</span>
						<label class="filter-container">I work with the same Organisation
							<input type="checkbox" checked="checked">
							<span class="filter-checkmark"></span> </label>
						<p>
							I agree that work with the same organization and I will not receive any payment from Careefer. My organization will provide me the referral amount.
						</p>
						<em class="ref-condition">You can't Change the option after 12 hours for now.</em>
					</li>
					<li class="share-block separat">
						<h5>Share</h5>
						<ul class="share-links clearfix">
							<li>
								<a href="#"><img src="{{asset('assets/web/images/twitter.png')}}" alt="social-links"></a>
							</li>
							<li>
								<a href="#"><img src="{{asset('assets/web/images/facebook.png')}}" alt="social-links"></a>
							</li>
							<li>
								<a href="#"><img src="{{asset('assets/web/images/linkedin-icon.png')}}" alt="social-links"></a>
							</li>
							<li>
								<a href="#"><img src="{{asset('assets/web/images/whatsapp.png')}}" alt="social-links"></a>
							</li>
						</ul>
					</li>
					<li class="email-block separat">
						<form class="email-form clearfix">
							<label>Email friend(s)</label>
							<div class="mail-input">
								<input type="text" name="name" placeholder="Candidate's Name">
							</div>
							<div class="mail-input">
								<input type="text" name="name" placeholder="Candidate's Email">
							</div>
							<button type="button" class="button mail-btn">
								Send
							</button>
						</form>
					</li>
					<li class="copy-block">
						<input type="hidden" value="{{$url}}">
						<a href="javascript:void(0);" class="copy-link" onclick="return copy_text($(this));">
							<img src="{{asset('assets/web/images/copy-link.png')}}" alt="copy-link">Copy Link
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="bottom-image">
	Image
</div>
@endsection
