<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('specialist_id'))
	    <span class="err-msg">
	        {!! $errors->first('specialist_id', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="specialist_id" type="text" id="specialist_id" value="{{ isset($specialist_id)?$specialist_id:$specialist->specialist_id}}" minlength="1" readonly="readonly">
    <label for="specialist_id">
        <strong>Specialist Id</strong>
	</label>
</div> -->



<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('first_name'))
	    <span class="err-msg">
	                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="first_name" type="text" id="first_name" value="{{ old('first_name', optional($specialist)->first_name) }}" minlength="1" placeholder="Enter first name here...">
    <label for="first_name">
        <strong>First Name</strong>
</label>
    

</div> -->



<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('last_name'))
	    <span class="err-msg">
	                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="last_name" type="text" id="last_name" value="{{ old('last_name', optional($specialist)->last_name) }}" minlength="1" placeholder="Enter last name here...">
    <label for="last_name">
        <strong>Last Name</strong>
</label>
    

</div> -->



<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('email'))
	    <span class="err-msg">
	                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($specialist)->email) }}" minlength="1" placeholder="Enter email here...">
    <label for="email">
        <strong>Email</strong>
</label>
    

</div> -->



<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('password'))
	    <span class="err-msg">
	        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="password" type="password" id="password" value="{{ old('password') }}" minlength="1" placeholder="Enter password here...">
    <label for="password">
        <strong>Password</strong>
	</label>
	<span>
		<i>Password must be between 6 to 15 character having one capital & small letters and one number</i>
	</span>    
</div> -->



<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('confirm_password'))
	    <span class="err-msg">
	        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="confirm_password" type="password" id="confirm_password" value="{{ old('confirm_password', optional($specialist)->confirm_password) }}" minlength="1" placeholder="Enter confirm password here...">
	<label for="confirm_password">
        <strong>Confirm Password</strong>
	</label>
</div> -->

<!-- <div class="form-group form-md-line-input has-info">
	@if( $errors->has('location'))
	    <span class="err-msg">
	        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
	<select class="form-control loadAjaxSuggestion" name="location">
		
	</select>
    <label for="location">
        <strong>Location</strong>
	</label>
</div>

<div class="form-group form-md-line-input has-info">
		@if( $errors->has('functional_areas[]'))
		    <span class="err-msg">
		        {!! $errors->first('functional_areas', '<p class="help-block">:message</p>') !!}
		    </span>
		@endif
        <select class="form-control careefer-select2" multiple name="functional_areas[]">
        	@foreach ($functionalAreas as $key => $functionalArea)
			    <option value="{{ $key }}">
			    	{{ $functionalArea }}
			    </option>
			@endforeach
        </select>

	    <label for="functional_area_id">
	        <strong>Functional Area</strong>
		</label>
</div>

