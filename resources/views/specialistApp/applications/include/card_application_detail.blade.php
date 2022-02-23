<div class="list-main-frame">
<ul class="list-content">
      @if($applications->count())
      @foreach($applications as $obj_app)
      <li>
        <div class="application-wrapper clearfix">
          <em class="app-id">Application Id: {{ $obj_app->application_id}}</em>
          <span class="app-status">Application Status: <span class="success-text">{{ $obj_app->status}}</span></span>
        </div>
        <div class="reference-wrapper">
          <div class="ref-info">
            <span class="ref-name">{{ $obj_app->name }}</span>
            <ul class="email-list">
              <li>
                <a href="mailto:{{ $obj_app->email }}" class="ref-mail">{{ $obj_app->email }}</a>
              </li>
              <li>
                via Email
              </li>
            </ul>
            <a href="tel:{{ $obj_app->mobile }}" class="basket-text basket-tel">{{ $obj_app->mobile }}</a>
            <span class="basket-text">
              {{ (@$obj_app->candidate->current_location) ? @$obj_app->candidate->current_location->address : '--' }}, <strong>{{ (@$obj_app->candidate->current_location) ? @$obj_app->candidate->get_location_by_id($obj_app->candidate->current_location->location_id)->location : '--' }}</strong>
            </span>
            <span class="basket-text">Applied date &amp; time: <strong>{{display_date_time($obj_app->created_at)}}</strong></span>
          </div>
          <ul class="ref-rating">
            <li>
              <span class="rating-text">Referee rating:</span>
              <ul class="rating-star clearfix rating-cursor">
                @if(!empty($obj_app->rating_by_referee) && $obj_app->rating_by_referee > 0)
                @for($i=1; $i<=$obj_app->rating_by_referee ; $i++)
                  <li><img src="{{asset('assets/images/rating.png')}}" alt="rating"></li>
                @endfor
                @endif

                @if(empty($obj_app->rating_by_referee) && $obj_app->rating_by_referee  <= 0)

                @php
                $rating = 5;
                @endphp

                @elseif($obj_app->rating_by_referee == 5)

                @php
                $rating = 0;
                @endphp


                @else 

                @php 
                $rating = 5 - $obj_app->rating_by_referee;
                @endphp

                @endif

                @if($rating)
                @for($i=1; $i<=$rating ; $i++)
                <li>
                  <img src="{{asset('assets/images/rating-star2.png')}}" alt="rating">
                </li>
                @endfor
                @endif
              </ul>
            </li>
            <li>
              <span class="rating-text">Specialist rating:</span>
              <ul class="rating-star clearfix">
                @if(!empty($obj_app->rating_by_specialist) && $obj_app->rating_by_specialist > 0)
                @for($i=1; $i<=$obj_app->rating_by_specialist ; $i++)
                  <li><img src="{{asset('assets/images/rating.png')}}" alt="rating"></li>
                @endfor
                @endif

                @if(empty($obj_app->rating_by_specialist) && $obj_app->rating_by_specialist  <= 0)

                @php
                $rating = 5;
                @endphp

                @elseif($obj_app->rating_by_specialist == 5)

                @php
                $rating = 0;
                @endphp


                @else 

                @php 
                $rating = 5 - $obj_app->rating_by_specialist;
                @endphp

                @endif

                @if($rating)
                @for($i=1; $i<=$rating ; $i++)
                <li>
                  <img src="{{asset('assets/images/rating-star2.png')}}" alt="rating">
                </li>
                @endfor
                @endif
              </ul>
            </li>
          </ul>
        </div>
        <a class="ref-button" href="{{ route('specialist.job.application.detail', [$obj_app->application_id])}}"> button </a>
      </li>
      @endforeach
      @else
        {!! record_not_found_msg() !!}
      @endif
</ul>
</div>
@if($applications->count())
{{ $applications->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif
