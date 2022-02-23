@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('functional_areas.functional_area.index') }}">Functional Areas</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Manage Functional Area</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create Functional Area</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-plus"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Create Functional Area
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('functional_areas.functional_area.store') }}" accept-charset="UTF-8" id="create_functional_area_form" name="create_functional_area_form" >
                        <div class="form-body">
                            {{ csrf_field() }}
                            @include ('functional_areas.form', [
                                                    'functionalArea' => null,
                                                  ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_functional_area_form"))'>
                                        Add
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('functional_areas.functional_area.index') }}')">Cancel
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


