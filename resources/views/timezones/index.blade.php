@extends('layouts.app')
@section('content')
<div class="page-content">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('admin.dashboard')}}">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Timezone</span>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-list"></i>
                            <span class="caption-subject bold uppercase">Timezone
                            </span>
                        </div>
                        <!-- <div class="actions">
                            <div class="btn-group">
                                <button onclick="redirect_url($(this),'{{ route('work_types.work_type.create') }}');" class="btn sbold green">
                                    <i class="fa fa-plus"></i> Create New                                   
                                </button>
                            </div>
                        </div> -->
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
                                        <th width="400" class="all">Timezone</th>
                                        <th width="350" class="tablet-l desktop">Status</th>
                                        <th width="350" class="tablet-l desktop">Created At</th>
                                        <th width="130" class="all">Actions</th>
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
                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <input type="text" placeholder="Name" name="name" class="form-control form-filter input-sm">
                                            </div>
                                        </td>
                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <select class="form-control form-filter input-sm" name="status">
                                                    <option value=""> Active / Inactive </option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td rowspan="1" colspan="1">
                                             <div class="date-wrap d-flex">
                                            <div class="input-group date careefer-date-picker margin-bottom-5">
                                                <input type="text" placeholder="Date" name="date" readonly="" class="form-control form-filter input-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-sm default">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                           </div>
                                        </td> 

                                        <td rowspan="1" colspan="1" class="filter-action action-bottom">
                                            <button class="btn filter-submit btn-back">
                                           Apply</button>
                                        </td>
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
            sort_arr = [
                {data: 'name', name: 'name', "bSortable": true},
                {data: 'status', name: 'status', "bSortable": true},
                {data: 'created_at', name: 'created_at', "bSortable": true},
                {data: 'action', name: 'action', "bSortable": false, searchable: false}
            ];

            default_sort_column = [[2, "desc"]];
            
            draw_normal_datatable(sort_arr,default_sort_column);

        });
    </script>

@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
@endpush

@endsection
