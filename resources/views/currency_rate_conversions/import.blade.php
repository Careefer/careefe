@extends('layouts.app')
@section('content')
    <div class="page-content">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('currency_rate_conversions.currency_rate_conversion.index') }}">Currency Rate Conversion</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Import Currency Rate Conversion</span>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-upload"></i>&nbspCurrency Rate Conversion
                            </h4>
                        </div>
                    </div>

                    <div class="actions right-side">
                        <div class="btn-group">
                            <a href="{{route('currency_rate_conversions.currency_rate_conversion.download')}}"><button class="btn green" type="button">Click to download sample</button></a>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
                        <form class="form-horizontal" method="POST" action="{{ route('currency_rate_conversions.currency_rate_conversion.import.post') }}" accept-charset="UTF-8" id="create_currency_rate_conversion_form" name="create_currency_rate_conversion_form" enctype="multipart/form-data">

                            <div class="form-body">
                                {{ csrf_field() }}
                                <!-- <div class="form-group">
                                    <label class="control-label col-md-3">Download sample csv file
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <a href="{{route('currency_rate_conversions.currency_rate_conversion.download')}}"><button class="btn green" type="button">Click to download sample</button></a>
                                        </div>
                                    </div>
                                </div>
 -->
                                <div class="form-group">
                                    <label class="control-label col-md-3">Upload file
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <input class="form-control" name="name" type="file" id="file">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 text-center">
                                        <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_currency_rate_conversion_form"))'>
                                        Upload
                                        </button>
                                        
                                        <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('currency_rate_conversions.currency_rate_conversion.index') }}')">Cancel
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
@endsection


