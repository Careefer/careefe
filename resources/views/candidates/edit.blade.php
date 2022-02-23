@extends('layouts.app')

@section('content')

    <div class="page-content">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{route('candidates.candidate.index')}}"> Manage Candidates</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Edit Candidate</span>
                </li>
            </ul>
        </div> -->

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-edit"></i>
                            <span class="caption-subject font-dark sbold">
                                Edit Candidate
                            </span>
                        </div>
                    </div>
                    <form data-parsley-validate="true" class="form-horizontal" method="POST" action="{{ route('candidates.candidate.update', $candidate->id) }}" id="edit_candidate_form" name="edit_candidate_form" accept-charset="UTF-8" >

                        <div class="form-body">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            @include ('candidates.form', [
                                                    'candidate' => $candidate,
                                                  ])

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <input type="hidden" name="edit_id" value="{{$candidate->id}}">
                                        <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_candidate_form"))'>
                                            Update
                                        </button>
                                        <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('candidates.candidate.index') }}')">Cancel
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
