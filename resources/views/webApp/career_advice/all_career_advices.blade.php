@extends('layouts.web.web')
@if(!empty($career_advice_category))
@section('title', $career_advice_category->meta_title)
@push('meta')
<meta name="description" content="{{$career_advice_category->meta_desc}}">
  <meta name="keywords" content="{{$career_advice_category->meta_keyword}}">
@endpush
@endif
@section('page-class', 'blog-wrapper')
@section('content')

   <div id="wrapper">
      <div class="content career-viewall">
        <div class="career-advice-wrapper">
          <div class="container">
            <h1>Career Advice</h1>
            <div class="career-slider-wrapper slider-wrapper clearfix">
              <ul class="career-slider slider-list">
               @foreach ($categories as $key => $category)
                <li>
                  <a class="{{($category->slug == $active_cat_slug)?'active':''}}" href="{{route('web.all_career_advices',$category->slug)}}">{{$category->title}}</a>
                </li>
                @endforeach  
              </ul>
              <div class="reset-wrapper">
                  <button class="button reset-btn" onclick="redirect_url($(this),'{{route('web.all_career_advices')}}',true)">
                    Reset
                  </button>
              </div>
            </div>
            <div class="all-career-bind-ajax-data">
              @include('webApp.career_advice/include_listing_html')
            </div>
          </div>
        </div>
        <div class="bottom-image">
          Image
        </div>
      </div>
     
    </div>

@endsection