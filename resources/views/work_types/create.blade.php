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
                    <a href="{{ route('work_types.work_type.index') }}">Work Type</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create New Work Type</span>
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
                                Create New Work Type
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('work_types.work_type.store') }}" accept-charset="UTF-8" id="create_work_type_form" name="create_work_type_form" >
                        <div class="form-body">
                            <div class="form-body">
                            {{ csrf_field() }}
                            @include ('work_types.form', [
                                                        'workType' => null,
                                                      ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_work_type_form"))'>
                                        Add
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('work_types.work_type.index') }}')">      Cancel
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


