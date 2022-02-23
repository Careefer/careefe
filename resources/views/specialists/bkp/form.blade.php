
<div class="form-group form-md-line-input has-info">
	@if( $errors->has('specialist_id'))
	    <span class="err-msg">
	        {!! $errors->first('specialist_id', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="specialist_id" type="text" id="specialist_id" value="{{ isset($specialist_id)?$specialist_id:$specialist->specialist_id}}" minlength="1" readonly="readonly">
    <label for="specialist_id">
        <strong>Specialist Id</strong>
	</label>
</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('first_name'))
	    <span class="err-msg">
	                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="first_name" type="text" id="first_name" value="{{ old('first_name', optional($specialist)->first_name) }}" minlength="1" placeholder="Enter first name here...">
    <label for="first_name">
        <strong>First Name</strong>
</label>
    

</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('last_name'))
	    <span class="err-msg">
	                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="last_name" type="text" id="last_name" value="{{ old('last_name', optional($specialist)->last_name) }}" minlength="1" placeholder="Enter last name here...">
    <label for="last_name">
        <strong>Last Name</strong>
</label>
    

</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('email'))
	    <span class="err-msg">
	                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($specialist)->email) }}" minlength="1" placeholder="Enter email here...">
    <label for="email">
        <strong>Email</strong>
</label>
    

</div>



<div class="form-group form-md-line-input has-info">
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
</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('confirm_password'))
	    <span class="err-msg">
	        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="confirm_password" type="password" id="confirm_password" value="{{ old('confirm_password', optional($specialist)->confirm_password) }}" minlength="1" placeholder="Enter confirm password here...">
	<label for="confirm_password">
        <strong>Confirm Password</strong>
	</label>
</div>

<div class="form-group form-md-line-input has-info">
	@if( $errors->has('location'))
	    <span class="err-msg">
	        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
	<select class="form-control loadAjaxSuggestion" name="location">
		
	</select>
    <!-- <input class="form-control loadAjaxSuggestion" name="location" type="text" id="location" value="{{ old('location', optional($specialist)->location) }}" minlength="1" placeholder="Enter location here..."> -->
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
        	@foreach (['active' => 'Active',
'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($specialist)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
    <label for="status">
        <strong>Status</strong>
</label>
    

</div>



