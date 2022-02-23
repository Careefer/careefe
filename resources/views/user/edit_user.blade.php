@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="portlet light bordered">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Edit Admin</span>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                    <br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspEdit Admin
                            </h4>
                        </div>
                    </div>
                    
                    <div class="portlet-body form margin-top-25">
                        {{ Form::open(['url'=>route('user.edit.post',['user_id'=>$obj_user->id]),'autocomplete'=>'off','id'=>'edit_user_form']) }}
                            <div class="form-body">
                                
                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                        <p class="help-block">{{$errors->first('role')}}</p>
                                    </span>
                                    @php
                                        $options = [''=>'Select Role'];
                                    @endphp

                                    @if(count($role_list) > 0)
                                        @foreach($role_list as $value)
                                            @php
                                                $options[$value->id] = $value->name;
                                            @endphp
                                        @endforeach
                                    @endif
                                    
                                    {{Form::select('role',$options,isset($obj_user->role->id)?$obj_user->role->id:'',['class'=>'form-control'])}}
                                    <label>
                                        <strong>Role</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                       <p class="help-block">{{ $errors->first('name') }}</p>
                                    </span>
                                    {{Form::text('name',old('Name',$obj_user->name),['class'=>'form-control','placeholder'=>'Enter admin name'])}}
                                    <label>
                                        <strong>Admin Name</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                       <p class="help-block"> {{$errors->first('email')}}</p>
                                    </span>
                                    {{Form::text('email',$obj_user->email,['class'=>'form-control','placeholder'=>'Enter email','cols'=>'1','rows'=>'2'])}}
                                    <label>
                                        <strong>Email</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                        <p class="help-block">{{$errors->first('password')}}</p>
                                    </span>
                                    {{Form::text('password',null,['class'=>'form-control','placeholder'=>'Enter password','cols'=>'1','rows'=>'2'])}}
                                    <label>
                                        <strong>Password</strong>
                                    </label>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                       <p class="help-block"> {{$errors->first('password_confirmation')}}
                                       </p>
                                    </span>
                                    {{Form::text('password_confirmation',null,['class'=>'form-control','placeholder'=>'Enter password','cols'=>'1','rows'=>'2'])}}
                                    <label>
                                        <strong>Confirm Password</strong>
                                    </label>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <span class="err-msg">
                                        <p class="help-block">{{$errors->first('status')}}</p>
                                    </span>
                                    {{Form::select('status',[''=>'Select status','active'=>'Active','inactive'=>'Inactive'],$obj_user->status,['class'=>'form-control'])}}
                                    <label>
                                        <strong>Status</strong>
                                        <span class="required">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-actions noborder">
                                {{Form::button('Save',['type'=>'button','class'=>'btn blue','onclick'=>'submit_form($(this),$("#edit_user_form"))'])}}

                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ url(route("user.list")) }}')">Cancel
                                </button>
                            </div>
                        {{Form::close()}}
                    </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
