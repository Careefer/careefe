@extends('layouts.web.web')
@section('title','Job Listing')
@section('page-class','job-list-wrap')
@section('content')
  <div class="list-job-wrap">
    <div class="container">
      <h1>Please make a search now!</h1>
      <div class="jobs-top-wrapper clearfix">
        <div class="job-form">
            @include('webApp.partials.job_search_form')
        </div>
      </div>
      <div class="jobs-main clearfix">
        <div class="job-top-wrap">
          <div class="ajax-search-job-html-bind">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bottom-image">
    Image
  </div>
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
