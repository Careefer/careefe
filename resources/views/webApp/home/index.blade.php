@extends('layouts.web.web')
@section('content')
    @php
      $video_path = false;
      $image_style = '';   
      if($obj_banner)
      {
          if($obj_banner->type == 'image')
          {
            $image_style = 'background:url('.asset('/storage/banner_images/'.$obj_banner->image).') no-repeat top center';
          }
          else
          { 
              $video_path = url(asset('/storage/banner_images/'.$obj_banner->image));
          }
      }
      else
      {
            $image_style = 'background:url('.asset('/assets/web/images/home-banner.png').') no-repeat top center';
      }
    @endphp

    @if($video_path)
      @include('webApp.home.banner_video')
    @endif

    <div class="home-banner" style="{{$image_style}}">
      <div class="container">
        <div class="banner-text">
          <h1>Find your dream job today!</h1>
          <div class="search-form-wrapper clearfix">
			     @include('webApp.partials.job_search_form')
			     @include('webApp.partials.recently_searched')
          </div>
        </div>
      </div>
    </div>
	@include('webApp.home.recent_popular_jobs')
    <div class="easiest-way">
      <div class="container clearfix">
        <div class="way-text">
          <h2>Easiest Way To Used</h2>
          <p>
            @if($second_banner) 
               @php echo html_entity_decode($second_banner->content); @endphp
            @endif
          </p>
        </div>
        <div class="way-img">
          @if($second_banner) 
          <img src="{{asset('storage/banner_images/'.$second_banner->image)}}" alt="img">
          @endif
        </div>
      </div>
    </div>

    @if($featured_employer->count())
       @include('webApp.home.featured_employer')
    @endif

    @if($our_blog->count())
  	   @include('webApp.home.our_blog')
    @endif

	@include('webApp.partials.bottom_image')

  @push('css')
    <link href="{{asset('assets/web/css/jquery.ui.autocomplete.css')}}" rel="stylesheet">
   @endpush

   @push('js')
     <!-- <script src="{{asset('assets/web/js/jquery.js')}}"></script> -->
     <!-- <script src="{{asset('assets/web/js/jquery-ui.min.js')}}"></script> -->
     <script>
        $(document).ready(function() {
           $("#search_keywords").keyup(function(){
                src = "{{ route('web.job_keyword') }}";
                $("#search_keywords").autocomplete({
                   source: function(request, response) {
                       $.ajax({
                           url: src,
                           dataType: "json",
                           data: {
                               term : request.term
                           },
                           success: function(data) {
                               response(data);
                              
                           }
                       });
                   },
                   minLength: 2,
                  
               });
          });

        $("#search_location").keyup(function(){
               src = "{{ route('web.job_location') }}";
               $("#search_location").autocomplete({
                   source: function(request, response) {
                       $.ajax({
                           url: src,
                           dataType: "json",
                           data: {
                               term : request.term
                           },
                           success: function(data) {
                               response(data);
                              
                           }
                       });
                   },
                   minLength: 2,
                  
              });
           });
      
     });
     </script>
   @endpush
  
@endsection