<div class="form-group">
    <label class="control-label col-md-3">Currency Name
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="name" class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($currency)->name) }}" minlength="1" maxlength="255">

            @if( $errors->has('name'))
			    <span class="err-msg">
			       {!! $errors->first('name', '<p class="help-block">*:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Currency Code
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input data-parsley-required="iso code" class="form-control" name="iso_code" type="text" id="iso_code" value="{{ old('iso_code', optional($currency)->iso_code) }}" minlength="1">
          
            @if( $errors->has('iso_code'))
			    <span class="err-msg">
			       {!! $errors->first('iso_code', '<p class="help-block">*:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Currency Symbol
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
        	<input data-parsley-required="symbol" class="form-control" name="symbol" type="text" id="symbol" value="{{ old('symbol', optional($currency)->symbol) }}" minlength="1">
           
            @if( $errors->has('symbol'))
			    <span class="err-msg">
			       {!! $errors->first('symbol', '<p class="help-block">*:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Country
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon select-group right">
        	<select data-parsley-required="country"  data-placeholder="" class="form-control careefer-select2" id="country_id" name="country_id" data-live-search="true">
        	    <option value="" style="display: none;" {{ old('country_id', optional($currency)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select country</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($currency)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        	</select>
           
            @if( $errors->has('country_id'))
			    <span class="err-msg">
			       {!! $errors->first('country_id', '<p class="help-block">*:message</p>') !!}
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
        <div class="input-icon select-group right">
        	<select data-placeholder="" data-parsley-required="status" class="form-control careefer-select2" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($currency)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
	        	@foreach (['active' => 'Active','inactive' => 'Inactive'] as $key => $text)
				    <option value="{{ $key }}" {{ old('status', optional($currency)->status) == $key ? 'selected' : '' }}>
				    	{{ $text }}
				    </option>
				@endforeach
	        </select>
           
            @if( $errors->has('status'))
			    <span class="err-msg">
			       {!! $errors->first('status', '<p class="help-block">*:message</p>') !!}
			    </span>
			@endif
        </div>
    </div>
</div>


