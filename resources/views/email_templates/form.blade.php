

<div class="form-group form-md-line-input has-info">
	@if( $errors->has('title'))
	    <span class="err-msg">
	                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($emailTemplate)->title) }}" minlength="1" placeholder="Enter title here..." onkeyup="generateSlug(this.value)">
    <label for="title">
        <strong>Title</strong>
        <span class="required">*</span>
    </label>   
</div>


<div class="form-group form-md-line-input has-info"> 
   <label for="content">
     <strong>Content</strong>
     <span class="required">*</span>
   </label>
    @if( $errors->has('content'))
        <span class="err-msg">
            {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
        </span>
    @endif 
   <textarea name="content" id="summernote_1" >{{ old('content', optional($emailTemplate)->content) }}</textarea>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($emailTemplate)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
        	@foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($emailTemplate)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>    
    <label for="status">
        <strong>Status</strong>
        <span class="required">*</span>
   </label>
</div>



