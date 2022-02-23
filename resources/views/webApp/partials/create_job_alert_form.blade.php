@php
	$params = http_build_query(request()->all());
	$fix_param = [];
	if(request()->has('k'))
	{
		$fix_param['k'] = request()->get('k');
	}
	
	if(request()->has('f'))
	{
		$fix_param['f'] = request()->get('f');
	}

	if(request()->has('l'))
	{
		$fix_param['l'] = request()->get('l');
	}
	$fix_param = http_build_query($fix_param);
@endphp

@if(session('success'))
	{{--<div class="form-msg">
		<p class="success_msg">
			{{(session('success'))}}
		</p>
	</div>--}}
@endif

<form class="alerts-form" name="job_alert" method="post" id="create_job_alert_frm" action="{{route('web.create_alert')}}?{{$params}}" data-action="{{route('web.create_alert')}}?{{$fix_param}}">
	<label>Create Alerts</label>
	{{csrf_field()}}

	@php
		$email = old('email');
		if(auth()->guard('candidate')->check())
		{
			$email = auth()->guard('candidate')->user()->email;
		}
	@endphp

	<input type="email" name="email" placeholder="Please enter email address" required="required" maxlength="50" value="{{$email}}">
	@if($errors->has('email'))
		<span class="err_msg">{{$errors->first('email')}}</span>
	@endif
	<button type="button" onclick="submit_form($(this),$('#create_job_alert_frm'))">
		Subscribe
	</button>
</form>