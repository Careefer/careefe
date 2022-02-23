@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <span>Dashboard</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ route('designations.designation.index') }}">Position</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create New Position</span>
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
                                Create New Position
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('designations.designation.store') }}" accept-charset="UTF-8" id="create_designation_form" name="create_designation_form" >
                        <div class="form-body">
                            <div class="form-body">
                            {{ csrf_field() }}
                            @include ('designations.form', [
                                                        'designation' => null,
                                                      ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_designation_form"))'>
                                        Add
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('designations.designation.index') }}')">
                                        Cancel
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


