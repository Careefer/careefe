<div class="slides-wrapper">
              <div class="career-slide1">
                <div class="article-wrapper">
                  <div class="article-heading">
                    <h3>Recent Articles</h3>
                  </div>
                  <ul class="article-card-wrapper">
                   @foreach ($career_advices as $key => $career_advice)
                    <li>
                      <a href="{{ route('web.career_advice.detail',$career_advice->slug)}}" class="box-link">
                      <div class="slider-img">
                        @if($career_advice->type == "image")
                             <img src="{{asset('storage/career_advice_images/'.$career_advice->image)}}" alt="img">
                         @else
                            <video width="250" height="250" controls>
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
              </div>
            </div>
            <ul class="pagination-wrapper">
            {{ $career_advices->appends(request()->except('page'))->links('layouts.web.pagination') }}
            </ul>