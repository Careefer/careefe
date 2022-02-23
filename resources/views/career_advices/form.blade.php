
<div class="form-group form-md-line-input has-info">
    	@if( $errors->has('category_id'))
    	    <span class="err-msg">
    	       {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    	    </span>
    	@endif
        <select class="form-control" id="category_id" name="category_id">
        	    <option value="" style="display: none;" {{ old('id', optional($careerAdvice)->category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select category</option>
        	@foreach ($categories as $key => $category)
			    <option value="{{ $key }}" {{ old('category_id', optional($careerAdvice)->category_id) == $key ? 'selected' : '' }}>
			    	{{ $category }}
			    </option>
			@endforeach
        </select>     
    <label for="category_id">
        <strong>Select Category</strong>
        <span class="required">*</span>
    </label>

</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('title'))
	    <span class="err-msg">
	                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($careerAdvice)->title) }}" minlength="1" placeholder="Enter Title" onkeyup="generateSlug(this.value)">
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
        <input class="form-control" name="slug" type="text" id="slug" value="{{ old('slug', optional($careerAdvice)->slug) }}" minlength="1" readonly="readonly">
    <label for="slug">
        <strong>Slug</strong>
    </label>   
</div>

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

    @if(!empty($careerAdvice->type) && $careerAdvice->type == "image")
        <div class="input-group input-width-input">
            <span class="input-group-addon custom-delete-file-name">
                <img width="200" src="{{asset('storage/career_advice_images/'.$careerAdvice->image)}}">
            <input name="image" type="hidden" class="form-control uploaded-file-name" readonly value="{{$careerAdvice->image}}">
            </span>
        </div>

    @elseif(!empty($careerAdvice->type) && $careerAdvice->type == "video")
       <div class="input-group input-width-input">
            <span class="input-group-addon custom-delete-file-name">
                <video width="150" height="150" controls>
                       <source src="{{asset('storage/career_advice_images/'.$careerAdvice->image) }}">     
                </video>
            <input name="image" type="hidden" class="form-control uploaded-file-name" readonly value="{{$careerAdvice->image}}">
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
   <textarea name="content" id="summernote_1" >{{ old('content', optional($careerAdvice)->content) }}</textarea>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <select class="form-control" id="status" name="status">
        	   <!--  <option value="" style="display: none;" {{ old('status', optional($careerAdvice)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option> -->
        	@foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($careerAdvice)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>    
    <label for="status">
        <strong>Select Status</strong>
        <span class="required">*</span>
   </label>
</div>

<div class="form-group form-md-line-input has-info">
        <input class="form-control" name="meta_title" type="text" id="meta_title" value="{{ old('meta_title', optional($careerAdvice)->meta_title) }}" minlength="1" placeholder="Enter meta title here...">
    <label for="meta_title">
        <strong>Meta Title</strong>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
        <input class="form-control" name="meta_keyword" type="text" id="meta_keyword" value="{{ old('meta_keyword', optional($careerAdvice)->meta_keyword) }}" minlength="1" placeholder="Enter meta keyword here...">
    <label for="meta_keyword">
        <strong>Meta Keyword</strong>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
    <textarea class="form-control" name="meta_desc" id="meta_desc" placeholder="Enter meta description here..." >{{ old('meta_desc', optional($careerAdvice)->meta_desc) }}</textarea>
    <label for="meta_desc">
        <strong>Meta Description</strong>
    </label>  
</div>



