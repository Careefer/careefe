@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('admin.dashboard')}}">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Manage Currency</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Currency Rate Conversion</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li><span>Create New Currency Rate Conversion</span></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-plus"></i>
                            <span class="caption-subject font-dark sbold">
                                Create New Currency Rate Conversion
                            </span>
                        </div>
                    </div>

                    <form class="form-horizontal" method="POST" action="{{ route('currency_rate_conversions.currency_rate_conversion.store') }}" accept-charset="UTF-8" id="create_currency_conversion_form" name="create_currency_conversion_form"  enctype="multipart/form-data">

                        <div class="form-body">

                            {{ csrf_field() }}
                                @include ('currency_rate_conversions.form', [
                                                        'currency_conversion' => null,
                                                      ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_currency_conversion_form"))'>
                                            Add
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

@endsection


