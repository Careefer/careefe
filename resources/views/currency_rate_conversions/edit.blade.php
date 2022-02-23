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
                <li><span>Update Currency Rate Conversion</span></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-plus"></i>
                            <span class="caption-subject font-dark sbold">
                                Update Currency Rate Conversion
                            </span>
                        </div>
                    </div>
                        <form class="form-horizontal" method="POST" action="{{ route('currency_rate_conversions.currency_rate_conversion.update', $currency_conversion->id) }}" id="create_currency_conversion_form" name="create_currency_conversion_form" accept-charset="UTF-8"  enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PUT">

                        <div class="form-body">

                            {{ csrf_field() }}
                               @include ('currency_rate_conversions.form', [
                                                        'currency_conversion' => $currency_conversion,
                                                      ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_currency_conversion_form"))'>
                                    Update
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


