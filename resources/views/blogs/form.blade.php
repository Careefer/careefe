
<div class="form-group form-md-line-input has-info">
    	@if( $errors->has('category_id'))
    	    <span class="err-msg">
    	       {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    	    </span>
    	@endif
        <select class="form-control" id="category_id" name="category_id">
        	    <option value="" style="display: none;" {{ old('id', optional($blog)->category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select category</option>
        	@foreach ($categories as $key => $category)
			    <option value="{{ $key }}" {{ old('category_id', optional($blog)->category_id) == $key ? 'selected' : '' }}>
			    	{{ $category }}
			    </option>
			@endforeach
        </select>     
    <label for="category_id">
        <strong>Category Name</strong>
        <span class="required">*</span>
    </label>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('title'))
	    <span class="err-msg">
	                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($blog)->title) }}" minlength="1" placeholder="Enter title here..." onkeyup="generateSlug(this.value)">
    <label for="title">
        <strong>Blog Title</strong>
        <span class="required">*</span>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
        @if( $errors->has('slug'))
            <span class="err-msg">
               {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
            </span>
        @endif
        <input class="form-control" name="slug" type="text" id="slug" value="{{ old('slug', optional($blog)->slug) }}" minlength="1" readonly="readonly">
    <label for="slug">
        <strong>Slug</strong>
    </label>   
</div>


<div class="form-group form-md-line-input has-info">
    <label for="image">
        <strong>Blog Tile Image/Video</strong>
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

    @if(!empty($blog->type) && $blog->type == "image")
        <div class="input-group input-width-input">
            <span class="input-group-addon custom-delete-file-name">
                <img width="200" src="{{asset('storage/blog_images/'.$blog->image)}}">
            <input name="image" type="hidden" class="form-control uploaded-file-name" readonly value="{{$blog->image}}">
            </span>
        </div>

    @elseif(!empty($blog->type) && $blog->type == "video")
       <div class="input-group input-width-input">
            <span class="input-group-addon custom-delete-file-name">
                <video width="150" height="150" controls>
                       <source src="{{asset('storage/blog_images/'.$blog->image) }}">     
                </video>
            <input name="image" type="hidden" class="form-control uploaded-file-name" readonly value="{{$blog->image}}">
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
   <textarea name="content" id="summernote_1" >{{ old('content', optional($blog)->content) }}</textarea>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($blog)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
        	@foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($blog)->status) == $key ? 'selected' : '' }}>
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
        <input class="form-control" name="meta_title" type="text" id="meta_title" value="{{ old('meta_title', optional($blog)->meta_title) }}" minlength="1" placeholder="Enter meta title here...">
    <label for="meta_title">
        <strong>Meta Title</strong>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
        <input class="form-control" name="meta_keyword" type="text" id="meta_keyword" value="{{ old('meta_keyword', optional($blog)->meta_keyword) }}" minlength="1" placeholder="Enter meta keyword here...">
    <label for="meta_keyword">
        <strong>Meta Keyword</strong>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
    <textarea class="form-control" name="meta_desc" id="meta_desc" placeholder="Enter meta description here..." >{{ old('meta_desc', optional($blog)->meta_desc) }}</textarea>
    <label for="meta_desc">
        <strong>Meta Description</strong>
    </label>  
</div>


