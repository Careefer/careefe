@extends('layouts.web.web')
@section('title','Company Listing')
@section('page-class','company-listing')
@section('content')
	<div class="container">
		<div class="company-wrapper">
			<h1 class="company-page-heading">Company Profiles</h1>
			<div class="searchbar-wrapper">
				<form class="search-bar clearfix" autocomplete="off">
					<div class="searchbar-input">
						@php
							$keyword = '';

							if(request()->get('keyword'))
							{
								$keyword = request()->get('keyword');
							}
						@endphp
						<span class="search-img"><img src="{{asset('assets/web/images/search-icon.png')}}" alt="search"></span>
						<input type='text'
						value="{{$keyword}}" 
						placeholder='Search Company'
						name='keyword'
						required
						oninvalid="setCustomValidity('Please enter company name')">
					</div>
					<button type="submit" class="button searchbar-btn search-btn">
						Search
					</button>
				</form>
				<ul class="alphabets">
					@foreach(range(97,122) as $ascii_ord_no)
						<li class="company_list_letter_filter" data-letter="{{chr($ascii_ord_no)}}">{{chr($ascii_ord_no)}}</li>
					@endforeach
					<li data-letter="0_9" class="company_list_letter_filter">
						0 - 9
					</li>
				</ul>
			</div>
			<div class="top-list-wrapper slider-wrapper clearfix">
				<ul class="text-slider slider-list">
					@if($industries->count())
						@foreach($industries as $obj_industry)
							<li>
								<a class="{{($obj_industry->slug == $active_industry)?'active':''}}" href="{{route('web.companies.listing',[$obj_industry->slug])}}">{{$obj_industry->name}}</a>
							</li>
						@endforeach
					@else
						<li><h3 class="color-red">Data not found</h3></li>
					@endif
				</ul>
				<div class="reset-wrapper">
					<button class="button reset-btn" onclick="redirect_url($(this),'{{route('web.companies.listing')}}',true)">
						Reset
					</button>
				</div>
			</div>
			<div class="company-bind-ajax-data">
				@include('webApp.companies.load_listing_html')
			</div>
		</div>
	</div>
	<div class="bottom-image">
		Image
	</div>
@endsection