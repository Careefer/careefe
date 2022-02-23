<div class="form-group form-md-line-input has-info">
    @if( $errors->has('title'))
        <span class="err-msg">
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
        </span>
    @endif
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($newsletter)->title) }}" minlength="1" placeholder="Enter Newsletter Title">
    <label for="title">
        <strong>Title</strong>
        <span class="required">*</span>
    </label>   
</div>

<div class="form-group form-md-line-input has-info">
    	@if( $errors->has('user_group'))
    	    <span class="err-msg">
    	       {!! $errors->first('user_group', '<p class="help-block">:message</p>') !!}
    	    </span>
    	@endif
        <select class="form-control" id="user_group" name="user_group">
        	    <option value="" style="display: none;" {{ old('id', optional($newsletter)->user_group ?: '') == '' ? 'selected' : '' }} disabled selected>Select User Group</option>
        	
                <option value="all" {{ old('user_group', optional($newsletter)->user_group) == "all" ? 'selected' : '' }}>
                    All
                </option>
			    <option value="employer" {{ old('user_group', optional($newsletter)->user_group) == "employer" ? 'selected' : '' }}>
			    	Employer
			    </option>
                <option value="specialist" {{ old('user_group', optional($newsletter)->user_group) == "specialist" ? 'selected' : '' }}>
                    Specialist
                </option>
                <option value="candidate" {{ old('user_group', optional($newsletter)->user_group) == "candidate" ? 'selected' : '' }}>
                    Candidate
                </option>
        </select>     
    <label for="user_group">
        <strong>User Group</strong>
        <span class="required">*</span>
    </label>
</div>

<div class="form-group form-md-line-input has-info">
    @if( $errors->has('subject'))
        <span class="err-msg">
                    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
        </span>
    @endif
        <input class="form-control" name="subject" type="text" id="subject" value="{{ old('subject', optional($newsletter)->subject) }}" minlength="1" placeholder="Enter Newsletter Subject">
    <label for="subject">
        <strong>Subject</strong>
        <span class="required">*</span>
    </label>   
</div>





<div class="form-group form-md-line-input has-info">
    <label for="image">
        <strong>Attachments</strong>
        <!-- <span class="required">*</span> -->
    </label>
	<!-- @if( $errors->has('attachments'))
	    <span class="err-msg">
            {!! $errors->first('attachments', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif -->
    <div class="input-group uploaded-file-group">
        <label class="input-group-btn">
            <span class="btn btn-default">
                Browse <input type="file" name="attachments" id="attachments" class="hidden">
                <input name="attachments" type="hidden" class="form-control uploaded-file-name" readonly value="{{ old('attachments', optional($newsletter)->attachments)}}">
            </span>
        </label>
    </div>
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
   <textarea name="content" id="summernote_1" >{{ old('content', optional($newsletter)->content) }}</textarea>
</div>



