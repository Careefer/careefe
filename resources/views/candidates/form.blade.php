<div class="form-group">
    <label class="control-label col-md-3">Candidate Id
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="candidate_id" type="text" id="candidate_id" value="{{ isset($candidate_id)?$candidate_id:$candidate->candidate_id}}" minlength="1" readonly="readonly">

            @if( $errors->has('candidate_id'))
			    <span class="err-msg">
			        {!! $errors->first('candidate_id', '<p class="help-block">:message</p>') !!}
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
            <input data-parsley-required="first name" class="form-control" name="first_name" type="text" id="first_name" value="{{ old('first_name', optional($candidate)->first_name) }}">
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
            <input data-parsley-required="last name" class="form-control" name="last_name" type="text" id="last_name" value="{{ old('last_name', optional($candidate)->last_name) }}">
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
            <input data-parsley-required="email" data-parsley-type="email" class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($candidate)->email) }}" {{ isset($candidate->email)?"readonly='readonly'":""}}>
            @if( $errors->has('email'))
			    <span class="err-msg">
			        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Enter Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input {{(!$candidate)?'data-parsley-required=password':''}} class="form-control" name="password" type="password" id="password" value="{{ old('password') }}" placeholder="Enter Password">
            <span><i>Password must be between 6 to 15 character having one capital & small letters and one number</i></span>
            @if( $errors->has('password'))
			    <span class="err-msg">
			        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Confirm Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input {{(!$candidate)?'data-parsley-required=confirm&nbsppassword':''}} class="form-control" name="confirm_password" type="password" id="confirm_password" value="{{ old('confirm_password', optional($candidate)->confirm_password) }}" placeholder="Enter Password">
            @if( $errors->has('confirm_password'))
			    <span class="err-msg">
			        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
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
            
            <select data-placeholder="" class="careefer-select2 form-control" id="status" name="status">
   
	        	@foreach (['active' => 'Active','inactive' => 'Inactive'] as $key => $text)
				    <option value="{{ $key }}" {{ old('status', optional($candidate)->status) == $key ? 'selected' : '' }}>
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



