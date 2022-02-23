	@if(request()->session()->has('total_branch_office'))
		@php
			$total = request()->session()->get('total_branch_office');
			$array = range(0,$total-1);
		@endphp

		@foreach($array as $key => $value)
			
			<div class="form-group branch_code_section">
				<label class="control-label col-md-3 bo-title">
					Branch Office {{$key+1}}
		        	<span class="required">*</span>
		    	</label>
	    		<div class="col-md-6">
	        		<div class="input-icon right">
					    <select data-parsley-required="branch office" name="branch_office_{{$key}}" class="loadAjaxSuggestion" data-placeholder="">
					    	<option></option>
			         	</section>
					    <input type="hidden" name="temp[]">			
				    </div>        
				</div>
				<div class="col-md-3 emp-action-btn">
					@if($key > 0)
	                    <button type="button" class="btn btn-danger emp-rm" onclick="remove_branch_office($(this));">X Remove</button>    
		            @endif

					@if($key+1 == $total)
	                    <button type="button" class="btn btn-primary emp-add-more" onclick="add_more_branch_office($(this));">+Add more</button>
		            @endif
                </div>
			</div>
		@endforeach
	@else
		@if($employer->branch_locations()->count())
			<?php 
				$i=0;
				$total = $employer->branch_locations()->count();
			?>
			@foreach($employer->branch_locations() as $location_id => $location)
				<div class="form-group branch_code_section">
					<label class="control-label col-md-3 bo-title">
						Branch Office {{$i+1}}
			        	<!-- <span class="required">*</span> -->
			    	</label>

			    	<div class="col-md-6">
		        		<div class="input-icon right">
						    <select data-parsley-required="branch office" name="branch_office_{{$i}}" class="loadAjaxSuggestion" data-placeholder="">
				         		<option value="{{$location_id}}">{{$location}}</option>
				         	</section>
						    <input type="hidden" name="temp[]">			
					    </div>        
					</div>

					<div class="col-md-3 emp-action-btn">
						@if($i > 0)
		                    <button type="button" class="btn btn-danger emp-rm" onclick="remove_branch_office($(this));">X Remove</button>    
			            @endif

						@if($i+1 == $total)
		                    <button type="button" class="btn btn-primary emp-add-more" onclick="add_more_branch_office($(this));">+Add more</button>
			            @endif
					</div>      
				</div>
				<?php $i++;?>
			@endforeach
		@else
			<div class="form-group branch_code_section">
			    <label class="control-label col-md-3 bo-title">Branch Office 1
			        <span class="required">*</span>
			    </label>
			    <div class="col-md-6">
			        <div class="input-icon select-group right">
			         	<select data-parsley-required="branch office" name="branch_office_0" class="loadAjaxSuggestion" data-placeholder="">
			         		<option value=""></option>
			         	</section>
			         	@if( $errors->has('branch_office_0'))
						    <span class="err-msg">
						        {!! $errors->first('branch_office_0', '<p class="help-block">:message</p>') !!}
						    </span>
						@endif
			    		<input type="hidden" name="temp[]">
			        </div>
			    </div>
			    <div class="col-md-3 emp-add-more-btn">
			        <button type="button" class="btn btn-primary emp-add-more" onclick="add_more_branch_office($(this));">+Add more</button>
			    </div>
			</div>
		@endif
	@endif