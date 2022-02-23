@extends('layouts.app')

@section('content')

    <!-- <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('currencies.currency.index') }}">Currencies</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Currency</span>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspUpdate Currency
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
                        <form method="POST" action="{{ route('currencies.currency.update', $currency->id) }}" id="edit_currency_form" name="edit_currency_form" accept-charset="UTF-8" >

                            <div class="form-body">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                @include ('currencies.form', [
                                                        'currency' => $currency,
                                                      ])

                            </div>
                            <div class="form-actions noborder">
                                
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_currency_form"))'>
                                    Update
                                </button>
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('currencies.currency.index') }}')">Cancel
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
                    <a href="">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{route('currencies.currency.index')}}">Manage Currencies</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Update Currency</span>
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
                                Update Currency
                            </span>
                        </div>
                    </div>

                     <form data-parsley-validate="true" class="form-horizontal" autocomplete="off" action="{{ route('currencies.currency.update', $currency->id) }}" accept-charset="UTF-8" id="edit_currency_form" name="edit_currency_form" method="post">
                        <div class="form-body">
                            
                            <input name="_method" type="hidden" value="PUT">

                            {{ csrf_field() }}
                                @include ('currencies.form', [
                                                        'currency' =>$currency,
                                                      ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <button type="button" class="btn blue" onclick='submit_form($(this),$("#edit_currency_form"))'>
                                            Update
                                        </button>
                                        <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('currencies.currency.index') }}')">Cancel
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
