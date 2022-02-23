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
                    <a href="{{route('employers.employer.index')}}"> Manage Employer's Associated Accounts</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Update Account</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-edit"></i>
                            <span class="caption-subject font-dark sbold">
                                {{$obj_emp->company_name}} (Update Associated Account)
                            </span>
                        </div>
                    </div>

                    <form data-parsley-validate="true"  method="POST" class="form-horizontal" action="{{ route('admin.update_associated_acc',$obj_user->id) }}" accept-charset="UTF-8" id="edit_associated_acc" name="edit_associated_acc"  enctype="multipart/form-data">    

                        <div class="form-body">

                            {{ csrf_field() }}

                            @include ('employers.associated_accounts.form', [
                                                    'obj_user' => $obj_user,
                                                  ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <button type="button" class="btn blue" onclick='submit_form($(this),$("#edit_associated_acc"))'>
                                            Update
                                        </button>
                                        <button type="button" class="btn red" onclick="redirect_url($(this),'{{route('admin.list_associated_acc',[$obj_emp->id])}}')">Cancel
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


