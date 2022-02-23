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
                    <!-- <li>
                        <span>Create New City</span>
                    </li> -->
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbsp Success Rate Setting For Referee
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
                        <form method="POST" action="{{ route('admin.update-success-rate-setting') }}" id="rate_setting_form" name="edit_city_form" accept-charset="UTF-8" >
                            <div class="form-body">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    @foreach($rating as $rt)
                                    <div class="form-group">
                                        <label for="application_weight"><strong>Enter success rate for rating : {{$rt['rating'] }}</strong></label>
                                        <input class="form-control" name="{{ $rt['id'] }}" type="number" value="{{ $rt['rate'] }}" placeholder="Enter Bouns rate in %" required="required">In %
                                    </div>
                                    @endforeach
                                </div>
                                   
                                <div class="col-md-12">
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
