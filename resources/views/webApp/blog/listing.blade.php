@extends('layouts.web.web')
@section('page-class', 'blog-wrapper')
@section('content')

    <div class="career-detail-wrapper">
      <div class="container">
        <h1>Blog</h1>
        <div class="career-top-wrapper clearfix">
          <div class="categories-tab-wrapper">
            <h3>Categories</h3>
            <ul class="career-tab">
              @foreach ($categories as $key_1 => $obj_cat_1)
              <li class="career-tab-link" data-tab="article-tab-{{$key_1}}">
                {{$obj_cat_1->title}}
              </li>
              @endforeach
            </ul>
          </div>
          <div class="career-details">
            @foreach ($categories as $key_2 => $obj_cat_2)

              <div id="article-tab-{{$key_2}}" class="career-content {{($key_2 == 0)?'current':''}}">
            
              <div class="article-wrapper">
                <div class="article-heading">
                  <h3>{{$obj_cat_2->title}}</h3>
                  <a href="{{route('web.all_blogs')}}" class="view-all">View All</a>
                </div>
                <ul class="article-card-wrapper">
                 
                    @foreach($obj_cat_2->blogs_by_category->sortByDesc('id')->take(3) as $key_blog => $obj_blog)
                  <li>
                    <a href="{{ route('web.blog.detail',$obj_blog->slug)}}" class="box-link">
                    <div class="slider-img">
                      @if($obj_blog->type == "image")
                          <img src="{{asset('storage/blog_images/'.$obj_blog->image)}}" alt="img">
                      @else
                         <video width="230" height="230" controls>
                           <source src="{{asset('storage/blog_images/'.$obj_blog->image)}}">
                         </video>
                      
                      @endif
                    </div>
                    <div class="blog-text">
                      <h3>{{$obj_blog->title}}</h3>
                      <p>
                         @php
                         $string = strip_tags($obj_blog->content); 
                         $string = substr($string,0,20);
                         $string = substr($string,0,strrpos($string," "));
                         echo $string."..."; 
                         @endphp

                      </p>
                      <span class="blog-day">{{display_date_time($obj_blog->created_at)}}</span>
                    </div></a>
                  </li>
                    @endforeach
                </ul>
              </div>

            </div>
            @endforeach

            @foreach ($recommend_categories as $key => $recommend_category)
              <div class="recommendation-wrapper">
                  <div class="article-heading">
                    <h3>Recommendation</h3>
                    <a href="{{route('web.all_blogs',$recommend_category->slug)}}" class="view-all">View All</a>
                  </div>
                  <ul class="article-card-wrapper">
                    @if($recommend_category->blogs_by_category->count())
                      @foreach($recommend_category->blogs_by_category as $key => $blogs)
                    <li>
                      <a href="{{ route('web.blog.detail',$blogs->slug)}}" class="box-link">
                      <div class="slider-img">
                        @if($blogs->type == "image")
                            <img src="{{asset('storage/blog_images/'.$blogs->image)}}" alt="img">
                        @else
                           <video width="230" height="230" controls>
                             <source src="{{asset('storage/blog_images/'.$blogs->image)}}">
                           </video>
                        
                        @endif
                      </div>
                      <div class="blog-text">
                        <h3>{{$blogs->title}}</h3>
                        <p>
                          @php
                           $string = strip_tags($blogs->content); 
                           $string = substr($string,0,20);
                           $string = substr($string,0,strrpos($string," "));
                           echo $string."..."; 
                         @endphp
                        </p>
                        <span class="blog-day">{{display_date_time($blogs->created_at)}}</span>
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