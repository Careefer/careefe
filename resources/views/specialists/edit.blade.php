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
                    <a href="{{ route('specialists.specialist.index') }}">      Manage Specialists
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>    
                    <span>Update Specialist</span>
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
                                Edit Specialist
                            </span>
                        </div>
                    </div>
                    
                    <form data-parsley-validate="true"  class="form-horizontal" method="POST" action="{{ route('specialists.specialist.update', $specialist->id) }}" id="edit_specialist_form" name="edit_specialist_form" accept-charset="UTF-8" enctype="multipart/form-data">    <input name="_method" type="hidden" value="PUT">
                        <div class="form-body">

                            {{ csrf_field() }}

                            @include ('specialists.form', [
                                                        'specialist' => $specialist,
                                                      ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <input type="hidden" name="edit_id" value="{{$specialist->id}}">
                                    <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_specialist_form"))'>
                                        Update
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


