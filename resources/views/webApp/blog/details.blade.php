@extends('layouts.web.web')
@section('title', $blog_detail->meta_title)
@push('meta')
<meta name="description" content="{{$blog_detail->meta_desc}}">
  <meta name="keywords" content="{{$blog_detail->meta_keyword}}">
@endpush
@section('page-class', 'blog-wrapper')
@section('content')

    <div class="career-detail-wrapper">
          <ul class="social-share-icons">
            <li>
              <a href="#"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa fa-linkedin"></i></a>
            </li>
          </ul>
          <div class="container">
            <div class="career-top-wrapper clearfix">
              <div class="categories-tab-wrapper">
                <h3>Categories</h3>
                <ul class="career-tab">
                  <li class="career-tab-link" data-tab="article-tab">
                    {{$blog_detail->category->title}}
                  </li>
                  
                </ul>
              </div>
              <div class="career-details">
                <div id="article-tab" class="career-content current">
                  @if($blog_detail->type == "image")
                  <div class="tab-image">
                      <img src="{{asset('storage/blog_images/'.$blog_detail->image)}}" alt="img">
                  </div>
                   @else
                   <div> 
                     <video width="230" height="230" controls>
                        <source src="{{asset('storage/blog_images/'.$blog_detail->image)}}">
                     </video>
                   </div>
                   @endif
                  <div class="career-text-wrapper">
                    <h2>{{$blog_detail->title}}</h2>
                    <p>
                      @php echo html_entity_decode($blog_detail->content); @endphp
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
                @forelse($blogs as $key => $blog)
                <li class="box">
                  <a href="{{route('web.blog.detail',$blog->slug)}}" class="box-link">
                  <div class="slider-img">
                    @if($blog->type == "image")
                         <img src="{{asset('storage/blog_images/'.$blog->image)}}" alt="img">
                     @else
                        <video width="230" height="230" controls>
                          <source src="{{asset('storage/blog_images/'.$blog->image)}}">
                        </video>
                     
                     @endif
                  </div>
                  <div class="blog-text">
                    <span class="blog-date"><img src="{{asset('assets/images/date-icon.png')}}" alt="date">{{display_date_time($blog->created_at)}}</span>
                    <h3>{{$blog->title}} </h3>
                    <span class="read-story">Read Story</span>
                  </div> </a>
                </li>
                @empty
                <p>No Records found.</p>
                @endforelse
                
              </ul>
            </div>
          </div>
        </div>
        <div class="bottom-image">
          Image
        </div>
@endsection