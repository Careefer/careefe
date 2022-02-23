@if(isset($recent_searched) && $recent_searched->count())
<div class="searched">
  <h3>Recent Searches</h3>
  <a href="{{route('web.job.clear.listing')}}" class="clear button" type="button">
	Clear
  </a>
  <ul class="searched-list">
	  	@foreach($recent_searched as $obj)
			<li>
			  <a href="{{route('web.job.search.listing',$obj->slug)}}" class="clearfix" title="{{$obj->string}}">
			  	@if(strlen($obj->string) > 20 || strlen($obj->location) > 20 )
			  		{{substr($obj->string,0,20)." , ".substr($obj->location,0,20)}}..
			  	@else
			  	{{$obj->string." , ".$obj->location}}	
			  	@endif
			  	<span class="search-no">{{$obj->total_result}}</span>
			  </a>
			</li>
		@endforeach
  </ul>
</div>
@endif