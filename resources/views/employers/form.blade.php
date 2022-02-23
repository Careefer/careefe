<div class="form-group">
    <label class="control-label col-md-3">Employer Id
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input  class="form-control" name="employer_id" type="text" id="employer_id" value="{{ isset($employer_id)?$employer_id:$employer->employer_id}}" minlength="1" readonly="readonly">
          
            @if( $errors->has('employer_id'))
			    <span class="err-msg">
			        {!! $errors->first('employer_id', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Company Name
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
    		<input data-parsley-required="company name" class="form-control" name="company_name" type="text" id="company_name" value="{{ old('company_name', optional($employer)->company_name) }}" minlength="1" maxlength="255">

            @if( $errors->has('company_name'))
			    <span class="err-msg">
			        {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Head Office
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon select-group right">

        	<select data-parsley-required="head office" data-placeholder="" class="loadAjaxSuggestion form-control" name="head_office" id="head_office">
        		<option value="{{optional($employer)->head_office_location_id}}">{{optional(optional($employer)->head_office)->location}}</option>
        	</select>

    		@if( $errors->has('head_office'))
			    <span class="err-msg">
			       {!! $errors->first('head_office', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Industry
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon select-group right">
            <select data-parsley-required="industry" class="form-control careefer-select2" data-placeholder="" id="industry_id" name="industry_id">
        	    <option></option>
        		@foreach ($industries as $key => $industry)
			    	<option value="{{ $key }}" {{ old('industry_id', optional($employer)->industry_id) == $key ? 'selected' : '' }}>
			    	{{ $industry }}
			    </option>
				@endforeach
        	</select>
    		@if( $errors->has('industry_id'))
			    <span class="err-msg">
			        {!! $errors->first('industry_id', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Company Size
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="size of Company" class="form-control" name="size_of_company" type="text" id="size_of_company" value="{{ old('size_of_company', optional($employer)->size_of_company) }}">
    		@if( $errors->has('size_of_company'))
			    <span class="err-msg">
			        {!! $errors->first('size_of_company', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Website
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="website url" data-parsley-type="url" class="form-control" name="website_url" type="text" id="website_url" value="{{ old('website_url', optional($employer)->website_url) }}" minlength="1">
    		@if( $errors->has('website_url'))
			    <span class="err-msg">
			        {!! $errors->first('website_url', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="branch_code_container">
	@if($employer)
	 	@include('employers.office_branches_html_edit')
	@else
	 	@include('employers.office_branches_html_add')
	@endif	 	
</div>

<div class="form-group">
    <label class="control-label col-md-3">Status
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            
            <select data-placeholder="" class="careefer-select2 form-control" id="status" name="status">
   
	        	@foreach (['active' => 'Active','inactive' => 'Inactive'] as $key => $text)
				    <option value="{{ $key }}" {{ old('status', optional($employer)->status) == $key ? 'selected' : '' }}>
				    	{{ $text }}
				    </option>
				@endforeach

        	</select>
         	
    		@if( $errors->has('status'))
			    <span class="err-msg">
			        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">About Company
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
         	<textarea data-parsley-required="about Company" class="form-control" name="about_company" cols="1" rows="2" id="about_company" minlength="1">{{ old('about_company', optional($employer)->about_company) }}</textarea>
    		@if( $errors->has('about_company'))
			    <span class="err-msg">
			        {!! $errors->first('about_company', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<!-- <div class="form-group">
    <label class="control-label col-md-3">Enter Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input {{(!$employer?'data-parsley-required=password':'')}} id="password"  class="form-control" name="password" type="password" value="{{ old('password') }}" placeholder="Enter Password">
            @if( $errors->has('password'))
			    <span class="err-msg">
			        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
         <i>Password must be between 6 to 15 character having one capital & small letters and one number</i> 
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Enter Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input {{(!$employer?'data-parsley-required=confirm-password':'')}} data-parsley-equalto='#password' class="form-control" name="confirm_password" type="password" id="confirm_password" value="{{ old('confirm_password', optional($employer)->confirm_password) }}">
            @if( $errors->has('confirm_password'))
			    <span class="err-msg">
			        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div> -->

<div class="form-group">
    <label class="control-label col-md-3">Logo
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            
            <label class="input-group-btn">
                <span class="btn">
                    <input {{(!$employer)?'data-parsley-required="logo"':''}} type="file" name="logo" id="logo">
                </span>
            </label>
                <label>Allowed image type jpeg, png, jpg, gif and max file size 1 MB and max dimensions 300 X 300</label>
         	
    		@if( $errors->has('logo'))
			    <span class="err-msg">
			        {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
	<div class="col-md-2">
    	@if($employer)
			@php
				$logo_path = public_path('storage/employer_logos/'.$employer->logo);

				if(file_exists($logo_path))
				{
					$logo_path = asset('storage/employer_logos/'.$employer->logo);
				}
				else
				{
					$logo_path = asset('storage/employer_logos/default.png');
				}
			@endphp
		<img width="60" src="{{$logo_path}}" alt="apache">
    	@endif
    </div>
</div>


@push('scripts')
    <script src="{{asset('assets/js/employer.js')}}" type="text/javascript"></script>
@endpush