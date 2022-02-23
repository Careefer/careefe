@extends('layouts.web.web')
@section('content')

    <div class="dashboard-wrapper employer-main">
      <div class="container">
        <h1 class="heading-tab">My Account</h1>
        <div class="main-tab-wrapper clearfix">
          @include('layouts.web.left_menue')
          <div class="main-tabs-content">
            
            <div class="emp-content shadow emp-current account-wrapper emp-edit-profile" id="emp-setting">
              <div class="profile-top">
                <h2>Settings</h2>

                @if(session('success'))
                  <h5 class="success_msg">{{session('success')}}</h5>
                @elseif(session('error'))
                  <h5 class="err_msg">{{session('error')}}</h5>
                @endif
              </div>
              <ul class="job-tabs-list clearfix refer-tabs-list">
                <li class="lists-profile {{($active_tab == 'company')?'acc-current':''}}" data-tab="company-setting">
                  Company Profile
                </li>
                <li class="lists-profile {{($active_tab == 'personal')?'acc-current':''}}" data-tab="profile-setting">
                  Personal Profile
                </li>
              </ul>
              <div class="form-msg"></div>
              <div class="acc-tab-content">
                <div class="form-error color-red"></div>
                <div id="company-setting" class="content-account clearfix {{($active_tab == 'company')?'acc-current':''}}">
                  <form class="account-edit-form" method="post" id="emp_company_profile_frm" action="{{route('employer.profile.company.post')}}">
                    {{csrf_field()}}
                    <div class="account-edit-inner">
                      <div class="profile-detail clearfix">
                        <div class="cmp-logo-outer">
                          <span class="cmp-logo">
                            @if($obj_company->logo) 
                            <img src="{{ asset('storage/employer/company_logo/'.$obj_company->logo) }}" alt="logo" >
                            @else
                            <img src="{{asset('assets/web/images/project-apache.png')}}" alt="logo">
                            @endif
                            <!-- <img src="{{asset('assets/web/images/project-apache.png')}}" alt="apache"> -->
                            <span class="img-edit img-circle">
                              <img src="{{asset('assets/web/images/edit-img2.png')}}" alt="edit">
                            </span><input type="file" id="profile_image" name="image" class="input-file">
                          </span>
                        </div>
                        <div class="text-profile">
                          <div class="form-input">
                            <label>Company Name</label>
                            <div class="disable-input">
                              <input type="text" name="name" placeholder="Apache Software Foundation pvt. ltd" disabled value="{{$obj_company->company_name}}">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="other-loc-wrapper">
                        
                        <div class="form-input edit-input-wrap">
                          <label>Headquarter</label>
                          <select name="head_office" placeholder="City, State, Country" class="loadAjaxSuggestion">
                            @if($obj_company->head_office)
                            <option value="{{$obj_company->head_office->id}}">{{$obj_company->head_office->location}}</option>
                            @else
                            <option value="">Enter</option>
                            @endif
                          </select>

                          @if($errors->has('head_office'))
                          <h5 class="err_msg">{{$errors->first('head_office')}}</h5>
                          @endif
                        </div>

                        @if(!$obj_company->branch_locations()->count())
                        <div class="edit-other-loc">
                          <div class="form-input edit-input-wrap">
                            <label>Other Location</label>
                              <select name="location_id_0"class="loadAjaxSuggestion emp-profile-other-location">
                                    <option value="">Enter</option>
                              </select>
                              <input type="hidden" name="temp[]">
                          </div>
                        </div>
                        @endif

                        @if($obj_company->branch_locations()->count())
                          @php $i = 0; @endphp
                          @foreach($obj_company->branch_locations() as $location_id => $location_name)
                            <div class="form-input edit-input-wrap">
                              <label>Other Location</label>
                              <select name="location_id_{{$i}}" class="loadAjaxSuggestion emp-profile-other-location">
                                    <option value="{{$location_id}}">{{$location_name}}</option>
                              </select>
                              <input type="hidden" name="temp[]">
                            </div>
                            @php $i++; @endphp
                          @endforeach
                        @endif

                      </div>
                      <div class="add-btn-outer">
                        <button type="button" class="button del" onclick="emp_profile_branch_office_delete()"><img src="{{asset('assets/web/images/delete.png')}}" alt="delete" class="del-img">Delete
                        </button>  
                        <button class="add-more button" type="button" onclick="emp_profile_branch_office_add_more()">
                          <span class="plus">plus icon</span>Add More
                        </button>
                      </div>

                      <div class="website-wrap clearfix">
                        <div class="profile-input form-input">
                          <label class="form-label">Number of Employees</label>
                          <input type="text" name="size_of_company" placeholder="Enter no. of Employees" maxlength="20" value="{{$obj_company->size_of_company}}">
                        </div>
                        <div class="profile-input form-input">
                          <label class="form-label">Website</label>
                          <input type="text" name="website_url" placeholder="Enter website" maxlength="255" value="{{$obj_company->website_url}}">
                        </div>
                      </div>
                      <div class="profile-input industry-outer">
                        <label class="form-label">Industry</label>
                        <div>
                          <select class="careefer-select2" data-search="true" placeholder="Select industry" name="industry">
                            @if($industries)
                              <option value="">Enter</option>
                              @foreach($industries as $industry_id => $industry_name)
                                <option {{($obj_company->industry_id == $industry_id)?'selected="selected"':""}} value="{{$industry_id}}">{{$industry_name}}</option>
                              @endforeach
                            @else
                                <option value="">No data found</option>
                           @endif   
                          </select>
                        </div>
                      </div>
                      <div class="add-wrapper">
                        <label class="form-label">About Company</label>
                        <div class="add-textarea profile-input">
                          <textarea placeholder="Type...." name="about_company" maxlength="500">{{$obj_company->about_company}}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="profile-edit-btn">
                      <button type="reset" class="button cancel" onclick="redirect_url($(this),'{{ route('employer.profile.view') }}');">
                        Cancel
                      </button>
                      <button id="emp_profile_submit_btn" type="button" class="button save" onclick="update_company_profile()">
                        Save
                      </button>
                    </div>
                  </form>
                </div>
                <div id="profile-setting" class="content-account {{($active_tab == 'personal')?'acc-current':''}}">
                  <form class="profile-edit-form" method="post" action="{{route('employer.profile.post')}}" id="emp_personal_info_form">
                    {{csrf_field()
                    }}
                    <div class="form-detail clearfix">
                      <div class="form-input">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Enter" onfocus="this.placeholder=''" onblur="this.placeholder='Enter'" maxlength="191" value="{{ old('name',auth()->user()->name)}}">
                          @if($errors->has('name'))
                              <h5 class="err_msg">
                                {{ $errors->first('name') }}
                              </h5>
                          @endif
                      </div>
                      <div class="form-input">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Enter" onfocus="this.placeholder=''" onblur="this.placeholder='Enter'" value="{{old('email',auth()->user()->email)}}">
                          @if($errors->has('email'))
                              <h5 class="err_msg">
                                {{ $errors->first('email') }}
                              </h5>
                          @endif
                      </div>
                    </div>
                    <div class="form-detail clearfix">
                      <div class="form-input">
                        <label>Contact number</label>
                        <input type="text" name="mobile" placeholder="Enter" onfocus="this.placeholder=''" onblur="this.placeholder='Enter'" maxlength="20" value="{{old('mobile',auth()->user()->mobile)}}">
                          @if($errors->has('mobile'))
                              <h5 class="err_msg">
                                {{ $errors->first('mobile') }}
                              </h5>
                          @endif
                      </div>
                      <div class="form-input edit-select-wrap">
                        <label>Location</label>
                        <select name="personal_location_id"class="loadAjaxSuggestion emp-profile-other-location">
                            @if($my_location)
                            <option value="{{$my_location->id}}">{{$my_location->location}}</option>
                            @else
                            <option value="">Enter</option>
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="profile-input">
                      <label class="form-label">Timezone</label>
                      <div class="timezone-wrapper">
                        <select id="time-zone" name="timezone">
                          @forelse($time_zones as $key => $val)
                            <option value="{{$val->id}}" {{(auth()->user()->time_zone_id == $val->id)?"selected='selected'":''}}>{{$val->name}}</option>
                          @empty
                            <option value="">No timezone found</option>
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="profile-edit-btn">
                      <button type="reset" class="button cancel" onclick="redirect_url($(this),'{{ route('employer.profile.view') }}');">
                        Cancel
                      </button>
                      <button type="button" class="button save" onclick="submit_form($(this),$('#emp_personal_info_form'))">
                        Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="emp-content shadow" id="emp-logout">

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-image">
      Image
    </div>

      @push('js')
        
        <script src="{{asset('assets/web/js/select2.min.js')}}"></script>

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
                      url: "{{route('employer.update.profile-pic')}}",
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

         });
     </script>

      @endpush


@endsection
