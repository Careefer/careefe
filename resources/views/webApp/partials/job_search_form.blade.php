<form class="search-form" action="{{route('web.save_recent_searched_job')}}" id="search_job_frm" method="post">

	{{csrf_field()}}

  <div class="input-search-wrapper clearfix custom-sel-drop">
	<div class="search-input keyword-wrapper"><img src="{{asset('assets/web/images/search-icon.png')}}" alt="search">
	  <!-- <input type='text'
	  placeholder='Keywords'
	  class='flexdatalist'
	  data-data='countries.json'
	  data-search-in='name'
	  data-visible-properties='["name","capital","continent"]'
	  data-selection-required='false'
	  data-value-property='*'
	  data-min-length='3'
	  data-limit-of-values='1'
	  name='keyword'> -->
	  {{--<select class="home-job-search-keyword" name="k">
	  	@if(isset($param_keyword) && !empty($param_keyword))
	  		<option value="{{$param_keyword['slug']}}">{{$param_keyword['title']}}</option>>
	  	@else
	  		<option value=""></option>
	  	@endif
	  </select>--}}
	  <input type="text" class="flexdatalist-alias flex0 search_keywords" id="search_keywords" name="k"  value="@if(!empty($param_keyword)) {{$param_keyword['title']}} @elseif(!empty($k)) {{$k}} @endif" placeholder="Keywords">
	</div>
	
	<div class="search-input func-area-wrapper"><img src="{{asset('assets/web/images/functional-area.png')}}" alt="functional-area">
	  <!-- <input required type='text'
	  placeholder='Functional Area'
	  class='flexdatalist'
	  data-data='countries.json'
	  data-search-in='name'
	  data-visible-properties='["name","capital","continent"]'
	  data-selection-required='false'
	  data-value-property='*'
	  data-min-length='3'
	  data-limit-of-values='1'
	  name='country_limit_values'> -->

		<select class="careefer-select2 job-skills-select position" name="f" data-placeholder="Functional area">
			<option  value=""></option>
			@if($functional_area->count())
				@foreach($functional_area as $slug => $f_name)
					@if(isset($params['f']) && in_array($slug, is_array($params['f']) ? $params['f'] : [$params['f']]))
					<option selected="selected" value="{{$slug}}">{{$f_name}}</option>
					@else
					<option  value="{{$slug}}">{{$f_name}}</option>
					@endif
				@endforeach
			@endif
		</select>
	</div>
	<div class="search-input country-wrapper"><img src="{{asset('assets/web/images/location-img.png')}}" alt="location">
	  <!-- <input required type='text'
	  placeholder='City, State or Country'
	  class='flexdatalist'
	  data-data='countries.json'
	  data-search-in='name'
	  data-visible-properties='["name","capital","continent"]'
	  data-selection-required='false'
	  data-value-property='*'
	  data-min-length='3'
	  data-limit-of-values='1'
	  name='country_limit_values'> -->
	  {{--<select class="job-search-location" name="l">
	  	@if(isset($param_location) && !empty($param_location))
	  		<option value="{{$param_location->slug}}">{{$param_location->location}}</option>>
	  	@else
	  		<option value=""></option>	
	  	@endif
	  </select>--}}
	  <input type="text" class="flexdatalist-alias flex0 search_location" id="search_location" name="l"  value="@if(!empty($param_location)) {{$param_location->location}} @elseif(!empty($l)) {{$l}} @endif" placeholder="Location" >
	</div>
  </div>
  <div class="btn-center">
	<button  type="button" class="button search-btn search-form-btn" onclick="submit_form($(this),$('#search_job_frm'),true);">
	  Search
	</button>
  </div>
</form>
<script>
       $(document).ready(function() {
           $('.careefer-select2').select2({
           tags: true
         });
		});
		</script>

