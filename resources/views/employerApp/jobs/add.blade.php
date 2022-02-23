@extends('layouts.web.web')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
@section('content')
@section('body-class','addblade-job-listing')
  <div class="dashboard-wrapper employer-main">
    <div class="container">
      <h1 class="heading-tab">My Account</h1>
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
        <div class="main-tabs-content">
          <div class="emp-content emp-current shadow add-job" id="emp-jobs">
            <div class="btn-back">
              <a href="javascript:void(0);" onclick="redirect_url($(this),'{{ route('employer.job.listing') }}',true);"><img src="{{asset('assets/web/images/back-btn.png')}}" alt="add-job">Add Job</a>
            </div>
            <div class="form-msg"></div>
            <form class="add-form" id="emp_job_frm">
              {{@csrf_field()}}
              <div class="add-inner">
                <div class="form-detail clearfix">
                  <div class="form-input">
                    <label>Job Id</label>
                    <div class="disable-wrap">
                      <input type="text" placeholder="{{$job_id}}" disabled>
                    </div>
                  </div>
                  <div class="form-input">
                    <label>Position</label>
                    <div>
                      <select class="careefer-select2 designation-select position" name="position" data-placeholder = 'Enter Job Position' >
                        @if($positions->count())
                          <option value="">Select Position</option>
                          @foreach($positions as $p_id => $p_name)
                            <option  value="{{$p_id}}">{{$p_name}}</option>
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
                      <div class="container-form">
                        <div class="form-detail clearfix">
                          <div class="form-input profile-input add-location color">
                            <select class="new-country-select" data-search="true" name="add_job_country" onchange="rest_rest_country_city_html(this);">
                                <option value=""></option>
                                @if($countries->count())
                                  @foreach($countries as $c_id => $c_name)
                                    <option value="{{$c_id}}">{{$c_name}}</option>
                                  @endforeach
                                @endif
                            </select>
                          </div>
                          <div class="form-input profile-input add-state color">
                            <select class='new-state-select add_job_sates' name="add_job_state[0]">
                              <option value="">Select</option>
                            </select>
                            <input type="hidden" name="temp[]">
                          </div>
                        </div>
                        <select class='new-city-select' name="add_job_city[0][]" multiple="multiple">
                        </select>
                      </div>
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
                        <input type="text" name="min_experience" placeholder="Min. Experience" maxlength="2">
                      </div>
                      <div class="profile-input exp-max">
                        <input type="text" name="max_experience" placeholder="Max. Experience" maxlength="2">
                      </div>
                    </div>
                  </div>
                  <div class="vac-wrapper">
                    <label class="form-label">Vacancies</label>
                    <div class="profile-input">
                      <input type="number" name="vacancies" placeholder="Number of Vacancies" min="0" oninput="validity.valid||(value='');" maxlength="8">
                    </div>
                  </div>
                </div>
                <div class="add-skill-wrap common-wrapper">
                    <label class="form-label">Skills</label>
                    <select class="careefer-select2 job-skills-select position" name="add_job_skills[]" multiple="multiple" data-placeholder = 'Enter Skills'>
                      @if($skills->count())
                      @foreach($skills as $s_id => $s_name)
                        <option value="{{$s_id}}">{{$s_name}}</option>
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
                        <input type="text" name="min_salary" placeholder="Min. Salary" maxlength="7">
                      </div>
                      <div class="profile-input">
                        <input type="text" name="max_salary" placeholder="Max. Salary" maxlength="7">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="common-wrapper">
                  <label class="form-label">Job Summary</label>
                  <div class="profile-input">
                    <textarea placeholder="Add Job Summary" name="job_summary" maxlength="500"></textarea>
                  </div>
                </div>
                <div class="common-wrapper">
                  <label class="form-label">Job Description</label>
                  <div class="profile-input">
                    <textarea placeholder="Add Job Description" name="job_description" maxlength="500"></textarea>
                  </div>
                </div>
                <div class="common-wrapper">
                  <label class="form-label">Primary Functional Area</label>
                  <div class="tagit-area add-taggit">
                    <select class="careefer-select2 job-skills-select" name="functional_area[]" multiple="multiple"  data-placeholder="Enter Primary Functional Area">
                      @if($functional_area->count())
                        @foreach($functional_area as $f_id => $f_name)
                          <option value="{{$f_id}}">{{$f_name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="edu-required">
                  <label class="form-label">Education Required</label>
                  <div class="profile-input add-edu-wrap">
                    <select class="careefer-select2 job-skills-select position" data-placeholder = 'Enter education' name="educations[]" multiple="multiple">
                      @if($educations->count())
                        @foreach($educations as $e_id => $e_name)
                          <option value="{{$e_id}}">{{$e_name}}</option>
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
                          <option value="{{$w_id}}">{{$w_name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="commission-wrap">
                  <label class="form-label">Careefer Fee<span class="contract">(As per your Contract)</span></label>
                  <div class="commission-inner clearfix">
                    <div class="radio-wrapper comm-radio">
                      <label class="radio-container radio-percent">Percentage
                        <input type="radio" name="commission_type" checked="checked" value="percentage">
                        <span class="radio-checkmark"></span> </label>
                      <label class="radio-container radio-amount">Amount
                        <input type="radio" name="commission_type" value="amount">
                        <span class="radio-checkmark"></span> </label>
                    </div>
                    <div class="profile-input">
                      <input type="number" name="commission_amt" placeholder="Enter" maxlength="20">
                      <span class="rs-wrapper input-percent">%</span>
                      <span class="rs-wrapper input-amount">&#8377;</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="job-buttons">
                <button class="job-cancel-btn button button-link" type="button" onclick="redirect_url($(this),'{{route("employer.job.listing")}}')">
                  Cancel
                </button>
                <button id="emp_job_submit_btn" class="job-add-btn button button-link" type="button" onclick="add_edit_job('{{route('employer.job.add')}}')">
                  Add Job
                </button>
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
