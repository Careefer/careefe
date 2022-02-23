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
                                Create New Job
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('jobs.job.store') }}" accept-charset="UTF-8" id="create_job_form" name="create_job_form" >
                        <div class="form-body">
                            {{ csrf_field() }}
                                @include ('jobs.form', [
                                                        'job' => null,
                                                      ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn blue" id="add_job_btn" onclick="add_job('add_job_btn','create_job_form');">
                                        Add
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


