@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="page-bar">
            <!-- <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('functional_areas.functional_area.index') }}">Functional Areas</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>    
                    <a href="{{ route('skills.skill.index') }}">Manage Skills</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create New Skill</span>
                </li>
            </ul> -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-plus"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Create New Skill
                            </span>
                        </div>
                    </div>
                        <form class="form-horizontal" method="POST" action="{{ route('skills.skill.store') }}" accept-charset="UTF-8" id="create_skill_form" name="create_skill_form" >
                        <div class="form-body">
                            {{ csrf_field() }}
                            @include ('skills.form', [
                                                        'skill' => null,
                                                      ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_skill_form"))'>
                                        Add
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('skills.skill.index') }}')">Cancel
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


