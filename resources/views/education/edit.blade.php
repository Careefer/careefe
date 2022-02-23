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
                    <a href="{{ route('education.education.index') }}">Manage Educations</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Edit Education</span>
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
                                Edit Education
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('education.education.update', $education->id) }}" id="edit_education_form" name="edit_education_form" accept-charset="UTF-8">
                        <div class="form-body">
                            <div class="form-body">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input name="edit_id" type="hidden" value="{{$education->id}}">
                            @include ('education.form', [
                                                    'education' => $education,
                                                  ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_education_form"))'>
                                        Update
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('education.education.index') }}')">       Cancel
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


