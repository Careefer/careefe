
<div class="form-group form-md-line-input has-info">
	@if( $errors->has('name'))
	    <span class="err-msg">
	                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($city)->name) }}" minlength="1" maxlength="255" placeholder="Enter City Name">
    <label for="name">
        <strong>City</strong>
</label>
    

</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('country_id'))
	    <span class="err-msg">
	                {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select onchange="init_state_ajax($(this));" class="form-control bs-select" id="country_id" name="country_id" data-live-search="true">
        	    <option value="" style="display: none;" {{ old('country_id', optional($city)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Country</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($city)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
    <label for="country_id">
        <strong>Country</strong>
	</label>
</div>



<div class="form-group form-md-line-input has-info">
	
	@if( $errors->has('state_id'))
	    <span class="err-msg">
	                {!! $errors->first('state_id', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    
    <!-- <span id="states">
	</span> -->

    <select class="form-control bs-select" id="state_id" name="state_id" data-live-search="true">
	    	@if(isset($states))
		    	@foreach ($states as $key => $text)
				    <option value="{{ $key }}" {{ old('state_id', optional($city)->state_id) == $key ? 'selected' : '' }}>
				    	{{ $text }}
				    </option>
				@endforeach
			@else
			<option value="">Select State</option>
			@endif
	</select>

    <label for="state_id">
        <strong>State</strong>
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
			    <option value="{{ $key }}" {{ old('status', optional($city)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
    <label for="status">
        <strong>Status</strong>
</label>
    

</div>

@push('css')
    <link href="{{asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
    <script src="{{asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/pages/scripts/components-bootstrap-select.min.js')}}" type="text/javascript"></script>
@endpush



