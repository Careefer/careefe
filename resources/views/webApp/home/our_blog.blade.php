<div class="our-blog">
   <div class="container">
      <h2>Our Blog</h2>
      <p>
         This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,
      </p>
      <div class="blog-slider">
         @foreach($our_blog as $obj_blog)
            <div class="box">
               <a href="{{route('web.blog.detail',[$obj_blog->slug])}}" target="_blank" class="box-link">
                  @php
                     $image_name = public_path('storage/blog_images/'.$obj_blog->image);

                     if(file_exists($image_name))
                     {
                        $image_name = asset('storage/blog_images/'.$obj_blog->image);
                     }
                     else
                     {
                        $image_name = asset('storage/blog_images/default.png');
                     }
                  @endphp

                  <div class="slider-img">
                      @if($obj_blog->type == "image")
                        <img src="{{$image_name}}" alt="img">
                      @else
                         <video width="230" height="230" controls>
                           <source src="{{$image_name}}">
                         </video>
                      @endif
                  </div>
                  <div class="blog-text">
                     <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">
                        {{date('d F Y',strtotime($obj_blog->created_at))}}
                     </span>
                     <h3>{{$obj_blog->title}}</h3>
                     <span class="read-story">Read Story</span>
                  </div>
               </a>
            </div>
         @endforeach

      </div>
      <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.blogs')}}',true)" class="view-all">View All</a>
   </div>
</div>