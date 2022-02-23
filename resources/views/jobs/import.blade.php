@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('currency_rate_conversions.currency_rate_conversion.index') }}">Currency Rate Conversion</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Import Currency Rate Conversion</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-upload"></i>&nbspCurrency Rate Conversion
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
                    
                    <div class="portlet-body">
                        <form method="POST" action="{{ route('currency_rate_conversions.currency_rate_conversion.import.post') }}" accept-charset="UTF-8" id="create_currency_rate_conversion_form" name="create_currency_rate_conversion_form" enctype="multipart/form-data">
                            <div class="form-body">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    @if( $errors->has('name'))
                                        <span class="err-msg">
                                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                        </span>
                                    @endif
                                    <input class="form-control" name="name" type="file" id="file">
                                    <p>Download sample csv file</p>
                                    <a href="{{route('currency_rate_conversions.currency_rate_conversion.download')}}"><button class="btn green" type="button">Download sample</button></a>
                                </div>
                            </div>                                                  
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_currency_rate_conversion_form"))'>
                                    Upload
                                </button>
                                
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('currency_rate_conversions.currency_rate_conversion.index') }}')">Cancel
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


