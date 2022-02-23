
<div class="form-group form-md-line-input has-info">
	@if( $errors->has('name'))
	    <span class="err-msg">
	                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($state)->name) }}" minlength="1" maxlength="255" placeholder="Enter State Name">
    <label for="name">
        <strong>State</strong>
        <span class="required">*</span>
</label>
  
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('country_id'))
	    <span class="err-msg">
	                {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control bs-select" id="country_id" name="country_id" data-live-search="true">
        	    <option value="" style="display: none;" {{ old('country_id', optional($state)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Country</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($state)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
    <label for="country_id">
        <strong>Country</strong>
        <span class="required">*</span>
</label>
    

</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	@foreach (['active' => 'Active',
'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($state)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
    <label for="status">
        <strong>Status</strong>
        <span class="required">*</span>
	</label>
</div>

@push('css')
    <link href="{{asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
    <script src="{{asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/pages/scripts/components-bootstrap-select.min.js')}}" type="text/javascript"></script>
@endpush



