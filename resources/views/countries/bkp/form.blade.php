
<div class="form-group form-md-line-input has-info">
	@if( $errors->has('name'))
	    <span class="err-msg">
	                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($country)->name) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
    <label for="name">
        <strong>Name</strong>
        <span class="required">*</span>
	</label>
</div>



<div class="form-group form-md-line-input has-info">
	@if( $errors->has('timezone'))
	    <span class="err-msg">
	        {!! $errors->first('timezone', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif

    <select class="bs-select form-control" id="timezone_id" name="timezone_id" data-live-search="true" data-size="8">
	 
    	@foreach ($timezone as $key => $value)
		    <option value="{{ $value['id'] }}" {{ old('timezone', optional($country)->timezone_id) == $value['id'] ? 'selected' : '' }}>
		    	{{ $value['name'].' - '.$value['text'] }}
		    </option>
		@endforeach
    </select>
        
    <label for="timezone">
        <strong>Timezone</strong>
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
			    <option value="{{ $key }}" {{ old('status', optional($country)->status) == $key ? 'selected' : '' }}>
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

