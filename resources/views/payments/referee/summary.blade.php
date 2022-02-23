@extends('layouts.app')
@section('content')
<div class="page-content application-page-content">
    <div class="row">
        <div class="col-md-12">
           @include('payments.referee.include.top_bar')
        </div>    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">Referee Payment Summary
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span class="selected-rows"></span>
                            <div class="invisible">
                                <select class="table-group-action-input form-control input-inline input-small input-sm">
                                    <option value="">- Select Action -</option>
                                    <option value="delete_all">Delete All</option>
                                </select>
                                <button class="btn btn-sm green table-group-action-submit">
                                    <i class="fa fa-check"></i> Submit
                                </button>
                            </div> 
                            <a href="javascript:void(0)" class="btn-filter">
                                <i class="fa fa-filter"></i>
                                <span>Filters</span>
                            </a>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive table-checkable service-table" id="datatable_ajax">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="200" class="all">Referee Name</th> 

                                    <th width="350" class="tablet-p tablet-l desktop">Referee Country</th> 

                                    <th width="250" class="tablet-p tablet-l desktop">Total Paid</th>

                                    <th width="250" class="tablet-p tablet-l desktop">Total Outstanding</th>
                                   <!--  <th width="130" class="all">Actions</th> -->
                                </tr>
                                <tr class="filter" role="row">
                                        <td rowspan="1" colspan="1" class="filter-action">
                                            <button class="btn btn-back visible-xs visible-sm">
                                            <i class="fa fa-arrow-left"></i>
                                            Back
                                            </button>
                                            
                                            <button class="btn btn-back hidden-xs hidden-sm">
                                            <i class="fa fa-close"></i>
                                                Filters
                                            </button>

                                            <button class="btn filter-cancel btn-back">
                                                Reset
                                            </button>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Referee Name" name="name" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <select name="country" data-search="true" placeholder="India" class="careefer-select2 form-control form-filter input-sm">
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td rowspan="1" colspan="1" class="filter-action action-bottom">
                                            <button class="btn filter-submit btn-back">
                                           Apply</button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.datatables')

@push('scripts')
    <script>
        jQuery(document).ready(function() {
            var sort_arr = [
                            {
                                data: 'name',
                                name: 'name',
                                "bSortable": true
                            },
                            {
                                data: 'country',
                                name: 'country',
                                "bSortable":true
                            },
                            {
                                data: 'total_paid',
                                name: 'total_paid',
                                "bSortable": true
                            },
                            {
                                data: 'total_unpaid',
                                name: 'total_unpaid',
                                "bSortable": true
                            }
                        ];

            default_sort_column = [];
            
            var export_columns = [0,1,2,3];

            var file_name = 'Referee Payments';
            
            datatable_with_export(sort_arr,default_sort_column,export_columns,file_name);
        });
    </script>

@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
@endpush
@endsection
