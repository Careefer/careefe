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
                    <a href="{{route('employers.employer.index')}}"> Manage Employers</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create New Employer</span>
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
                                Create New Employer
                            </span>
                        </div>
                    </div>

                    <form data-parsley-validate="true" method="POST" class="form-horizontal" action="{{ route('employers.employer.store') }}" accept-charset="UTF-8" id="create_employer_form" name="create_employer_form"  enctype="multipart/form-data">    



                        <div class="form-body">

                            {{ csrf_field() }}

                            @include ('employers.form', [
                                                    'employer' => null,
                                                  ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <button type="button" class="btn blue" onclick='submit_form($(this),$("#create_employer_form"))'>
                                            Add
                                        </button>
                                        <button type="button" class="btn red" onclick="redirect_url($(this),'{{route('employers.employer.index')}}')">Cancel
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>                           
                </div>
            </div>
        </div>
    </div>

    @if(request()->session()->has('total_branch_office'))
        {{ request()->session()->forget('total_branch_office') }}
    @endif

@endsection


