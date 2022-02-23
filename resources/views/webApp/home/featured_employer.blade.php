<div class="featured">
  <div class="container">
	<h2>Featured Employer</h2>
	<p>
	  This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,
	</p>
	<div class="breaking-news-ticker" id="newsticker">
	  <div class="bn-news">
		<ul class="company-list clearfix">

			@php
				$class_arr = ['trivago','hello','amazon','expedia'];
				$i=0;
			@endphp
			@foreach($featured_employer as $f_index => $obj_company)
				  @php
				  	$image_name = 'default.png';
				  	if($obj_company->logo)
				  	{
				  		$image_name = $obj_company->logo;
				  	}

				  	if(isset($class_arr[$i]))
				  	{
				  		$class_name = $class_arr[$i];
				  	}
				  	else
				  	{	
						$i=0;
				  		$class_name = $class_arr[$i];
				  	}
				  	$i++;

				  @endphp	
					<li class="{{$class_name}}">
						<div class="ticker-wrapper">
							<a href="{{route('web.company.detail',$obj_company->slug)}}" target="_blank">
							  <div class="card"><img src="{{asset('storage/employer/company_logo/'.$image_name)}}" alt="expedia">
							  </div> <strong>{{$obj_company->company_name}}</strong>
							  <span>{{$obj_company->active_jobs->count()}} Jobs</span>
							</a>
						</div>
					</li>
			@endforeach
		</ul>
	  </div>
	</div>
  </div>
</div>