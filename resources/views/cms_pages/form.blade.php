


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('title'))
	    <span class="err-msg">
	                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($cms)->title) }}" minlength="1" placeholder="Enter title here..." onkeyup="generateSlug(this.value)">
    <label for="title">
        <strong>Title</strong>
        <span class="required">*</span>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
        @if( $errors->has('slug'))
            <span class="err-msg">
               {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
            </span>
        @endif
        <input class="form-control" name="slug" type="text" id="slug" value="{{ old('slug', optional($cms)->slug) }}" minlength="1" readonly="readonly">
    <label for="slug">
        <strong>Slug</strong>
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
   <textarea name="content" id="summernote_1" >{{ old('content', optional($cms)->content) }}</textarea>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($cms)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
        	@foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($cms)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>    
    <label for="status">
        <strong>Status</strong>
        <span class="required">*</span>
   </label>
</div>

<div class="form-group form-md-line-input has-info">
        <input class="form-control" name="meta_title" type="text" id="meta_title" value="{{ old('meta_title', optional($cms)->meta_title) }}" minlength="1" placeholder="Enter meta title here...">
    <label for="meta_title">
        <strong>Meta Title</strong>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
        <input class="form-control" name="meta_keyword" type="text" id="meta_keyword" value="{{ old('meta_keyword', optional($cms)->meta_keyword) }}" minlength="1" placeholder="Enter meta keyword here...">
    <label for="meta_keyword">
        <strong>Meta Keyword</strong>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
    <textarea class="form-control" name="meta_desc" id="meta_desc" placeholder="Enter meta description here..." >{{ old('meta_desc', optional($cms)->meta_desc) }}</textarea>
    <label for="meta_desc">
        <strong>Meta Description</strong>
    </label>  
</div>


