@extends('layouts.app')

@section('content')

    <!-- <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('timezones.timezone.index') }}">Timezones</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Timezone</span>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspUpdate Timezone
                            </h4>
                        </div>
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

                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('timezones.timezone.update', $timezone->id) }}" id="edit_timezone_form" name="edit_timezone_form" accept-charset="UTF-8" >

                            <div class="form-body">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                @include ('timezones.form', [
                                                        'timezone' => $timezone,
                                                      ])

                            </div>
                            <div class="form-actions noborder">
                                
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_timezone_form"))'>
                                    Update
                                </button>
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('timezones.timezone.index') }}')">Cancel
                                </button>
                            </div>    
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div> -->

    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <span>Dashboard</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ route('timezones.timezone.index') }}">Timezones</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Edit Timezone</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-edit"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Edit Work Type
                            </span>
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('timezones.timezone.update', $timezone->id) }}" id="edit_timezone_form" name="edit_timezone_form" accept-charset="UTF-8">
                        <div class="form-body">
                            <div class="form-body">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="edit_id" value="{{$timezone->id}}">
                            @include ('timezones.form', [
                            'timezone' => $timezone,
                            ])
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_timezone_form"))'>
                                        Update
                                    </button>
                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('timezones.timezone.index') }}')">Cancel
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
