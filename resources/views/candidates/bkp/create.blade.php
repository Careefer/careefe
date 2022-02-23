@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('candidates.candidate.index') }}">Candidates</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Candidate</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspCreate New Candidate
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
                        <form autocomplete="off" method="POST" action="{{ route('candidates.candidate.store') }}" accept-charset="UTF-8" id="create_candidate_form" name="create_candidate_form" >
                            <div class="form-body">
                                {{ csrf_field() }}
                                @include ('candidates.form', [
                                                        'candidate' => null,
                                                      ])
                                
                            </div>                                                  
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_candidate_form"))'>
                                    Add
                                </button>
                                
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('candidates.candidate.index') }}')">Cancel
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


