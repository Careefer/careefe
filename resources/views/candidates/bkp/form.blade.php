
<div class="form-group form-md-line-input has-info">
	@if( $errors->has('candidate_id'))
	    <span class="err-msg">
	        {!! $errors->first('candidate_id', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="candidate_id" type="text" id="candidate_id" value="{{ isset($candidate_id)?$candidate_id:$candidate->candidate_id}}" minlength="1" readonly="readonly">
    <label for="candidate_id">
        <strong>Candidate Id</strong>
	</label>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('first_name'))
	    <span class="err-msg">
	        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="first_name" type="text" id="first_name" value="{{ old('first_name', optional($candidate)->first_name) }}" minlength="1" placeholder="Enter first name here...">
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
    <input class="form-control" name="last_name" type="text" id="last_name" value="{{ old('last_name', optional($candidate)->last_name) }}" minlength="1" placeholder="Enter last name here...">
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
    <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($candidate)->email) }}" minlength="1" placeholder="Enter email here..." {{ isset($candidate->email)?"readonly='readonly'":""}}>
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
        <input class="form-control" name="password" type="password" id="password" value="{{ old('password') }}" placeholder="Enter password here...">
    <label for="password">
       <strong>Password</strong>
	</label>
    <span><i>Password must be between 6 to 15 character having one capital & small letters and one number</i></span>
</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('confirm_password'))
	    <span class="err-msg">
	        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="confirm_password" type="password" id="confirm_password" value="{{ old('confirm_password', optional($candidate)->confirm_password) }}" placeholder="Enter confirm password here...">
    <label for="confirm_password">
        <strong>Confirm Password</strong>
	</label>
</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <select class="form-control" id="status" name="status">
	    <option value="" style="display: none;" {{ old('status', optional($candidate)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
	@foreach (['active' => 'Active',
'inactive' => 'Inactive'] as $key => $text)
	    <option value="{{ $key }}" {{ old('status', optional($candidate)->status) == $key ? 'selected' : '' }}>
	    	{{ $text }}
	    </option>
	@endforeach
	</select>
        
    <label for="status">
        <strong>Status</strong>
	</label>
</div>



