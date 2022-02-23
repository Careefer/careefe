

<div class="form-group form-md-line-input has-info">
	@if( $errors->has('title'))
	    <span class="err-msg">
	                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($banner)->title) }}" minlength="1" placeholder="Enter title here..." onkeyup="generateSlug(this.value)">
    <label for="title">
        <strong>Title</strong>
        <span class="required">*</span>
    </label>   
</div>

{{--<div class="form-group form-md-line-input has-info">
    @if( $errors->has('link'))
        <span class="err-msg">
                    {!! $errors->first('link', '<p class="help-block">:message</p>') !!}
        </span>
    @endif
        <input class="form-control" name="link" type="text" id="link" value="{{ old('link', optional($banner)->link) }}" minlength="1" placeholder="Enter link here...">
    <label for="link">
        <strong>Link</strong>
        <span class="required">*</span>
    </label>   
</div>--}}



<div class="form-group form-md-line-input has-info">
    <label for="image">
        <strong>Image/Video</strong>
        <span class="required">*</span>
    </label>
	@if( $errors->has('image'))
	    <span class="err-msg">
            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <div class="input-group uploaded-file-group">
        <label class="input-group-btn">
            <span class="btn btn-default">
                Browse <input type="file" name="image" id="image" class="hidden">
            </span>
        </label>
    </div>

    @if(!empty($banner->type) && $banner->type == "image")
        <div class="input-group input-width-input">
            <span class="input-group-addon custom-delete-file-name">
                <img width="200" src="{{asset('storage/banner_images/'.$banner->image)}}">
            <input name="image" type="hidden" class="form-control uploaded-file-name" readonly value="{{$banner->image}}">
            </span>
        </div>

    @elseif(!empty($banner->type) && $banner->type == "video")
       <div class="input-group input-width-input">
            <span class="input-group-addon custom-delete-file-name">
                <video width="150" height="150" controls>
                       <source src="{{asset('storage/banner_images/'.$banner->image) }}">     
                </video>
            <input name="image" type="hidden" class="form-control uploaded-file-name" readonly value="{{$banner->image}}">
            </span>
        </div>
    @endif   
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
   <textarea name="content" id="summernote_1" >{{ old('content', optional($banner)->content) }}</textarea>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($banner)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
        	@foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($banner)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>    
    <label for="status">
        <strong>Status</strong>
        <span class="required">*</span>
   </label>
</div>



