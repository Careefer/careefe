
<div class="form-group form-md-line-input has-info">
	@if( $errors->has('title'))
	    <span class="err-msg">
	                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
            <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($faq)->title) }}" minlength="1" maxlength="255" placeholder="Enter title here...">
    <label for="title">
        <strong>FAQ Title</strong>
        <span class="required">*</span>
	</label>
</div>


<div id="ques_wrapper">

		@if($faq)
			@foreach($faq->questions AS $key => $value)
				
				<div class="ques_section">
					<div class="form-group form-md-line-input has-info">
					        <input class="form-control" name="question[{{$key}}]" type="text" value="{{$value->question}}" minlength="1" placeholder="Enter question here...">
					    <label for="question">
					        <strong>Question</strong>
					        <span class="required">*</span>
						</label>
					</div>

					<div class="form-group clearfix">
	                    <label for="answer">
					        <strong class="text-primary">Answer</strong>
					        <span class="required">*</span>
						</label>
	                    <div class="col-md-12 padding_0">
	                        <textarea class="wysihtml5 form-control" rows="6" name="answer[{{$key}}]">{{$value->answer}}</textarea>
	                    </div>
	                </div>

					@if($key > 0)
					
						<div class="remove-ques-btn" style="right: {{($key+1==count($faq->questions))?110:0}}px;">
                        	<button type="button" class="btn btn-danger" onclick="faq_remove($(this))">-Remove</button>
                    	</div>

					@endif
				</div>

			@endforeach
		@else
		
			<div class="ques_section">
				<div class="form-group form-md-line-input has-info">
				        <input class="form-control" name="question[0]" type="text" value="" minlength="1" placeholder="Enter question here...">
				    <label for="question">
				        <strong>Question</strong>
					    <span class="required">*</span>
					</label>
				</div>
                <div class="form-group clearfix">
                    <label for="answer">
				        <strong class="text-primary">Answer</strong>
				        <span class="required">*</span>
					</label>
                    <div class="col-md-12 padding_0">
                        <textarea class="wysihtml5 form-control" rows="6" name="answer[0]"></textarea>
                    </div>
                </div>
			</div>

		@endif

		
		<div class="add-more-btn" id="add_more_btn">
			<button type="button" class="btn btn-primary" onclick="faq_add_more($(this));">+Add more</button>
		</div>

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
			    <option value="{{ $key }}" {{ old('status', optional($faq)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
    <label for="status">
        <strong>Status</strong>
        <span class="required">*</span>
	</label>
</div>



