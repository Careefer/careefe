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
                    <span>Edit Skill</span>
                </li>
            </ul> -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-edit"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Edit Skill
                            </span>
                        </div>
                    </div>
                        <form class="form-horizontal" method="POST" action="{{ route('skills.skill.update', $skill->id) }}" id="edit_skill_form" name="edit_skill_form" accept-charset="UTF-8" >
                        <div class="form-body">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input name="edit_id" type="hidden" value="{{$skill->id}}">
                            @include ('skills.form', [
                                                        'skill' => $skill,
                                                      ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_skill_form"))'>
                                        Update
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


