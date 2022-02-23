@extends('layouts.web.web')
@if(!empty($blog_category))
@section('title', $blog_category->meta_title)
@push('meta')
<meta name="description" content="{{$blog_category->meta_desc}}">
  <meta name="keywords" content="{{$blog_category->meta_keyword}}">
@endpush
@endif
@section('page-class', 'blog-wrapper')
@section('content')
 <div id="wrapper">
    <div class="content career-viewall">
      <div class="career-advice-wrapper">
        <div class="container">
          <h1>Blogs</h1>
          <div class="career-slider-wrapper slider-wrapper clearfix">
            <ul class="career-slider slider-list">
              @if($blog_categories->count())
                @foreach($blog_categories as $slug => $cat_name)
                <li>
                  <a class="{{($slug == $active_cat_slug)?'active':''}}" href="{{route('web.all_blogs',[$slug])}}">{{ucwords($cat_name)}}</a>
                </li>
                @endforeach
              @else
                <li><h3 class="color-red">Data not found</h3></li>
              @endif
            </ul>
            <div class="reset-wrapper">
                <button class="button reset-btn" onclick="redirect_url($(this),'{{route('web.all_blogs')}}',true)">
                  Reset
                </button>
            </div>
          </div>
          <div class="all-blog-bind-ajax-data">
            @include('webApp.blog/include_listing_html')
          </div>
        </div>
      </div>
      <div class="bottom-image">
        Image
      </div>
    </div>
  </div>
@endsection