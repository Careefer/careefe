@extends('layouts.app')
@section('content')

@push('css')
    <link href="{{asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
@endpuch
<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Add new user</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="portlet-title">
                        <br>
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase"><i class="fa fa-edit"></i>&nbspProfile</h4>
                        </div>
                        @if(session('success'))
                            <div  class="alert alert-success ">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <i class="fa-lg fa fa-check"></i>
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))    
                            <div  class="alert alert-danger ">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <i class="fa-lg fa fa-close"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="{{asset('storage/admin_profile_images/'.Auth::user()->profile_image)}}" class="img-responsive" alt="">
                                        </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="pull-left profile-usertitle-name">{{ucfirst(Auth::user()->name)}}</div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->
                                        <div class="profile-userbuttons">
                                            {{Form::open(['url'=>route('myprofile.image.post'),'id'=>'profile_img_form','method'=>'post','enctype="multipart/form-data"'])}}
                                            <input type="file" name="profile"><br>
                                            <span class="err-msg">
                                                <p class="help-block">{{$errors->first('profile')}}</p>
                                            </span>
                                            <button  type="button" onclick="submit_form($(this),$('#profile_img_form'))" class="pull-left btn btn-circle blue btn-sm">Change</button>
                                            {{Form::close()}}
                                        </div>
                                        <!-- END SIDEBAR BUTTONS -->
                                       
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN PROFILE CONTENT -->
                                <div class="profile-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                                    <ul class="pull-left nav nav-tabs">

                                                        <li class="{{(session('current_tab') == 'info')?'active':''}}">
                                                            <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                        </li>
                                                        <li class="{{(session('current_tab') == 'password')?'active':''}}">
                                                            <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- PERSONAL INFO TAB -->
                                                        <div class="tab-pane {{(session('current_tab') == 'info')?'active':''}}" id="tab_1_1">
                                                            <form action="{{route('user.info.post')}}" role="form" method="post" id="my_profile">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label class="control-label">Name</label>
                                                                    <span class="required">*</span>
                                                                    <input type="text" name="name" value="{{old('name',Auth::user()->name)}}" class="form-control" />
                                                                    <span class="err-msg">
                                                                        <p class="help-block">{{$errors->first('name')}}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">E-mail</label>
                                                                    <span class="required">*</span>
                                                                    <input value="{{old('email',Auth::user()->email)}}" name="email" type="text" class="form-control" />
                                                                    <span class="err-msg">
                                                                        <p class="help-block">{{$errors->first('email')}}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Mobile Number</label>
                                                                    <span class="required">*</span>
                                                                    <input value="{{old('mobile',Auth::user()->mobile)}}" type="text" name="mobile" class="form-control">
                                                                    <span class="err-msg">
                                                                        <p class="help-block">
                                                                            {{$errors->first('mobile')}}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                                <div class="margiv-top-10">
                                                                    <button class="btn green" type="button" onclick="return submit_form($(this),$('#my_profile'));" >Save changes</button>
                                                                    
                                                                    <a onclick="location.reload();"  href="javascript:void(0);" class="btn default"> Cancel </a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END PERSONAL INFO TAB -->
                                                        <!-- CHANGE PASSWORD TAB -->
                                                        <div class="tab-pane {{(session('current_tab') == 'password')?'active':''}}" id="tab_1_3">
                                                            <form action="{{route('user.change.password.post')}}" method="post" id="change_pass_frm">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label class="control-label">Current Password</label>
                                                                    <span class="required">*</span>
                                                                    <input name="current_password" type="password" class="form-control" />
                                                                    <span class="err-msg">
                                                                        <p class="help-block">{{$errors->first('current_password')}}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">New Password</label>
                                                                    <span class="required">*</span>
                                                                    <input name="new_password" type="password" class="form-control" />
                                                                    <span class="err-msg">
                                                                        <p class="help-block">
                                                                            {{$errors->first('new_password')}}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Re-type New Password</label>
                                                                    <span class="required">*</span>
                                                                    <input name="re_enter_new_password" type="password" class="form-control" />
                                                                    <span class="err-msg">
                                                                        <p class="help-block">{{$errors->first('re_enter_new_password')}}
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                                <div class="margin-top-10">
                                                                    <button class="btn blue" type="button" onclick="return submit_form($(this),$('#change_pass_frm'))">Update password</button>

                                                                    <a onclick="location.reload();" href="javascript:;" class="btn default"> Cancel </a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END CHANGE PASSWORD TAB -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
