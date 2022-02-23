@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ route('specialists.specialist.index') }}">      Manage Specialists
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>    
                    <span>Create New Specialist</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-plus"></i>
                            <span class="caption-subject font-dark sbold">
                                Create New Specialist
                            </span>
                        </div>
                    </div>

                    <form data-parsley-validate="true" class="form-horizontal" method="POST" action="{{ route('specialists.specialist.store') }}" accept-charset="UTF-8" id="create_specialist_form" name="create_specialist_form" enctype="multipart/form-data">    
                        <div class="form-body">

                            {{ csrf_field() }}

                            @include ('specialists.form', [
                                                        'specialist' => null,
                                                      ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_specialist_form"))'>
                                            Add
                                        </button>
                                        <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('specialists.specialist.index') }}')">Cancel
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


