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
                    <span>Edit Functional Area</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-edit"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Edit Functional Area
                            </span>
                        </div>
                    </div>
                        <form class="form-horizontal" method="POST" action="{{ route('functional_areas.functional_area.update', $functionalArea->id) }}" id="edit_functional_area_form" name="edit_functional_area_form" accept-charset="UTF-8" >
                        <div class="form-body">
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="edit_id" value="{{$functionalArea->id}}">

                            {{ csrf_field() }}
                            @include ('functional_areas.form', [
                                                    'functionalArea' => $functionalArea,
                                                  ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_functional_area_form"))'>
                                    Update
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