<div class="form-group form-md-line-input has-info">
    <label for="image">
        <strong>Upload CV</strong>
    </label>
	@if( $errors->has('resume'))
	    <span class="err-msg">
            {!! $errors->first('resume', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <div class="input-group uploaded-file-group">
        <label class="input-group-btn">
            <span class="btn btn-default">
                Browse <input type="file" name="resume" class="hidden">
            </span>
        </label>
    </div>
</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($specialist)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
        	@foreach (['active' => 'Active','inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($specialist)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
    <label for="status">
        <strong>Status</strong>
	</label>
</div> -->


<div class="form-group">
    <label class="control-label col-md-3">Specialist Id
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="specialist_id" type="text" id="specialist_id" value="{{ isset($specialist_id)?$specialist_id:$specialist->specialist_id}}" minlength="1" readonly="readonly">
            @if( $errors->has('specialist_id'))
			    <span class="err-msg">
			        {!! $errors->first('specialist_id', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">First Name
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="first name" class="form-control" name="first_name" type="text" id="first_name" value="{{ old('first_name', optional($specialist)->first_name) }}">
            @if( $errors->has('first_name'))
			    <span class="err-msg">
			        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Last Name
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="last name" class="form-control" name="last_name" type="text" id="last_name" value="{{ old('last_name', optional($specialist)->last_name) }}">
            @if( $errors->has('last_name'))
			    <span class="err-msg">
			        {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Email
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="email" data-parsley-type="email" class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($specialist)->email) }}">
            @if( $errors->has('email'))
			    <span class="err-msg">
			        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

@php
	$f_areas_arr = '';
	if(isset($specialist->functional_area_ids) && !empty($specialist->functional_area_ids))
	{
		$f_areas_arr = explode(',',$specialist->functional_area_ids);
	}
@endphp

<div class="form-group">
    <label class="control-label col-md-3">Functional Area
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon select-group right">
            <select data-parsley-required="functional area" data-placeholder="" class="form-control careefer-select2" multiple name="functional_areas[]">
	        	@foreach ($functionalAreas as $key => $functionalArea)
				   	@php
				   		$selected = '';

				   		if(!empty($f_areas_arr) && in_array($key,$f_areas_arr))
				   		{
				   			$selected = 'selected="selected"';
				   		}
				   	@endphp 	
				    <option value="{{ $key }}" {{$selected}}>
				    	{{ $functionalArea }}
				    </option>
				@endforeach
        	</select>
            @if( $errors->has('functional_areas[]'))
			    <span class="err-msg">
			        {!! $errors->first('functional_areas', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Location
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right select-group">
        	
            <select data-parsley-required="location" data-placeholder="" class="form-control loadAjaxSuggestion" name="location">
        	@php
        		$is_edit = false;
        		if(isset($specialist->current_location->location_id))
        		{
        			$location_id = $specialist->current_location->location_id;

        			$my_location = $specialist->get_location_by_id($location_id);

        			if($my_location->count())
        			{	
        				$is_edit = true;
        			}
        		}
    		@endphp

    		@if($is_edit)
	    		<option value="{{$my_location->id}}">
	    			{{$my_location->location}}
	    		</option>
    		@endif

			</select>
            @if( $errors->has('location'))
			    <span class="err-msg">
			        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Status
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <select class="form-control careefer-select2" id="status" name="status">
	        	@foreach (['active' => 'Active','inactive' => 'Inactive'] as $key => $text)
				    <option value="{{ $key }}" {{ old('status', optional($specialist)->status) == $key ? 'selected' : '' }}>
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
    <label class="control-label col-md-3">Resume
        <span class="required">*</span>
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            
            <label class="input-group-btn">
                <span class="btn">
                    <input {{(!($specialist))?'data-parsley-required="resume"':''}} type="file" name="resume">
                </span>
            </label>
                <label>Allowed file type doc,pdf,docx,zip max size 5 MB</label>
         	
			@if( $errors->has('resume'))
			    <span class="err-msg">
		            {!! $errors->first('resume', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
    <div class="col-md-2">
		@if($specialist)
			@php
                  $cv_path = storage_path('app/public/specialist/resume/'.$specialist->resume);
                  $encrypt = base64_encode($cv_path);
                @endphp

                @if(file_exists($cv_path))
                    <a href="{{route('admin.dashboard')}}?f={{$encrypt}}">
                    <i class="fa fa-download" aria-hidden="true"></i>
                        Click to download
                    </a>
            	@endif
    	@endif
    </div>
</div>    

<div class="form-group">
    <label class="control-label col-md-3">Enter Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input {{(!$specialist?'data-parsley-required=password':'')}} id="password"  class="form-control" name="password" type="password" value="{{ old('password') }}" placeholder="Enter Password">
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
            <input {{(!$specialist?'data-parsley-required=confirm-password':'')}} data-parsley-equalto='#password' class="form-control" name="confirm_password" type="password" id="confirm_password" value="{{ old('confirm_password', optional($specialist)->confirm_password) }}">
            @if( $errors->has('confirm_password'))
			    <span class="err-msg">
			        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>


