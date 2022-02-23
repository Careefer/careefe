<div class="slides-wrapper">
    <div class="career-slide1">
      <div class="article-wrapper">
        @if($blogs->count())
          <div class="article-heading">
            <h3>Recent Articles</h3>
          </div>
            <ul class="article-card-wrapper">
               @foreach ($blogs as $key => $blog)
                <li>
                  <a href="{{ route('web.blog.detail',$blog->slug)}}" class="box-link">
                  <div class="slider-img">
                    @if($blog->type == "image")
                         <img src="{{asset('storage/blog_images/'.$blog->image)}}" alt="img">
                     @else
                        <video width="250" height="250" controls>
                          <source src="{{asset('storage/blog_images/'.$blog->image)}}">
                        </video>
                     
                     @endif
                  </div>
                  <div class="blog-text">
                    <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">{{display_date_time($blog->created_at)}}</span>
                    <h3>{{$blog->title}}</h3>
                    <span class="read-story">Read Story</span>
                  </div> </a>
                </li>
                @endforeach
            </ul>
        @else
            <center><h3 class="color-red">Data not found</h3></center>
        @endif
      </div>
    </div>
  </div>
  <ul class="pagination-wrapper">
  {{ $blogs->appends(request()->except('page'))->links('layouts.web.pagination') }}
  </ul>