@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-plus"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Edit Job
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('jobs.job.update', $job->id) }}" id="edit_job_form" name="edit_job_form" accept-charset="UTF-8"  enctype="multipart/form-data">
                            <div class="form-body">
                            {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                @include ('jobs.form', [
                                                        'job' => $job,
                                                      ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn blue" id="edit_job_btn" onclick="edit_job('edit_job_btn','edit_job_form',{{$job->id}});">
                                    Update
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('jobs.job.index') }}')">Cancel
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


