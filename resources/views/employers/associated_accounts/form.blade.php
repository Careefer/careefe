<div class="form-group">
    <label class="control-label col-md-3">Email
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
    		<input {{isset($obj_user->email)?'disabled="disabled"':''}} data-parsley-required="email" data-parsley-type="email" class="form-control" name="email" type="text" value="{{ old('email', optional($obj_user)->email) }}" minlength="1" maxlength="255">

            @if( $errors->has('email'))
			    <span class="err-msg">
			        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Name
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="name" class="form-control" name="name" type="text" value="{{ old('name', optional($obj_user)->name) }}" minlength="1" maxlength="255">

            @if( $errors->has('name'))
                <span class="err-msg">
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </span>
            @endif
        </div>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-md-3">Contact number
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="contact number" data-parsley-type="number" class="form-control" name="contact_number" type="text" value="{{ old('contact_number', optional($obj_user)->mobile) }}" minlength="1" maxlength="255">

            @if( $errors->has('contact_number'))
                <span class="err-msg">
                    {!! $errors->first('contact_number', '<p class="help-block">:message</p>') !!}
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
        <div class="input-icon select-group right">

        	<select data-parsley-required="location" data-placeholder="" class="loadAjaxSuggestion form-control" name="location">
        		<option value="{{optional($obj_user)->location_id}}">{{optional(optional($obj_user)->my_location)->location}}</option>
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
    <label class="control-label col-md-3">Currency
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon select-group right">
            <select data-parsley-required="currency" data-placeholder="" class="careefer-select2 form-control" name="currency">
                <option value=""></option>
                @foreach ($currencies as $currency_id => $currency)
                    <option value="{{ $currency_id }}" {{ old('currency', optional(optional($obj_user)->currency)->id) == $currency_id ? 'selected' : '' }}>
                        {{ $currency }}
                    </option>
                @endforeach
            </select>
            
            @if( $errors->has('currency'))
                <span class="err-msg">
                    {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
                </span>
            @endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Timezone
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon select-group right">
            
            <select data-parsley-required="timezone" data-placeholder="" class="careefer-select2 form-control" name="timezone">
                <option value=""></option>
                @foreach ($time_zones as $obj_tz)
                    <option value="{{ $obj_tz->id }}" {{ old('timezone', optional(optional($obj_user)->timezone)->id) == $obj_tz->id ? 'selected' : '' }}>
                        {{ $obj_tz->name }}
                    </option>
                @endforeach
            </select>
            
            @if( $errors->has('timezone'))
                <span class="err-msg">
                    {!! $errors->first('timezone', '<p class="help-block">:message</p>') !!}
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
				    <option value="{{ $key }}" {{ old('status', optional($obj_user)->status) == $key ? 'selected' : '' }}>
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
    <label class="control-label col-md-3">Enter Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input  id="password"  class="form-control" name="password" type="password" value="{{ old('password') }}" placeholder="Enter Password">
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
    <label class="control-label col-md-3">Enter Confirm Password
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input  data-parsley-equalto='#password' class="form-control" name="confirm_password" type="password" id="confirm_password" value="">
            @if( $errors->has('confirm_password'))
			    <span class="err-msg">
			        {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

