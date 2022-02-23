<ul class="referral-detail ref-detail-sent">
@foreach($applications as $app)
<li>
<div class="application-wrapper clearfix">
	<em class="app-id">Application Id: {{ $app->application_id}}</em>
	<span class="app-status">Application Status: <span class="success-text">{{ $app->status }}</span></span>
</div>
<div class="ref-info">
	<span class="ref-name">{{ $app->name }}</span>
	<a href="mailto:{{ $app->email}}" class="ref-mail">{{ $app->email}}</a>
	<ul class="ref-list clearfix">
		<li>
			{{ display_date_time($app->created_at) }}
		</li>
		<li>
			via Email
		</li>
		<li>
			{{ (@$app->candidate->current_location) ? $app->candidate->get_location_by_id($app->candidate->current_location->location_id)->location : '--' }}
		</li>
	</ul>
	<div class="payment-status clearfix">
		<div class="rate-app clearfix" style="float: none;">
			<span class="rate-text">Rate Applicant:</span>
			<!-- Rating Stars Box -->
            <div class='rating-stars'>
              <ul id='stars'>
                <li class='star {{ ($app->rating_by_specialist >0 && $app->rating_by_specialist >= 1 ) ? "selected": "" }}' title='Poor' data-value='1' data-appId="{{ $app->id }}">
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($app->rating_by_specialist >0 && $app->rating_by_specialist >= 2 ) ? "selected": "" }}' title='Fair' data-value='2' data-appId="{{ $app->id }}">
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($app->rating_by_specialist >0 && $app->rating_by_specialist >= 3 ) ? "selected": "" }}' title='Good' data-value='3' data-appId="{{ $app->id }}">
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($app->rating_by_specialist >0 && $app->rating_by_specialist >= 4 ) ? "selected": "" }}' title='Excellent' data-value='4' data-appId="{{ $app->id }}">
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star {{ ($app->rating_by_specialist >0 && $app->rating_by_specialist >= 5 ) ? "selected": "" }}' title='WOW!!!' data-value='5' data-appId="{{ $app->id }}">
                  <i class='fa fa-star fa-fw'></i>
                </li>
              </ul>
            </div>
		</div>
	</div>
	<ul class="application-btn">
		<li>
      
			<a href="#" class="msg-specialist">Message Specialist</a>
		</li>
		<li>
			<a href="{{ asset('storage/candidate/resume/'.$app->resume) }}"" class="button-link resume-btn" target="_blank">View CV</a>
		</li>
	</ul>
</div>
</li>
@endforeach
</ul>
@if($applications->count())
   {{ $applications->appends(request()->except('page'))->links('layouts.web.pagination') }} 
@endif

@push('script')
<script type="text/javascript">
function responseMessage(application_id, rating)
{
  if(application_id && rating)
  {
    $.ajax({
            type: "POST",
            cache: false,
            url: "{{ route('specialist.update-application-rating') }}",
            dataType: "json",
            data: {'application_id': application_id, 'rating':rating, '_token': "{{ csrf_token() }}"},
            success: function(res) 
            {
              alert('Rating Updated Successfully.');
               //toastr.success('Success', 'Rating Updated Successfully.')
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            }
        });
  }
}


</script>
@endpush