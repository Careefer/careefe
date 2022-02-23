@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('timezones.timezone.index') }}">Timezones</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Timezone</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspCreate New Timezone
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
                        <form method="POST" action="{{ route('timezones.timezone.store') }}" accept-charset="UTF-8" id="create_timezone_form" name="create_timezone_form" >
                            <div class="form-body">
                                {{ csrf_field() }}
                                @include ('timezones.form', [
                                                        'timezone' => null,
                                                      ])
                                
                            </div>                                                  
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_timezone_form"))'>
                                    Add
                                </button>
                                
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('timezones.timezone.index') }}')">Cancel
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


