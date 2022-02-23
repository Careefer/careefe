@extends('layouts.app')

@section('content')
<div class="page-content">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Manage Banners</span>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase"><i class="fa fa-list"></i>&nbspManage Banners
                            </h4>
                        </div>
                        <div class="actions">
                        </div>
                        @if(session('error'))    
                            <div  class="alert alert-danger ">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <i class="fa-lg fa fa-close"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="portlet-body form">
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
                                <!-- <a href="javascript:void(0)" class="btn-filter">
                                    <i class="fa fa-filter"></i>
                                    <span>Filters</span>
                                </a> -->
                            </div>  
                            <table class="table table-striped table-bordered table-hover dt-responsive table-checkable service-table" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                    <th width="400" class="all">Name</th>
                                    <th width="350" class="tablet-l desktop">Banner</th>
                                    <th width="350" class="tablet-l desktop">Banner Type</th>
                                    <th width="350" class="tablet-l desktop">Status</th>
                                    <th width="350" class="tablet-l desktop">Modified Date</th>
                                    <th width="200" class="tablet-l desktop">Action</th>
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
                                      <td rowspan="1" colspan="1" class="filter-action action-bottom"></td>
                                      <td rowspan="1" colspan="1" class="filter-action action-bottom"></td>
                                      <td rowspan="1" colspan="1">
                                       <div class="margin-bottom-5">
                                        <select class="form-control form-filter input-sm" name="status">
                                            <option value=""> All </option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        </div>
                                      </td>
                                      <td rowspan="1" colspan="1" class="filter-action action-bottom"></td> 
                                      <td rowspan="1" colspan="1" class="filter-action action-bottom">
                                            <button class="btn filter-submit btn-back">
                                           Apply</button>
                                      </td>  
                                    </tr>    
                                </thead>
                                <tbody>                            
                                </tbody>
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
                {data: 'title', name: 'title', "bSortable": true},
                {data: 'image', name: 'image', "bSortable": false},
                {data: 'type', name: 'type', "bSortable": false},
                {data: 'status', name: 'status', "bSortable": true},
                {data: 'updated_at', name: 'updated_at', "bSortable": true},
                {data: 'action', name: 'action', "bSortable": false, searchable: false}
            ];

            default_sort_column = [[0, "desc"]];
            draw_normal_datatable(sort_arr,default_sort_column);
        });
    </script>
@endpush
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
@endpush
@endsection
