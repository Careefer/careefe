@extends('layouts.web.web')
@section('title','FAQ')
@section('content')

	<div class="faq-wrapper">
		<div class="container">
			<h1>FAQs</h1>
			<ul class="faq-accordion-wrapper">
				@if($faq->count())
					@foreach($faq as $index => $obj_faq)
					<li>
						<h4 class="faq-question question"><img src="{{asset('assets/web/images/faq-accordion.png')}}" alt="question">{{$obj_faq->title}}</h4>
						<ul class="inner-faq inner-faq-wrapper">
							@if($obj_faq->questions->count())
								@foreach($obj_faq->questions as $key => $obj_ques)
									<li>
										<strong class="faq-question inner-ques">
											{{$obj_ques->question}}
										</strong>
										<div class="inner-faq faq-ans">
											<p>
												@php
													echo html_entity_decode($obj_ques->answer);
												@endphp
											</p>
										</div>
									</li>
								@endforeach
							@else
								<li>
									<h3 class="err_msg">Questions not found.!!</h3>
								</li>
							@endif
						</ul>
					</li>
					@endforeach
				@else
				<h4 class="err_msg">Record not found.!!</h4>
				@endif
			</ul>
		</div>
	</div>
	<div class="bottom-image">
		Image
	</div>

@endsection