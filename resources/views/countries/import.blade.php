@extends('layouts.app')

@section('content')

    <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('countries.country.index') }}">Countries</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Import Country</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <h4 class="caption-subject bold uppercase">
                                    <i class="fa fa-upload"></i>&nbspImport Country
                                </h4>
                            </div>
                        </div>
                        
                        <div class="portlet-body">
                            <form method="POST" action="{{ route('countries.country.import.post') }}" accept-charset="UTF-8" id="create_country_form" name="create_country_form" enctype="multipart/form-data">
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
                                        <a href="{{route('countries.country.download')}}"><button class="btn green" type="button">Download sample</button></a>
                                    </div>
                                </div>                                                  
                                <div class="form-actions noborder">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_country_form"))'>
                                        Upload
                                    </button>
                                    
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('countries.country.index') }}')">Cancel
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection


