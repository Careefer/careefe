<div class="form-group">
    <label class="control-label col-md-3">Functional Area
        <span class="required">*</span>
    </label>
    <div class="col-md-6">
        <div class="input-icon right">
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($functionalArea)->name) }}" maxlength="255" placeholder="Enter Functional Area">
            @if( $errors->has('name'))
                <span class="err-msg">
                   {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
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
        	    <option value="" style="display: none;" {{ old('status', optional($functionalArea)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
	        	@foreach (['active' => 'Active','inactive' => 'Inactive'] as $key => $text)
				    <option value="{{ $key }}" {{ old('status', optional($functionalArea)->status) == $key ? 'selected' : '' }}>
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


