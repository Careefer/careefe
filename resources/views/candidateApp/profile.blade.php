@extends('layouts.web.web')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
@section('content')

   <div class="profile-wrapper">
      <div class="container">
         <h1 class="heading-tab">My Account</h1>
         <div class="main-tab-wrapper clearfix">
            @include('layouts.web.left_menue')
            <div class="main-tabs-content">
               <div class="profile-content my-profile shadow profile-current" id="profile-tab">
                  <div class="profile-top">
                     <h2>Profile</h2>
                     <button class="edit-btn button edit-enable"  type="button"><img src="{{asset('assets/images/edit-icon.png')}}" alt="edit">Edit
                     </button>
                  </div>

                  <div class="profile-detail clearfix">
                     <span class="img-profile">
                        @if($profile_data->image) 
                        <img src="{{ asset('storage/candidate/profile_pic/'.$profile_data->image) }}" alt="profile" >
                        @else
                        <img src="{{asset('assets/images/profile-img.png')}}" alt="profile">
                        @endif
                         <!-- <img src="{{asset('assets/images/profile-img.png')}}" alt="profile"> -->
                      <span class="img-edit img-circle">
                        <img src="{{asset('assets/images/edit-img2.png')}}" alt="edit">
                      </span><input type="file" id="profile_image" name="image" class="input-file">
                    </span>
                    
                     <div class="text-profile">
                        <span class="profile-name det-profile">{{$profile_data->name}}</span>
                        <a href="" class="profile-mail det-profile mail-img"><img src="{{asset('assets/web/images/msg.svg')}}" alt="mail">{{$profile_data->email}}</a>
                        @if(!empty($profile_data->official_email))
                        <a href="" class="profile-mail2 det-profile mail-img"><img src="{{asset('assets/web/images/msg.svg')}}" alt="mail">{{$profile_data->official_email}}</a>
                        @endif
                        <a href="tel:916819206371" class="det-profile mail-img profile-call"><img src="{{asset('assets/images/phone-img.png')}}" alt="mail">{{$profile_data->phone}}</a>
                     </div>
                  </div>
                  <div class="form-msg"></div>
                  <form class="profile-main-form form-disable" name="candidate_profile_frm" id="candidate_profile_frm" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data">
                     {{ csrf_field() }}

                   <div class="preference-wrapper">
                        <h3><span>Personal Info<img src="{{asset('assets/images/info-icon.png')}}" alt="info"></span></h3>
                    <div class="">
                       <div class="form-detail clearfix">

                           <div class="form-input edu-input">
                             <label>Email</label>
                             <input type="text"   name="email"  value="{{ old('email', optional($profile_data)->email) }}" {{ isset($profile_data->email)?"readonly='readonly'":""}} placeholder="Enter " >
                           </div>
                           
                           <div class="form-input edu-input">
                             <label>Work Email</label>
                             <input type="text" name="official_email" value="{{$profile_data->official_email}}" placeholder="Enter Work Email" >
                           </div>
                       </div>
                       <div class="form-detail clearfix">
                           <div class="form-input edu-input">
                             <label>Phone</label>
                             <input type="tel" name="phone" id="phone" value="{{$profile_data->phone}}" placeholder="Enter" maxlength="15">
                           </div>
                           <div class="form-input edu-input">
                             <label>Name</label>
                             <input type="text" name="name" value="{{$profile_data->name}}"  placeholder="Enter" maxlength="191">
                           </div>
                       </div>
                       <div class="stream-wrapper clearfix">
                         
                       </div>
                    </div>
                  </div>



                     <div class="preference-wrapper">
                        <h3><span>General Preferences<img src="{{asset('assets/images/info-icon.png')}}" alt="info"></span></h3>
                        <div class="general-select-wrap clearfix">
                           <div class="wrapper-selectbox wrapper-currency profile-input">
                              <label class="form-label">Currency</label>
                              <select class="careefer-select2" name="currency">
                                 <option value="">Enter Currency</option>
                                     @foreach ($currencies as  $currency)
                                        <!-- <option @if($profile_data->currency ==  $currency->id) selected="selected" @else(request()->session()->get('toIsoCode'))
                                          {{ ( $currency->iso_code == request()->session()->get('toIsoCode')) ? 'selected' : '' }} @endif value="{{ $currency->id }}">
                                          {{ $currency->name }}
                                        </option> -->
                                        <option  @if(request()->session()->get('toIsoCode'))
                                          {{ ( $currency->iso_code == request()->session()->get('toIsoCode')) ? 'selected' : '' }}
                                          @endif value="{{ $currency->id }}" >
                                          {{ $currency->name }}
                                        </option>
                                    @endforeach 
                              </select>
                           </div>
                           <div class="wrapper-selectbox wrapper-timezone profile-input">
                              <label class="form-label">Timezone.</label>
                              <select class="careefer-select2" name="timezone">
                                 <option value="">Enter Timezone</option>
                                  @foreach ($timezones as  $timezone)
                                     <option @if($profile_data->timezone ==  $timezone->id) selected="selected" @endif value="{{ $timezone->id }}">
                                       {{ $timezone->name.' - '.$timezone->text }}
                                     </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="current-loc-wrapper">
                        <h3><span>Current Address</span></h3>
                        <div class="loc-inner">
                           <div class="loc-top-wrap">
                              <div class="top-country-wrap clearfix">
                                 <div class="city-select main-select profile-input">
                                    <label class="form-label">City, State, Country</label>
                                    <select name="c_location_id" placeholder="Enter Institute Location" id="select-city" class='loadAjaxSuggestion'>
                                       @if(isset($c_location->id))
                                          <option value="{{$c_location->id}}">{{$c_location->location}}</option>
                                       @endif
                                    </select>
                                 </div>
                                 <div class="wrapper-pin">
                                    <label class="form-label">Postal Code</label>
                                    <div class="pin-wrap profile-input">
                                       <input type="text" name="c_zip_code" placeholder="Enter Postal Code" maxlength="10" value="{{optional($profile_data->current_location)->zip_code}}">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="add-wrapper">
                              <label class="form-label">Enter Address</label>
                              <div class="add-textarea profile-input">
                                 <textarea placeholder="Type...." maxlength="500" name="c_address">{{optional($profile_data->current_location)->address}}</textarea>
                              </div>
                           </div>
                           <div class="wrapper-checkbox">
                              <label class="checkbox-container">My postal address is same
                                 <input type="checkbox" onchange="can_same_permanent_location($(this))">
                                 <span class="checkmark"></span> </label>
                           </div>
                        </div>
                     </div>
                     <div class="premanent-loc">
                        <h3><span>Postal Address</span></h3>
                        <div class="loc-inner">
                           <div class="loc-top-wrap clearfix">
                              <div class="top-country-wrap clearfix">
                                 <div class="state-select main-select profile-input">
                                    <label class="form-label">City, State, Country</label>
                                    <select name="p_location_id" placeholder="City, State, Country"  class='loadAjaxSuggestion'>
                                    @if(isset($p_location->id))
                                       <option value="{{$p_location->id}}">{{$p_location->location}}</option>
                                    @endif
                                    </select>
                                 </div>
                                 <div class="wrapper-pin">
                                    <label class="form-label">Postal Code</label>
                                    <div class="pin-wrap profile-input">
                                       <input type="text" maxlength="10" name="p_zip_code" placeholder="Enter Postal Code" value="{{optional($profile_data->permanent_location)->zip_code}}">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="add-wrapper">
                              <label class="form-label">Enter Address</label>
                              <div class="add-textarea profile-input">
                                 <textarea placeholder="Type...."  maxlength="500" name="p_address">{{optional($profile_data->permanent_location)->address}}</textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="history-wrapper">
                        <h3><span>Career History</span></h3>
                        <div class="career-summary">
                           <label class="history-label"><span class="img-circle"><img src="{{asset('assets/images/profile-summary.png')}}" alt="profile"></span>Profile Summary</label>
                           <div class="profile-input add-textarea">
                              <textarea placeholder="Add description..." name="profile_summary" maxlength="500">{{$profile_data->profile_summary}}</textarea>
                           </div>
                        </div>
                        <div class="work-exp-wrapper common-summary">
                           <div class="work-child">
                              <label class="history-label"><span class="img-circle"><img src="{{asset('assets/images/work-exp.png')}}" alt="work"></span>Work Experience</label>
                              <div class="work-exp-main" id="spc_profile_job_sec">
                                 @if($profile_data->career_history->count())
                                  @foreach($profile_data->career_history as $key_job => $obj_job)
                                 <div class="work-exp-inner">
                                    <div class="wrap-form-detail">
                                       <div class="form-detail clearfix">
                                          <div class="form-input">
                                             <label>Company</label>
                                             <input type="text" name="company[]" 
                                             placeholder="Enter company name" onfocus="this.placeholder=''"
                                              onblur="this.placeholder='Enter company name'" maxlength="191" value="{{optional($obj_job)->company_name}}">
                                          </div>
                                          <div class="form-input">
                                             <label>Designation</label>
                                             <select class="careefer-select2 designation-select position" name="designation[]">
                                              @if($designations->count())
                                                <option value="">Select Position</option>
                                                @foreach($designations as $d_id => $d_name)
                                                  <option {{($obj_job->designation_id == $d_id)?"selected='selected'":''}} value="{{$d_id}}">{{$d_name}}</option>
                                                @endforeach
                                              @else
                                                <option value="">Data not found</option>
                                              @endif
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-detail clearfix">
                                          <div class="form-input edit-select-wrap">
                                             <label>Job Location</label>
                                             @php
                                              $job_location_arr = $profile_data->get_location_by_id($obj_job->location_id);
                                             @endphp
                                             
                                            <select name="job_location_id[]" placeholder="City, State, Country" class="loadAjaxSuggestion">
                                                 @if($job_location_arr)
                                                   <option value="{{$job_location_arr->id}}">{{$job_location_arr->location}}</option>
                                                 @endif
                                             </select>
                                          </div>
                                          <div class="form-input mul-skill-select">
                                             <label>Skills</label>

                                             <select class="careefer-select2 job-skills-select career-job-skills position"  data-placeholder="Add Skills" name="job_skills_{{$key_job}}[]" multiple="multiple">
                                            @if($skills->count())
                                            @foreach($skills as $s_id => $s_name)

                                              @php
                                                  $selected = "";
                                                if(isset($obj_job->job_skill_ids))
                                                {
                                                  $job_skill_arr = explode(",",$obj_job->job_skill_ids);

                                                  if(in_array($s_id,$job_skill_arr))
                                                  {
                                                    $selected = 'selected="selected"';
                                                  }
                                                }
                                              @endphp

                                              <option {{$selected}} value="{{$s_id}}">{{$s_name}}</option>
                                            @endforeach
                                           @endif
                                          </select>
                                          </div>
                                       </div>
                                    </div>
                                    <label class="form-label">Role & Responsibilities</label>
                                    <div class="add-textarea profile-input">
                                       <textarea placeholder="Describe role and responsibilities" name="roles_responsibilities[]" maxlength="500">{{optional($obj_job)->roles_responsibilities}}</textarea>
                                    </div>
                                    <div class="date-picker-wrapper clearfix">
                                       <div class="start-date com-date">
                                          <label class="form-label">
                                            Start Date
                                          </label>
                                          <div class="profile-input">
                                             <input type="text" class="datepicker" name="job_start_date[]" value="{{ !empty($obj_job->start_date)?displayDateFormat($obj_job->start_date):''}}">
                                          </div>
                                       </div>
                                       <div class="end-date com-date working-check" id="end[{{$key_job}}]">
                                          <label class="form-label">End Date</label>
                                          <div class="profile-input">
                                             <input type="text" class="end-picker date-form-msg" name="job_end_date[]" value="{{ !empty($obj_job->end_date)?displayDateFormat($obj_job->end_date):''}}">
                                          </div>
                                          
                                       </div>
                                    </div>
                                    <label class="checkbox-container label-check" onclick="checkvalue(event,'<?php echo $key_job;?>')">I am currently working here
                                       <input name="currently_working[{{$key_job}}]" type="checkbox" class="currently_working_check" id="currently_working[{{$key_job}}]"  {{($obj_job->is_current_company == 'yes')?'checked':''}}>
                                       <span class="checkmark"></span> </label>
                                    <label class="form-label">Key Achievements</label>
                                    <div class="add-textarea profile-input">
                                       <textarea placeholder="Summarize Career Highlights" name="key_achievements[]" maxlength="500">{{optional($obj_job)->key_achievements}}</textarea>
                                    </div>
                                    <label class="form-label">Additional Information</label>
                                    <div class="add-text-wrapper">
                                       <div class="add-textarea profile-input last-textarea">
                                          <textarea placeholder="Anything further you would like to mention" maxlength="500" name="additional_information[]">{{optional($obj_job)->additional_information}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 @endforeach
                                @else
                                <div class="work-exp-inner">
                                    <div class="wrap-form-detail">
                                      <div class="form-detail clearfix">
                                        <div class="form-input">
                                          <label>Company</label>
                                          <input type="text" name="company[]" placeholder="Company name " onfocus="this.placeholder=''" onblur="this.placeholder='Company name'" maxlength="191">
                                        </div>
                                        <div class="form-input">
                                          <label>Designation</label>
                                         <select class="careefer-select2 designation-select position" name="designation[]">
                                           @if($designations->count())
                                            <option value="">Select Position</option>
                                            @foreach($designations as $d_id => $d_name)
                                              <option value="{{$d_id}}">{{$d_name}}</option>
                                            @endforeach
                                            @else
                                                <option value="">Data not found</option>
                                           @endif
                                         </select>
                                        </div>
                                      </div>
                                      <div class="form-detail clearfix">
                                        <div class="form-input edit-select-wrap">
                                          <label>Job Location</label>
                                          <select name="job_location_id[]" placeholder="City, State, Country" class="loadAjaxSuggestion">
                                          </select>
                                        </div>
                                        <div class="form-input">
                                          <label>Skills</label>
                                          <select class="careefer-select2  job-skills-select career-job-skills position"  data-placeholder="Add Skills" name="job_skills_0[]" multiple="multiple">
                                            @if($skills->count())
                                            @foreach($skills as $s_id => $s_name)
                                              <option value="{{$s_id}}">{{$s_name}}</option>
                                            @endforeach
                                           @endif
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <label class="form-label">Roles &amp; Responsibilities</label>
                                    <div class="add-textarea profile-input">
                                      <textarea placeholder="Type...." name="roles_responsibilities[]" maxlength="500"></textarea>
                                    </div>
                                    <div class="date-picker-wrapper clearfix">
                                      <div class="start-date com-date">
                                        <label class="form-label">Start Date</label>
                                        <div class="profile-input">
                                          <input type="text" name="job_start_date[]" class="datepicker">
                                        </div>
                                      </div>
                                      <div class="end-date com-date">
                                        <label class="form-label">End Date</label>
                                        <div class="profile-input">
                                          <input type="text" class="end-picker"  name="job_end_date[]">
                                        </div>
                                      </div>
                                    </div>
                                    <label class="checkbox-container label-check">I am currently working here
                                      <input type="checkbox" class="currently_working_check">
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="form-label">Key Achievements</label>
                                    <div class="add-textarea profile-input">
                                      <textarea placeholder="Summarize Career Highlights" name="key_achievements[]"  maxlength="500"></textarea>
                                    </div>
                                    <label class="form-label">Additional Information</label>
                                    <div class="add-text-wrapper">
                                      <div class="add-textarea profile-input last-textarea">
                                        <textarea placeholder="Type...." maxlength="500" name="additional_information[]"></textarea>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                              </div>
                           </div>
                           <div class="btn-wrap">
                              <button type="button" class="button del" onclick="spc_job_del()"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                              </button>
                              <button class="add-more button add-info-btn" type="button" onclick="can_carrer_add_more();">
                                 <span class="plus">plus icon</span>Add More
                              </button>
                           </div>
                        </div>
                     </div>
                     <div class="edu-history-wrapper common-summary">
                        <div class="edu-main">
                          <label class="history-label"><span class="img-circle"><img src="{{asset('assets/images/edu-img.png')}}" alt="work"></span>Education</label>
                          <div class="edu-outer">
                             @if($profile_data->education_history->count())
                                @foreach($profile_data->education_history as $edu_key => $obj_edu)
                             <div class="edu-inner">
                                <div class="form-detail clearfix">
                                   <div class="form-input edu-input">
                                    <label>Qualification</label>
                                     <select class="careefer-select2 qualification-select" name="qualification[]">
                                      @if($educations->count())
                                        <option value="">Select Qualification</option>
                                        @foreach($educations as $d_id => $d_name)
                                          <option {{($obj_edu->qualification == $d_name)?"selected='selected'":''}} value="{{$d_name}}">{{$d_name}}</option>
                                        @endforeach
                                      @else
                                        <option value="">Data not found</option>
                                      @endif
                                     </select>

                                      {{--<label>Qualification</label>
                                      <input type="text" name="qualification[]" placeholder="Diploma, Bachelor, Masters, Post Doctoral Degree, etc." maxlength="50" value="{{optional($obj_edu)->qualification}}">--}}
                                   </div>
                                   <div class="form-input edu-input">
                                      <label>Course</label>
                                      <input type="text" name="course[]" placeholder="Enter Course Name" maxlength="50" value="{{optional($obj_edu)->course}}">
                                   </div>
                                </div>
                                <div class="form-detail clearfix">
                                   <div class="form-input edu-input">
                                      <label>Institute</label>
                                      <input type="text" name="institute[]" placeholder="University, College Name, etc." maxlength="191" value="{{optional($obj_edu)->institute}}">
                                   </div>
                                   <div class="form-input edu-input">
                                      <label>Specialization</label>
                                      <input type="text" name="degree[]" placeholder="Enter Specialization(s)" maxlength="191" value="{{optional($obj_edu)->degree}}">
                                   </div>
                                </div>
                                <div class="form-detail clearfix">
                                   <div class="form-input edu-input">
                                      <div class="grade-type clearfix">
                                         <label class="grade-label">Grade</label>
                                         <div class="radio-wrapper clearfix grade-radio">
                                            <label class="radio-container">GPA
                                               <input type="radio" name="grade[{{$edu_key}}]" value="gpa" checked="checked" {{($obj_edu->grade == "gpa")?'checked':''}}>
                                               <span class="radio-checkmark"></span> </label>
                                            <label class="radio-container">Percentage
                                               <input type="radio" name="grade[{{$edu_key}}]"  value="percentage" {{($obj_edu->grade == "percentage")?'checked':''}}>
                                               <span class="radio-checkmark"></span> </label>
                                         </div>
                                      </div>
                                      <input type="text"  name="grade_data[]" placeholder="Enter" value="{{optional($obj_edu)->grade_data}}">
                                   </div>
                                   <div class="form-input profile-input edu-country">
                                      <label>Country</label>
                                      <select class="new-country-select" placeholder="Enter" data-search="true" name="edu_country_ids[]"> 
                                            @forelse($countries as $c_id => $c_name)
                                            <option {{($obj_edu->country_id == $c_id)?'selected="seected"':""}} value="{{$c_id}}">{{$c_name}}</option>
                                           @empty
                                            <option value="">No data found</option>
                                          @endforelse
                                          </select>
                                       
                                   </div>
                                </div>
                                <div class="form-detail clearfix end-inner-wrapper">
                                   <div class="form-input profile-input edu-country">
                                      <label>State</label>
                                      
                                      <select class='new-state-select' placeholder="Enter" name="edu_state_ids[]">
                                            @php
                                              $country_id = $obj_edu->country_id;
                                              $states = $obj_state->where(['country_id'=>$country_id,'status'=>'active'])->get();
                                            @endphp

                                              @if($states->count())
                                                <option value="">Enter</option>
                                                @foreach($states as $s_index=>$s_obj)
                                                  <option {{($s_obj->id == $obj_edu->state_id)?'selected="selected"':""}} value="{{$s_obj->id}}">{{$s_obj->name}}</option>
                                                @endforeach
                                              @endif
                                          </select>
                                   </div>
                                   <div class="form-input profile-input edu-country">
                                      <label>City</label>
                                         @php
                                            $state_id = $obj_edu->state_id;
                                            $cities   = $obj_city->where(['state_id'=>$state_id,'status'=>'active'])->get();
                                          @endphp
                                          <select class='new-city-select' placeholder="Enter" name="edu_city_ids[]">
                                            @if($cities->count())
                                              <option value="">Enter</option>
                                             @foreach($cities as $c_index=>$c_obj)
                                              <option {{($c_obj->id == $obj_edu->city_id)?'selected="selected"':""}} value="{{$c_obj->id}}">{{$c_obj->name}}</option>
                                             @endforeach
                                            @else
                                             <option value="">Enter</option>
                                            @endif
                                          </select>
                                   </div>
                                </div>
                                <div class="date-picker-wrapper clearfix">
                                   <div class="start-date com-date">
                                      <label class="form-label">Start Date</label>
                                      <div class="profile-input">
                                         <input type="text" class="datepicker" name="edu_start_date[]" value="{{ !empty($obj_edu->start_date)?displayDateFormat($obj_edu->start_date):''}}">
                                      </div>
                                   </div>
                                   <div class="end-date com-date">
                                      <label class="form-label">End Date</label>
                                      <div class="profile-input">
                                         <input type="text" class="datepicker" name="edu_end_date[]" value="{{ !empty($obj_edu->end_date)?displayDateFormat($obj_edu->end_date):''}}">
                                      </div>
                                   </div>
                                </div>
                                <label class="checkbox-container label-check">I am currently pursuing
                                   <input type="checkbox"  {{($obj_edu->currently_pursuing == "yes")?'checked':''}} class="edu-current-purshing-check" name="currently_pursuing[{{$edu_key}}]">
                                   <span class="checkmark"></span> </label>
                                <div class="stream-wrapper clearfix">
                                   <label class="form-label">Stream/Specialization</label>
                                    <div class="stream-outer">
                                    <div class="inner-stream">
                                      <div class="profile-input stream-input">
                                         <input type="text" placeholder="Type...." name="specialization[]" maxlength="255" value="{{optional($obj_edu)->specialization}}">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                             </div>
                             @endforeach
                           @else
                             <div class="edu-inner">
                               <div class="form-detail clearfix">
                                 <div class="form-input edu-input">
                                   <label>Qualification</label>
                                  <select class="careefer-select2 qualification-select" name="qualification[]">
                                    @if($educations->count())
                                     <option value="">Select Position</option>
                                     @foreach($educations as $d_id => $d_name)
                                       <option value="{{$d_name}}">{{$d_name}}</option>
                                     @endforeach
                                     @else
                                         <option value="">Data not found</option>
                                    @endif
                                  </select>

                                   {{--<label>Qualification</label>
                                   <input type="text"  name="qualification[]" placeholder="Diploma, Bachelor, Masters, Post Doctoral Degree, etc." maxlength="50">--}}
                                 </div>
                                 <div class="form-input edu-input">
                                   <label>Course</label>
                                   <input type="text"  name="course[]" placeholder="Enter Course Name" maxlength="50">
                                 </div>
                               </div>
                               <div class="form-detail clearfix">
                                 <div class="form-input edu-input">
                                   <label>Institue</label>
                                   <input type="text" name="institute[]" placeholder="University, College Name, etc." maxlength="191">
                                 </div>
                                 <div class="form-input edu-input">
                                   <label>Specialization</label>
                                   <input type="text" name="degree[]" placeholder="Enter Specialization(s)" maxlength="191">
                                 </div>
                               </div>
                               <div class="form-detail clearfix">
                                 <div class="form-input edu-input">
                                   <div class="grade-type clearfix">
                                     <label class="grade-label">Grade</label>
                                     <div class="radio-wrapper clearfix grade-radio">
                                       <label class="radio-container">GPA
                                         <input type="radio" name="grade[0]" checked="checked" value="gpa">
                                         <span class="radio-checkmark"></span> </label>
                                       <label class="radio-container">Percentage
                                         <input type="radio" name="grade[0]" value="percentage">
                                         <span class="radio-checkmark"></span> </label>
                                     </div>
                                   </div>
                                   <input type="text" name="grade_data[]" placeholder="Enter">
                                 </div>
                                 <div class="form-input profile-input edu-country">
                                   <label>Country</label>
                                   <select class="new-country-select" placeholder="Enter" data-search="true" name="edu_country_ids[]">
                                     <option value="">Enter</option>
                                     @forelse($countries as $c_id => $c_name)
                                       <option value="{{$c_id}}">{{$c_name}}</option>
                                     @empty
                                      <option value="">No data found</option>
                                     @endforelse
                                   </select>
                                 </div>
                               </div>
                               <div class="form-detail clearfix end-inner-wrapper">
                                 <div class="form-input profile-input edu-country">
                                   <label>State</label>
                                   <select class='new-state-select' placeholder="Enter" name="edu_state_ids[]">
                                      <option value="">Enter</option>
                                   </select>
                                </div>
                                 <div class="form-input profile-input edu-country">
                                   <label>City</label>
                                   <select class='new-city-select' placeholder="Enter" name="edu_city_ids[]">
                                      <option value="">Enter</option>
                                   </select>
                                 </div>
                               </div>
                               <div class="date-picker-wrapper clearfix">
                                 <div class="start-date com-date">
                                   <label class="form-label">Start Date</label>
                                   <div class="profile-input">
                                     <input type="text" class="datepicker" name="edu_start_date[]">
                                   </div>
                                 </div>
                                 <div class="end-date com-date">
                                   <label class="form-label">End Date</label>
                                   <div class="profile-input">
                                     <input type="text" class="datepicker" name="edu_end_date[]">
                                   </div>
                                 </div>
                               </div>
                               <label class="checkbox-container label-check">I am currently pursuing
                                 <input type="checkbox" checked="checked" class="edu-current-purshing-check" name="currently_pursuing[0]">
                                 <span class="checkmark"></span> </label>
                               <div class="stream-wrapper clearfix">
                                 <label class="form-label">Stream/Specialization</label>
                                 <div class="stream-outer">
                                   <div class="inner-stream">
                                     <div class="profile-input stream-input">
                                       <input type="text" placeholder="Type...." name="specialization[]"  maxlength="255">
                                     </div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                             @endif
                          </div>
                        </div>
                        <div class="btn-wrap">  
                           <button type="button" class="button del spc_edu_del_btn" onclick="spc_edu_del()"><img src="{{asset('assets/images/delete.png')}}" alt="delete" class="del-img">Delete
                           </button>                                 
                           <button class="add-more button add-info-btn" type="button" onclick="can_edu_history_add_more();">
                              <span class="plus">plus icon</span>Add More
                           </button>
                        </div>
                     </div>
                     <div class="skills-wrapper common-summary">
                        <label class="history-label"><span class="img-circle"><img src="{{asset('assets/images/skills-img.png')}}" alt="work"></span>Skills</label>
                        <label class="form-label">Skills</label>
                        <div class="profile-input">
                           <select class="careefer-select2  job-skills-select position" data-placeholder="Add Skills" name="skills[]" multiple="multiple">
                              @if($skills->count())
                              @foreach($skills as $s_id => $s_name)
                                  @php
                                      $selected = "";
                                    if(isset($profile_data->skill_ids))
                                    {
                                      $skill_arr = explode(",",$profile_data->skill_ids);

                                      if(in_array($s_id,$skill_arr))
                                      {
                                        $selected = 'selected="selected"';
                                      }
                                    }
                                  @endphp
                                <option {{$selected}} value="{{$s_id}}">{{$s_name}}</option>
                              @endforeach
                             @endif
                            </select>
                        </div>
                     </div>
                     <div class="wrapper-upload">
                        <label class="history-label">
                          <span class="img-circle">
                            <img src="{{asset('assets/images/upload-img.png')}}" alt="work">
                          </span>
                            Upload
                        </label>
                          @if($profile_data->resume)  
                            <label class="form-label" >
                              <a class="view-all" target="_blank" download 
                              href="{{asset('storage/candidate/resume/'.$profile_data->resume)}}" 
                              >
                                View CV
                              </a>
                            </label>
                          @endif 
                        <div class="resume-drag">
                           <label class="form-label">Upload CV</label>
                           <div class="drag-file-wrapper">
                              <div class="drag-cv">

                                 <div class="browse-text dropzone"
                                    data-file-type="application/pdf,.doc,.docx"
                                    data-max-size="5"
                                    data-url="{{route('candidate.upload_resume')}}?drag=true"
                                    id="drap_file_section1"
                                    data-input-file-name = 'resume';
                                    >
                                      <span class="browse-img">
                                        <img src="{{asset('assets/images/browse-cv.png')}}" alt="browse">
                                      </span>
                                      <span class="drag-files">
                                      Drag and drop CV here
                                      </span>
                                      <span class="file-size">
                                      Accepted files: doc, docx, pdf
                                     </span>
                                </div>
                             
                              </div>
                              <div class="browse-cv input-err">
                                 <span class="browse-or">Or</span>
                                 <label for="browse-file3">Upload here</label>
                                 <input id="browse-file3" name="resume" type="file" style="display:none">
                              </div>
                           </div>
                        </div>
                        <div class="resume-drag">
                           <label class="form-label">Upload Cover Letter</label>
                           @if($profile_data->cover_letter)  
                            <label class="form-label" >
                              <a class="view-all" target="_blank" 
                              download 
                              href="{{asset('storage/candidate/cover_letter/'.$profile_data->cover_letter)}}" 
                              >
                                View cover letter
                              </a>
                            </label>
                          @endif
                           <div class="drag-file-wrapper">
                              <div class="drag-cv">

                                 <div class="browse-text dropzone"
                                  data-file-type="application/pdf,.doc,.docx"
                                  data-max-size="5"
                                  data-url="{{route('candidate.upload_cover_letter')}}?drag=true"
                                  id="drap_file_section2"
                                  data-input-file-name = 'cover_letter';
                                  >
                                    <span class="browse-img">
                                      <img src="{{asset('assets/images/browse-cv.png')}}" alt="browse">
                                    </span>
                                    <span class="drag-files">
                                    Drag and drop cover letter here
                                    </span>
                                    <span class="file-size">
                                    Accepted files: doc, docx, pdf
                                   </span>
                              </div>

                              </div>
                              <div class="browse-cv input-err">
                                 <span class="browse-or">Or</span>
                                 <label for="browse-file4">Upload here</label>
                                 <input id="browse-file4" name="cover_letter" type="file" style="display:none">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="edit-btn-outer">
                        <div class="profile-edit-btn">
                           <button type="button" class="button cancel" onclick="location.reload()">
                              Cancel
                           </button>
                           <button type="button" id="spc_profile_submit_btn" class="button save" onclick="update_cand_profile()">
                              Save
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>

   @push('css')
   
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/intlTelInput.css')}}">
      <!-- <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/fancy_fileupload.css')}}" media="screen">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/selectstyle.css')}}" media="screen">
     <link rel="stylesheet" href="{{asset('assets/easy_autocomplete/easy-autocomplete.min.css')}}">
     <link rel="stylesheet" href="{{asset('assets/easy_autocomplete/easy-autocomplete.themes.min.css')}}"> -->
   
   @endpush

   @push('js')
      <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
      <!-- <script src="{{asset('assets/web/js/jquery.ui.widget.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.fileupload.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.iframe-transport.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.fancy-fileupload.js')}}"></script>
      <script src="{{asset('assets/web/js/selectstyle.js')}}"></script>
      <script src="{{asset('assets/web/js/inview.js')}}"></script>
     <script src="{{asset('/assets/easy_autocomplete/jquery.easy-autocomplete.min.js')}}"></script>
     <script src="{{asset('assets/web/js/select2.min.js')}}"></script> -->
     <script>
     $(document).ready(function()
     {
         $('#profile_image').change(function(){
             $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                 });
             var data = new FormData();
             data.append('file', $('#profile_image')[0].files[0]);
              $.ajax({
                  type: 'POST',
                  url: "{{route('candidate.update.profile-pic')}}",
                  data: data, 
                  processData: false, 
                  contentType: false, 
                  
                  success: function (data) {
                    if(data.is === 'failed')
                    {
                         $('.form-msg').html('<span class="color-red">'+data.error+'</span>');
    
                     }
                     else if(data.status == 'success')
                     { 
                         $('.form-msg').html('<span class="success_msg">'+data.msg+'</span>');

                        setTimeout(function(){
                          location.reload();
                        },2000)
                     }

                     $('html, body').animate({
                         scrollTop: $(".main-tabs-content").offset().top
                     }, 1000);
                     
                  },
              });

         }); 
         var input = document.querySelector("#telephone");
       if(input) {
    window.intlTelInput(input,({
       utilsScript: "{{asset('assets/js/utils.js')}}"
     }));
       }
       
     var input = $("#telephone");
     if(input) {
input.on("countrychange", function() {
// console.log(input.intlTelInput("getSelectedCountryData").dialCode)
// iti__selected-dial-code
//     input.val(input.val())
});
}

     });
   
     </script>

     <script>
        Dropzone.autoDiscover = false;
       $(document).ready(function() {
		   console.log("asdasdasdasd");
           $('.position').select2({
           tags: true
         });

         let el = $('.work-exp-inner');
         if(el && el.length>0){
            for(let i=0;i<el.length;i++){
               let val = document.getElementById('currently_working'+'['+parseInt(i)+']');
          let endDiv = document.getElementById('end'+'['+parseInt(i)+']');
          console.log(val,endDiv);
          if(val.checked){
            endDiv.style.opacity=0;
          }else{
            endDiv.style.opacity=1;
          }
            }
         }
       });



       function checkvalue(event,id){
          let val = document.getElementById('currently_working'+'['+parseInt(id)+']');
          let endDiv = document.getElementById('end'+'['+parseInt(id)+']');
          if(val.checked){
            endDiv.style.opacity=0;
          }else{
            endDiv.style.opacity=1;
          }
       }
     </script>
   @endpush

@endsection


