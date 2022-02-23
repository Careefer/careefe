<div class="form-group form-md-line-input has-info">
    <select class="form-control" id="parent"  name="parent">
      <option value="0">Select Parent Menu</option>

      @if(count($parent_menues) > 0)
        @foreach($parent_menues as $key=>$menue)
         <option value="{{ $menue->id }}" {{ old('parent', optional($menues)->parent) == $menue->id ? 'selected' : '' }}>{{ $menue->name }}</option>
        @endforeach
      @endif   
    </select>    
    <label for="status"><strong>Select Parent Menu</strong></label> 
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('name'))
	    <span class="err-msg">
	       {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
       <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($menues)->name) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
    <label for="name"><strong>Name</strong></label> 
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('url'))
	    <span class="err-msg">
	       {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
       <input class="form-control" name="url" type="text" id="url" value="{{ old('url', optional($menues)->url) }}" minlength="1" placeholder="Enter url here...">
    <label for="url"><strong>Url</strong></label>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('status'))
	    <span class="err-msg">
	       {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
    <select class="form-control" id="status" name="status">
	    <option value="" style="display: none;" {{ old('status', optional($menues)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
	@foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $text)
	    <option value="{{ $key }}" {{ old('status', optional($menues)->status) == $key ? 'selected' : '' }}>
	    	{{ $text }}
	    </option>
	@endforeach
   </select>   
    <label for="status"><strong>Status</strong></label>
</div>


<div class="form-group form-md-line-input has-info">
	@if( $errors->has('sort'))
	    <span class="err-msg">
	       {!! $errors->first('sort', '<p class="help-block">:message</p>') !!}
	    </span>
	@endif
     <input class="form-control" name="sort" type="text" id="sort" value="{{ old('sort', optional($menues)->sort) }}" min="-2147483648" max="2147483647" placeholder="Enter sort here...">
    <label for="sort"><strong>Sort</strong></label> 
</div>



