@extends('layouts.web.web')
@section('content')
    <div class="career-advice-wrapper">
          <div class="container">
            <h1>Career Advice</h1>
            <div class="career-slider-wrapper slider-wrapper clearfix">
              <ul class="career-slider slider-list">
                 @foreach ($categories as $key => $category)
                <li>
                  <a class="{{($category->slug == $active_cat_slug)?'active':''}}"  href="{{route('web.career_advice',$category->slug)}}">{{$category->title}}</a>
                </li>
                @endforeach
                
                
              </ul>
              <div class="reset-wrapper">
                <button class="button reset-btn" onclick="redirect_url($(this),'{{route('web.career_advice')}}',true)">
                    Reset
                  </button>
              </div>
            </div>
            <div class="slides-wrapper">
              <div class="career-slide1">
                <div class="article-wrapper">
                  <div class="article-heading">
                    @if(!empty($categories_name))
                        <h3>{{$categories_name}}</h3>
                    @else
                        <h3>Recent Articles</h3>
                    @endif
                    <a href="{{route('web.all_career_advices')}}" class="view-all">View All</a>
                  </div>
                  <ul class="article-card-wrapper">
                    @foreach ($career_advices as $key => $career_advice)
                    <li>
                      <a href="{{ route('web.career_advice.detail',$career_advice->slug)}}" class="box-link">
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
                        <h3>{{$career_advice->title}}</h3>
                        <!-- <span class="read-story">Read Story</span> -->
                      </div> </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                @foreach ($recommend_categories as $key => $recommend_category)
                <div class="recommendation-wrapper">
                  <div class="article-heading">
                    <h3>Recommendation</h3>
                    <a href="{{route('web.all_career_advices',$recommend_category->slug)}}" class="view-all">View All</a>
                  </div>
                  <ul class="article-card-wrapper">
                    @if($recommend_category->career_advice_by_category->count())
                      @foreach($recommend_category->career_advice_by_category as $key => $career_advice)
                    <li>
                      <a href="{{ route('web.career_advice.detail',$career_advice->slug)}}" class="box-link">
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
                        <h3>{{$career_advice->title}}</h3>
                        <!-- <span class="read-story">Read Story</span> -->
                      </div> </a>
                    </li>
                     @endforeach
                    @endif
                  </ul>
                </div>
                @endforeach
              </div>

            </div>
          </div>
        </div>
        <div class="bottom-image">
          Image
        </div>

@endsection