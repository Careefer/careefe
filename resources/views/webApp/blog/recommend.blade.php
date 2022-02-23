@extends('layouts.web.web')
@section('page-class', 'blog-wrapper')
@section('content')

   <div id="wrapper">
      <div class="content career-viewall">
        <div class="career-advice-wrapper">
          <div class="container">
            <h1>Blogs</h1>
            <div class="career-slider-wrapper slider-wrapper clearfix">
              <ul class="career-slider slider-list">
                <li>
                  Recent
                </li>
                <li>
                  Articles
                </li>
                <li>
                  Recommendation
                </li>
                <li>
                  Banking Retail
                </li>
                <li>
                  Agriculture
                </li>
                <li>
                  IT/ITES
                </li>
                <li>
                  Manufacturing
                </li>
                <li>
                  Banking
                </li>
              </ul>
              <div class="reset-wrapper">
                <button class="button reset-btn">
                  Reset
                </button>
              </div>
            </div>
            <div class="slides-wrapper">
              <div class="career-slide1">
                <div class="article-wrapper">
                  <div class="article-heading">
                    <h3>Recent Articles</h3>
                  </div>
                  <ul class="article-card-wrapper">
                  @foreach ($recommend_categories as $key => $recommend_category)
                    @if($recommend_category->blogs_by_category->count())
                      @foreach($recommend_category->blogs_by_category as $key => $blogs)
                    <li>
                      <a href="{{ route('web.blog.detail',$blogs->id)}}" class="box-link">
                      <div class="slider-img">
                        @if($blogs->type == "image")
                             <img src="{{asset('storage/blog_images/'.$blogs->image)}}" alt="img">
                         @else
                            <video width="250" height="250" controls>
                              <source src="{{asset('storage/blog_images/'.$blogs->image)}}">
                            </video>
                         
                         @endif
                      </div>
                      <div class="blog-text">
                        <span class="blog-date"><img src="assets/images/date-icon.png" alt="date">{{display_date_time($blogs->created_at)}}</span>
                        <h3>{{$blogs->title}}</h3>
                        <span class="read-story">Read Story</span>
                      </div> </a>
                    </li>
                     @endforeach
                    @endif
                  @endforeach
                  </ul>
                </div>
              </div>
              
            
            </div>
            <ul class="pagination-wrapper">
            
            </ul>
          </div>
        </div>
        <div class="bottom-image">
          Image
        </div>
      </div>
     
    </div>

@endsection