@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <!-- <li>
                        <a href="{{ route('cities.city.index') }}">Cities</a>
                        <i class="fa fa-circle"></i>
                    </li> -->
                    <li>
                        <span>Create New City</span>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbsp Rate Setting For {{ $page }}
                            </h4>
                        </div>
                    </div>
                    
                    @if(session('success'))
						<div  class="alert alert-success ">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
							<i class="fa-lg fa fa-check"></i>
							{{ session('success') }}
						</div>
					@elseif(session('error'))    
						<div  class="alert alert-danger ">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
							<i class="fa-lg fa fa-close"></i>
							{{ session('error') }}
						</div>
					@endif

                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('admin.rate-setting-update') }}" id="rate_setting_form" name="edit_city_form" accept-charset="UTF-8" >
                            <div class="form-body">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="application_weight"><strong>Application Weight</strong></label>
                                        <input class="form-control" name="application_weight" type="number" id="application_weight" value="{{ old('application_weight', $rate_setting->application_weight) }}"placeholder="Enter Application Weight..." required="required">
                                        @if( $errors->has('name'))
                                        <span class="err-msg">
                                        {!! $errors->first('application_weight', '<p class="help-block">:Application Weight</p>') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_fill_weight"><strong>Job Fill Weight</strong></label>
                                        <input class="form-control" name="job_fill_weight" type="number" id="job_fill_weight" value="{{ old('job_fill_weight', $rate_setting->job_fill_weight) }}"placeholder="Job Fill Weight..." readonly="readonly" required="required">
                                        @if( $errors->has('name'))
                                        <span class="err-msg">
                                        {!! $errors->first('job_fill_weight', '<p class="help-block">:Job Fill Weight</p>') !!}
                                        </span>
                                        @endif
                                    </div>
                                </div>    
                                <div class="col-md-6">
                                    <input type="hidden" name="type" value="{{ $rate_setting->type }}">
                                    <input type="hidden" name="id" value="{{ $rate_setting->id}}">
                                    <div class="form-actions noborder">
                                        <button type="submit" class="btn blue">
                                            Update
                                        </button>
                                    </div>
                                </div>  
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function()
    { 
        $('#application_weight').keyup(function()
        {
            var application_weight = $('#application_weight').val();
            $('#job_fill_weight').val(100-parseInt(application_weight));
        });
    });       
</script>
@endpush
@endsection
