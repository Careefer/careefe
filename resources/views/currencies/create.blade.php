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
                    <a href="{{route('currencies.currency.index')}}">Manage Currencies</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create New Currency</span>
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
                                Create New Currency
                            </span>
                        </div>
                    </div>

                     <form data-parsley-validate="true" class="form-horizontal" autocomplete="off" action="{{ route('currencies.currency.store') }}" accept-charset="UTF-8" id="create_currency_form" name="create_currency_form" method="post">
                        <div class="form-body">

                            {{ csrf_field() }}
                                @include ('currencies.form', [
                                                        'currency' => null,
                                                      ])
                
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                        <button type="button" class="btn blue" onclick='submit_form($(this),$("#create_currency_form"))'>
                                            Add
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


