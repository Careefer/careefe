@extends('layouts.web.web')
@section('title', $career_advice_detail->meta_title)
@push('meta')
<meta name="description" content="{{$career_advice_detail->meta_desc}}">
  <meta name="keywords" content="{{$career_advice_detail->meta_keyword}}">
@endpush
@section('page-class', 'blog-wrapper')
@section('content')

    <div class="career-detail-wrapper">
          <ul class="social-share-icons">
            <li>
              <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
              <a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
              <a href="https://linkedin.com/"><i class="fa fa-linkedin"></i></a>
            </li>
          </ul>
          <div class="container">
            <div class="career-top-wrapper clearfix">
              <div class="categories-tab-wrapper">
                <h3>Categories</h3>
                <ul class="career-tab">
                  <li class="career-tab-link" data-tab="article-tab">
                    {{$career_advice_detail->category->title}}
                  </li>
                  
                </ul>
              </div>
              <div class="career-details">
                <div id="article-tab" class="career-content current">
                  <div class="tab-image">
                     @if($career_advice_detail->type == "image")
                          <img src="{{asset('storage/career_advice_images/'.$career_advice_detail->image)}}" alt="img">
                      @else
                         <video width="230" height="230" controls>
                           <source src="{{asset('storage/career_advice_images/'.$career_advice_detail->image)}}">
                         </video>
                      
                      @endif
                  </div>
                  <div class="career-text-wrapper">
                    <h2>{{$career_advice_detail->title}}</h2>
                    <p>
                      @php echo html_entity_decode($career_advice_detail->content); @endphp
                    </p>
                   
                    
                    <div class="tagged-categories">
                      <h4>Categories:</h4>
                      <ul class="categories-link clearfix">
                        <li>
                          <a href="#">Recent Articles</a>
                        </li>
                        <li>
                          <a href="#">Recommendation</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="more-category">
              <h3>More from these Categories</h3>
              <ul class="more-category-list">
                @forelse($career_advices as $key => $career_advice)
                <li class="box">
                  <a href="{{route('web.career_advice.detail',$career_advice->slug)}}" class="box-link">
                  <div class="slider-img">
                    @if($career_advice->type == "image")
                         <img src="{{asset('storage/career_advice_images/'.$career_advice->image)}}" alt="img">
                     @else
                        <video width="230" height="230" controls>
                          <source src="{{asset('storage/career_advice_images/'.$career_advice->image)}}">
                        </video>
                     
                     @endif
                  </div>
                  <div class="blog-text">
                    <!-- <span class="blog-date"><img src="{{asset('assets/images/date-icon.png')}}" alt="date">{{display_date_time($career_advice->created_at)}}</span> -->
                    <h3>{{$career_advice->title}} </h3>
                    <!-- <span class="read-story">Read Story</span> -->
                  </div> </a>
                </li>
                @empty
                <p>No records found.</p>
                @endforelse
                
              </ul>
            </div>
          </div>
        </div>
        <div class="bottom-image">
          Image
        </div>
@endsection