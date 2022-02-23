@extends('layouts.web.web')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
@section('content')
  <div class="dashboard-wrapper employer-main">
    <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
        <div class="main-tabs-content">
          <div class="emp-content emp-current shadow add-job" id="emp-jobs">
            <div class="btn-back">
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{ route('employer.job.view',[$obj_job->id]) }}',true);"><img src="{{asset('assets/web/images/back-btn.png')}}" alt="add-job">Edit Job</a>
            </div>
            <div class="form-msg"></div>
            <form class="add-form" id="emp_job_frm">
              {{@csrf_field()}}
              <div class="add-inner">
                <div class="form-detail clearfix">
                  <div class="form-input">
                    <label>Job Id</label>
                    <div class="disable-wrap">
                      <input type="text" placeholder="{{$obj_job->job_id}}" disabled>
                    </div>
                  </div>
                  <div class="form-input">
                    <label>Position</label>
                    <div>
                      <select class="careefer-select2 designation-select position" name="position" data-placeholder = 'Enter Job Position'>
                        @if($positions->count())
                          <option value="">Select Position</option>
                          @foreach($positions as $p_id => $p_name)
                            <option {{($obj_job->position_id == $p_id)?'selected="selected"':''}} value="{{$p_id}}">{{$p_name}}</option>
                          @endforeach
                        @endif
                       </select>
                    </div>
                  </div>
                </div>
                <div class="form-location">
                  <label class="form-label">Location</label>
                  <div class="form-outer-wrapper">
                    <div class="form-data">
                      @if($obj_job->state())
                        @php $i=0; @endphp
                        @foreach($obj_job->state() as $state_id => $state_name)
                          <div class="container-form">
                            <div class="form-detail clearfix">
                              <div class="form-input profile-input add-location color">
                                <select class="new-country-select" data-search="true" name="add_job_country" onchange="rest_rest_country_city_html(this)">
                                    <option value=""></option>
                                    @if($countries->count())
                                      @foreach($countries as $c_id => $c_name)
                                        <option {{($obj_job->country_id == $c_id)?'selected="selected"':''}} value="{{$c_id}}">{{$c_name}}</option>
                                      @endforeach
                                    @endif
                                </select>
                                <input type="hidden" value="{{$obj_job->country_id}}" class="country_id">
                              </div>

                              <div class="form-input profile-input add-state color">
                                <select class='new-state-select add_job_sates' name="add_job_state[{{$i}}]">
                                  @if($states->count())
                                    @foreach($states as $w_state_id=>$w_state_name)
                                      <option {{($state_id == $w_state_id)?"selected='selected'":""}} value="{{$w_state_id}}">{{$w_state_name}}</option>
                                    @endforeach
                                  @endif
                                </select>
                                <input type="hidden" name="temp[]">
                              </div>
                            </div>
                            @php
                              $all_cities   = $obj_city->where(['state_id'=>$state_id,'status'=>'active'])->get();
                              $job_cities = $obj_job->cities();
                            @endphp
                            <select class='new-city-select' name="add_job_city[{{$i}}][]" multiple="multiple">
                              @if($all_cities->count())
                                 @foreach($all_cities as $c_index=>$c_obj)
                                  @php
                                    $selected = '';
                                    if(isset($job_cities[$c_obj->id]))
                                    {
                                      $selected = 'selected="selected"';
                                    }
                                  @endphp
                                  <option {{$selected}} value="{{$c_obj->id}}">{{$c_obj->name}}</option>
                                 @endforeach
                              @endif
                            </select>
                          </div>
                          @php $i++; @endphp
                        @endforeach
                      @endif
                    </div>
                  </div>
                  <div class="form-btns">
                    <button class="button remove-btn" type="button">
                      <span class="cross">cross</span>Remove
                    </button>
                    <!-- removed class =add-locations -->
                    <button onclick="emp_job_add_more_location()" class="add-more button" type="button">
                      <span class="plus">plus icon</span>Add More
                    </button>
                  </div>
                </div>
                <div class="experience-add clearfix common-wrapper">
                  <div class="exp">
                    <label class="form-label">Experience</label>
                    <div class="sal-wrapper clearfix">
                      <div class="profile-input exp-min">
                        <input type="text" name="min_experience" placeholder="Min. Experience" maxlength="2" value="{{$obj_job->experience_min}}">
                      </div>
                      <div class="profile-input exp-max">
                        <input type="text" name="max_experience" placeholder="Max. Experience" maxlength="2" value="{{$obj_job->experience_max}}">
                      </div>
                    </div>
                  </div>
                  <div class="vac-wrapper">
                    <label class="form-label">Vacancies</label>
                    <div class="profile-input">
                      <input type="text" name="vacancies" placeholder="Number of Vacancies" maxlength="7" value="{{$obj_job->vacancy}}">
                    </div>
                  </div>
                </div>
                <div class="add-skill-wrap common-wrapper">
                    <label class="form-label">Skills</label>
                    <select class="careefer-select2 job-skills-select position" name="add_job_skills[]" multiple="multiple" data-placeholder = 'Enter Skills'>
                      @if($skills->count())
                      @foreach($skills as $s_id => $s_name)
                        @php
                          $selected = "";
                          if(isset($obj_job->skill_ids))
                          {
                            $job_skill_arr = explode(",",$obj_job->skill_ids);

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
                <div class="add-sal-wrap common-wrapper">
                  <label class="form-label">Salary</label>
                  <div class="add-sal-inner">
                    <span class="rs-wrapper currency-symbol"></span>
                    <div class="sal-input">
                      <div class="profile-input exp-min">
                        <input type="text" name="min_salary" placeholder="Min. Salary" maxlength="7" value="{{$obj_job->salary_min}}">
                      </div>
                      <div class="profile-input">
                        <input type="text" name="max_salary" placeholder="Max. Salary" maxlength="7" value="{{$obj_job->salary_max}}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="common-wrapper">
                  <label class="form-label">Job Summary</label>
                  <div class="profile-input">
                    <textarea placeholder="Add Job Summary" name="job_summary" maxlength="500">{{$obj_job->summary}}</textarea>
                  </div>
                </div>
                <div class="common-wrapper">
                  <label class="form-label">Job Description</label>
                  <div class="profile-input">
                    <textarea placeholder="Add Job Description" name="job_description" maxlength="500">{{$obj_job->description}}</textarea>
                  </div>
                </div>
                <div class="common-wrapper">
                  <label class="form-label">Primary Functional Area</label>
                  <div class="tagit-area add-taggit">
                    <select class="careefer-select2 job-skills-select" name="functional_area[]" multiple="multiple" data-placeholder="Enter Primary Functional Area">
                      @if($functional_area->count())
                        @foreach($functional_area as $f_id => $f_name)
                          @php
                              $selected = "";
                              if(isset($obj_job->functional_area_ids))
                              {
                                $f_arr = explode(",",$obj_job->functional_area_ids);

                                if(in_array($f_id,$f_arr))
                                {
                                  $selected = 'selected="selected"';
                                }
                              }
                          @endphp
                          <option {{$selected}} value="{{$f_id}}">{{$f_name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="edu-required">
                  <label class="form-label">Education Required</label>
                  <div class="profile-input add-edu-wrap">
                    <select class="careefer-select2 job-skills-select position" name="educations[]" multiple="multiple">
                      @if($educations->count())
                        @foreach($educations as $e_id => $e_name)
                            @php
                              $selected = "";
                              if(isset($obj_job->education_ids))
                              {
                                $e_arr = explode(",",$obj_job->education_ids);

                                if(in_array($e_id,$e_arr))
                                {
                                  $selected = 'selected="selected"';
                                }
                              }
                            @endphp
                          <option {{$selected}}  value="{{$e_id}}">{{$e_name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="add-work-wrap">
                  <label class="form-label">Work Type</label>
                  <div class="profile-input add-type-wrap">
                    <select class="careefer-select2 job-skills-select" name="work_type">
                        <option value=""></option>
                      @if($work_types->count())
                        @foreach($work_types as $w_id => $w_name)
                          <option {{($obj_job->work_type_id == $w_id)?'selected="selected"':''}} value="{{$w_id}}">{{$w_name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                @php

                  $job_status = get_job_status(optional($obj_job)->status);

                  unset($job_status['active']);
                
                @endphp
                <div class="add-work-wrap">
                  <label class="form-label">Status</label>
                  <div class="profile-input add-type-wrap">

                      <select class="careefer-select2 job-skills-select" data-placeholder="" id="status" name="status">
                        @foreach ($job_status as $key => $val)
                            <option></option>
                            <option value="{{ $key }}" {{ old('status', optional($obj_job)->status) == $key ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>

                  </div>
                </div>

                <div class="commission-wrap">
                  <label class="form-label">Careefer Fee<span class="contract">(As per your Contract)</span></label>
                  <div class="commission-inner clearfix">
                    <div class="radio-wrapper comm-radio">
                      <label class="radio-container radio-percent">Percentage
                        <input type="radio" name="commission_type" value="percentage" {{($obj_job->commission_type == 'percentage')?'checked="checked"':''}}>
                        <span class="radio-checkmark"></span> </label>
                      <label class="radio-container radio-amount">Amount
                        <input type="radio" name="commission_type" value="amount" {{($obj_job->commission_type == 'amount')?'checked="checked"':''}}>
                        <span class="radio-checkmark"></span> </label>
                    </div>
                    <div class="profile-input">
                      <input type="number" name="commission_amt" placeholder="Enter" maxlength="20" value="{{$obj_job->commission_amt}}">
                      <span class="rs-wrapper input-percent">%</span>
                      <span class="rs-wrapper input-amount">&#8377;</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="job-buttons">
                <button class="job-cancel-btn button button-link" type="button" onclick="redirect_url($(this),'{{route("employer.job.view",[$obj_job->id])}}')">
                  Cancel
                </button>
                <button id="emp_job_submit_btn" class="job-add-btn button button-link" type="button" onclick="add_edit_job('{{route('employer.job.edit.post')}}')">
                  Update
                </button>
                <input type="hidden" name="edit_id" value="{{$obj_job->id}}">
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
  <script>
    $(document).ready(function() {
        $('.position').select2({
        tags: true
      });
    });
  </script>
@endsection
