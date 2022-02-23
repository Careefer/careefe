<div class="form-group">
    <label class="control-label col-md-3">Company
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select data-placeholder="" class="form-control careefer-select2" id="company_name" name="company_name" data-live-search="true">
                <option value="" style="display: none;" {{ old('company_name', optional($job)->company_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Company</option>
                @foreach ($companies as $company_id => $company_name)
                    <option value="{{ $company_id }}" {{ old('position', optional($job)->company_id) == $company_id ? 'selected' : '' }}>
                        {{ $company_name }}
                    </option>
                @endforeach
            </select> 
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Job Id
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" type="text" value="{{ old('', optional($job)->job_id) }}" placeholder="{{$job_id}}" disabled>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Position
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select data-placeholder="" class="form-control careefer-select2" id="position" name="position" data-live-search="true">
                <option value="" style="display: none;" {{ old('position', optional($job)->position_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Position</option>
                @foreach ($positions as $position_id => $position)
                <option value="{{ $position_id }}" {{ old('position', optional($job)->position_id) == $position_id ? 'selected' : '' }}>
                    {{ $position }}
                </option>
                @endforeach
            </select> 
            @if( $errors->has('company_name'))
                <span class="err-msg">
                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                </span>
            @endif
        </div>
    </div>
</div>


<div id="location_add_more_wrap">

    @if($job && $job->state())
        @php $i=0; @endphp
        @foreach($job->state() as $state_id => $state_name)
            @if($i > 0)
            <div class="country-state-city-wrap">
            @endif                
                <div class="form-group">
                    <label class="control-label col-md-3">Country
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-icon right select-group">
                            <select {{($i > 0)?'disabled="disabled"':''}} class="form-control careefer-select2" data-placeholder="" name="add_job_country" onchange="init_states_ajax($(this));">
                                    @foreach ($countries as $country_id => $country)
                                        <option value="{{ $country_id }}" {{ old('add_job_country', optional($job)->country_id) == $country_id ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">State
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-icon right select-group">
                            <select {{($i == 0)?'id=state_id':''}} data-placeholder="" class="form-control careefer-select2 add_job_sates" name="state_id[{{$i}}]" onchange="init_cities_ajax($(this));">
                                <option value=""></option>
                                @if(isset($states))
                                    @foreach($states as $w_state_id=>$w_state_name)
                                        <option value="{{ $w_state_id }}" {{($state_id == $w_state_id)?"selected='selected'":""}}>
                                        {{ $w_state_name }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="temp[]">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">City 
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-icon right select-group careefer-select2-multiple">
                            <select data-placeholder="" class="form-control careefer-select2 add_job_city" name="city_id[{{$i}}][]" multiple>
                                @php
                                  $all_cities   = $obj_city->where(['state_id'=>$state_id,'status'=>'active'])->get();
                                  $job_cities = $job->cities();
                                @endphp
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
                    </div>
                    <div class="col-md-3 btn-action">
                            @if($i+1 == count($job->state()))
                            <button type="button" class="btn btn-primary emp-add-more" onclick="admin_job_add_more_location($(this));">
                                +Add more
                            </button>
                            @endif
                            @if($i > 0)
                            <button type="button" class="btn btn-danger btn-rm" onclick="job_more_location_remove($(this))">
                                -Remove
                            </button>
                            @endif
                        </div>
                </div>
            @if($i > 0)
            </div>
            @endif
            @php $i++; @endphp
        @endforeach
    @else
    <div class="form-group">
        <label class="control-label col-md-3">Country
            <span class="required">*</span>
        </label>
        <div class="col-md-6">
            <div class="input-icon right select-group">
                <select class="form-control careefer-select2" data-placeholder="" id="add_job_country" name="add_job_country" data-live-search="true" onchange="init_states_ajax($(this));">
                        <option value="" style="display: none;" {{ old('add_job_country', optional($job)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Country</option>
                    @foreach ($countries as $country_id => $country)
                        <option value="{{ $country_id }}" {{ old('add_job_country', optional($job)->country_id) == $country_id ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
                @if( $errors->has('add_job_country'))
                    <span class="err-msg">
                        {!! $errors->first('add_job_country', '<p class="help-block">:message</p>') !!}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">State
            <span class="required">*</span>
        </label>
        <div class="col-md-6">
            <div class="input-icon right select-group">
                <select data-placeholder="" class="form-control careefer-select2 add_job_sates" id="state_id" name="state_id[0]" onchange="init_cities_ajax($(this));" >
                </select>
                <input type="hidden" name="temp[]">
                @if( $errors->has('state_id'))
                    <span class="err-msg">
                        {!! $errors->first('state_id', '<p class="help-block">:message</p>') !!}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">City
            <span class="required">*</span>
        </label>
        <div class="col-md-6">
            <div class="input-icon right select-group careefer-select2-multiple">
                <select data-placeholder="" class="form-control careefer-select2 add_job_city" name="city_id[0][]" multiple>
                </select>
                @if( $errors->has('city_id'))
                    <span class="err-msg">
                        {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-3 emp-add-more-btn">
            <button type="button" class="btn btn-primary emp-add-more" onclick="admin_job_add_more_location($(this));">+Add more</button>
        </div>
    </div>
    @endif
</div>

<div class="form-group">
    <label class="control-label col-md-3">Functional Area
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group careefer-select2-multiple">
           
            <select data-placeholder="" class="form-control careefer-select2 " multiple id="functional_area" name="functional_area[]" data-live-search="true">
                @foreach ($functional_area as $functional_id => $functional_name)
                    @php
                        $selected = "";
                        if(isset($job->functional_area_ids))
                        {
                            
                          $f_arr = explode(",",$job->functional_area_ids);

                          if(in_array($functional_id,$f_arr))
                          {
                            $selected = 'selected="selected"';
                          }
                        }
                    @endphp 
                    <option value="{{ $functional_id }}" {{ old('functional_area') }} {{$selected}}>
                        {{ $functional_name }}
                    </option>
                @endforeach
            </select>
            @if( $errors->has('functional_area'))
                <span class="err-msg">
                    {!! $errors->first('functional_area', '<p class="help-block">:message</p>') !!}
                </span>
            @endif
        </div>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-md-3">Work Type
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select class="form-control careefer-select2" data-placeholder="" id="work_type" name="work_type" data-live-search="true">
                <option value="" style="display: none;" {{ old('work_type', optional($job)->work_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Work Type</option>
                @foreach ($work_types as $work_type_id => $work_type_name)
                    <option value="{{ $work_type_id }}" {{ old('work_type', optional($job)->work_type_id) == $work_type_id ? 'selected' : '' }}>
                        {{ $work_type_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Number of Vacancies
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="vacancies" type="text" id="vacancies" value="{{ old('vacancies', optional($job)->vacancy) }}"  placeholder="" maxlength="7">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Job Summary
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <textarea class="form-control" name="job_summary" id="job_summary" maxlength="500" >{{ old('job_summary', optional($job)->summary) }}</textarea>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Job Description
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <textarea class="form-control" name="job_description" id="job_description" maxlength="500" >{{ old('job_description', optional($job)->description) }}</textarea>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Minimum experience
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="min_experience" type="text" id="min_experience" value="{{ old('min_experience', optional($job)->experience_min) }}"  maxlength="2">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Maximum experience
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="max_experience" type="text" id="max_experience" value="{{ old('max_experience', optional($job)->experience_max) }}"  maxlength="2">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Select Skills
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group careefer-select2-multiple">
            <select class="form-control careefer-select2" data-placeholder="" id="add_job_skills" name="add_job_skills[]" multiple="multiple">
                @foreach ($skills as $skill_id => $skill)
                    @php
                        $selected = "";
                        if(isset($job->skill_ids))
                        {
                            
                          $f_arr = explode(",",$job->skill_ids);

                          if(in_array($skill_id,$f_arr))
                          {
                            $selected = 'selected="selected"';
                          }
                        }
                    @endphp 
                    
                    <option value="{{ $skill_id }}" {{ old('add_job_skills') }} {{$selected}}>
                        {{ $skill }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Education
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group careefer-select2-multiple">
            <select class="form-control careefer-select2" data-placeholder="" id="educations" name="educations[]" multiple="multiple">   
                @foreach ($educations as $education_id => $education_name)

                    @php
                        $selected = "";
                        if(isset($job->education_ids))
                        {
                            
                          $f_arr = explode(",",$job->education_ids);

                          if(in_array($education_id,$f_arr))
                          {
                            $selected = 'selected="selected"';
                          }
                        }
                    @endphp 
                    
                    <option value="{{ $education_id }}" {{ old('functional_area') }} {{$selected}}>
                        {{ $education_name }}
                    </option>
                   
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Minimum salary
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="min_salary" type="text" id="min_salary" value="{{ old('min_salary', optional($job)->salary_min) }}" maxlength="7">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Maximum salary
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="max_salary" type="text" id="max_salary" value="{{ old('max_salary', optional($job)->salary_max) }}" maxlength="7">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Careefer Commission
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input  name="commission_type" type="radio"  value="percentage" 
            {{ (isset($job->commission_type) && $job->commission_type == 'percentage')?'checked="checked"':'checked="chedked"' }} onclick="chooseCommision('percentage')" id="check-percentage">
            <label for="check-percentage">Percentage
                <span class="required"></span>
            </label>
            <input id="check-amt"  name="commission_type" type="radio"  value="amount" 
            {{(isset($job->commission_type) && $job->commission_type == 'amount')?'checked="checked"':''}} onclick="chooseCommision('amount')">
            <label for="check-amt">Amount
                <span class="required"></span>
            </label>
            <input class="form-control" name="commission_amt" type="number"  value="{{ old('commission_amt', optional($job)->commission_amt) }}"  maxlength="20" placeholder="Enter Percentage" id="commission_amt">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Referral Bonus
        <span class="required">*</span>
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            <input class="form-control" name="referral_bonus_percent" type="number" id="referral_bonus_percent" value="{{ old('referral_bonus_percent', optional($job)->referral_bonus_percent) }}" min="0" max="100">% Max Percent
        </div>
    </div>    
    <div class="col-md-3">
        <div class="input-icon right">
            <input class="form-control" name="referral_bonus_amt" type="number" id="referral_bonus_amt" value="{{ old('referral_bonus_amt', optional($job)->referral_bonus_amt) }}" maxlength="20" readonly="readonly"> Max Amount
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Specialist Bonus
        <span class="required">*</span>
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            <input class="form-control" name="specialist_bonus_percent" type="number" id="specialist_bonus_percent" value="{{ old('specialist_bonus_percent', optional($job)->specialist_bonus_percent) }}" min="1" max="100">% Max Percent
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-icon right">
            <input class="form-control" name="specialist_bonus_amt" type="number" id="specialist_bonus_amt" value="{{ old('specialist_bonus_amt', optional($job)->specialist_bonus_amt) }}" maxlength="20" readonly="readonly">Max Amount
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Functional Area for Specialist
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select class="form-control careefer-select2" data-placeholder="" id="f_area" name="f_area" onchange="fetch_specialist_ajax($(this));">
                    <option value="" style="display: none;"  disabled selected>Select Functional Area</option>
                    @foreach ($functional_area as $functional_area_id => $functional_area_name)
                        <option value="{{ $functional_area_id }}" {{(in_array(@$functional_area_id,  explode(',', @$job->functional_area_ids))) ? "selected" : '' }}>
                        {{ $functional_area_name }}
                        </option>
                    @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Select Primary Specialist
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select class="form-control careefer-select2 add_primar_specialist" id="primary_specialist" name="primary_specialist" data-placeholder="">
                <option value="">Select primary specialist</option> 
                @if(isset($primary_specialists))
                    @foreach($primary_specialists as $primary_specialist_id=>$primary_specialist_name)
                    <option value="{{ $primary_specialist_id }}" {{ old('primary_specialist', optional($job)->primary_specialist_id) == $primary_specialist_id ? 'selected' : '' }}>
                        {{ $primary_specialist_name }}
                    </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Select Secondary Specialist
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select data-placeholder="" class="form-control careefer-select2 add_primar_specialist" id="secondary_specialist" name="secondary_specialist" data-live-search="true">
            <option value="">Select secondary specialist</option> 
            @if(isset($secondary_specialists))
                @foreach($secondary_specialists as $secondary_specialist_id=>$secondary_specialist_name)
                <option value="{{ $secondary_specialist_id }}" {{ old('secondary_specialist', optional($job)->secondary_specialist_id) == $secondary_specialist_id ? 'selected' : '' }}>
                    {{ $secondary_specialist_name }}
                </option>
                @endforeach
            @endif
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Select Job Type
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            <select class="form-control careefer-select2" data-placeholder="" id="job_type" name="job_type">
                <option value="" style="display: none;" {{ old('job_type', optional($job)->job_nature_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Job Type</option>
                @foreach ($job_types as $job_type_id => $job_type_title)
                    <option value="{{ $job_type_id }}" {{ old('job_type', optional($job)->job_nature_id) == $job_type_id ? 'selected' : '' }}>
                        {{ $job_type_title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Status
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
            @php

                $job_status = get_job_status(optional($job)->status);
            @endphp

            <select class="form-control careefer-select2" data-placeholder="" id="status" name="status">
                @foreach ($job_status as $key => $val)
                    <option></option>
                    <option value="{{ $key }}" {{ old('job_type', optional($job)->status) == $key ? 'selected' : '' }}>
                        {{ $val }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    function chooseCommision(type){
        if(type == "percentage"){
            $('#commission_amt').attr("placeholder", "Enter Percentage");
            $('#commission_amt').attr("min", 1);
            $('#commission_amt').attr("max", 100);
        }else if(type == "amount"){
            $('#commission_amt').attr("placeholder", "Enter Amount");
            $('#commission_amt').attr("min", "");
            $('#commission_amt').attr("max", "");
        }
    }

    $(document).on('keypress', function(e){
        if($('#check-percentage').is(":checked")){
            if($('#commission_amt').val <0){
                $('#commission_amt').val(0);
            }else if($('#commission_amt').val() > 100){
                $('#commission_amt').val(10);
            }
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){ 
        //referral bonus     
        $('#referral_bonus_percent,#commission_amt,#max_salary').keyup(function(){
            var referal_bouns_percent = $('#referral_bonus_percent').val();
            var max_salary = $('#max_salary').val();
            var commission_type = $("input[name='commission_type']:checked").val();
            var careefer_commission = $('#commission_amt').val();
            var referal_bouns_amount = 0;
            if(referal_bouns_percent)
            {   
                if(careefer_commission)
                {   
                    if(commission_type == 'percentage')
                    { 
                        careefer_commission_amt = (max_salary * careefer_commission)/100;

                    }else if(commission_type == 'amount')
                    {
                        careefer_commission_amt = careefer_commission;
                    }
                    else
                    {
                        alert('please select commission type first');
                    }    

                    referal_bouns_amount =  (careefer_commission_amt * referal_bouns_percent)/100; 
                    $('#referral_bonus_amt').val(referal_bouns_amount);
                }else
                {
                    alert('Please filled the max salary first');
                    $('#referral_bonus_percent').val(0);
                }    
            }else{
                $('#referral_bonus_amt').val(referal_bouns_amount);
            }
        });

        
        $('#specialist_bonus_percent,#commission_amt,#max_salary').keyup(function(){
            var specilist_bouns_percent = $('#specialist_bonus_percent').val();
            var max_salary = $('#max_salary').val();
            var commission_type = $("input[name='commission_type']:checked").val();
            var careefer_commission = $('#commission_amt').val();
            var specilist_bouns_amount = 0;
            if(specilist_bouns_percent)
            {   
                if(careefer_commission)
                {   
                    if(commission_type == 'percentage')
                    { 
                        careefer_commission_amt = (max_salary * careefer_commission)/100;

                    }else if(commission_type == 'amount')
                    {
                        careefer_commission_amt = careefer_commission;
                    }
                    else
                    {
                        alert('please select commission type first');
                    }

                    specilist_bouns_amount =  (parseInt(careefer_commission_amt) * parseInt(specilist_bouns_percent))/100; 
                    $('#specialist_bonus_amt').val(specilist_bouns_amount);
                }else
                {
                    alert('Please filled the max careefer commission first');
                    $('#specialist_bonus_percent').val(0);
                }    
            }else{
                $('#specialist_bonus_amt').val(specilist_bouns_amount);
            }
        });   
     });   
</script>
@endpush

