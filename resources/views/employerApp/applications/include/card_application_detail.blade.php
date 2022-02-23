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
        <a href="mailto:{{ $obj_app->email }}" class="ref-mail">{{ $obj_app->email }}</a>
        <a href="tel:{{ $obj_app->mobile }}" class="basket-text basket-tel"> {{ $obj_app->mobile }}</a>
        <span class="basket-text">
          {{ (@$obj_app->candidate->current_location) ? $obj_app->candidate->current_location->address : '--' , }}<strong>
              @if(@$obj_app->candidate->current_location)
                @if($obj_app->candidate->current_location->location_id)
                {{$obj_app->candidate->get_location_by_id($obj_app->candidate->current_location->location_id)->location}}
                @else
                {{'--'}}
                @endif
            @endif  
          </strong>
        </span>
      </div>
      <ul class="ref-rating">
        <li>
          <span class="rating-text">Employer rating:</span>
          <ul class="rating-star clearfix rating-cursor">
            @if(!empty($obj_app->rating_by_employer) && $obj_app->rating_by_employer > 0)
            @for($i=1; $i<=$obj_app->rating_by_employer ; $i++)
              <li><img src="{{asset('assets/images/rating.png')}}" alt="rating"></li>
            @endfor
            @endif

            @if(empty($obj_app->rating_by_employer) && $obj_app->rating_by_employer  <= 0)

            @php
            $rating = 5;
            @endphp

            @elseif($obj_app->rating_by_employer == 5)

            @php
            $rating = 0;
            @endphp


            @else 

            @php 
            $rating = 5 - $obj_app->rating_by_employer;
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
    <a class="ref-button" href="{{ route('employer.job.application.detail', [$obj_app->application_id])}}"> button </a>
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