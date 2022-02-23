@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{route('admin.dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Manage Countries</span>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">Manage Countries
                        </span>

                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <button onclick="redirect_url($(this),'{{ route('countries.country.create') }}');" class="btn sbold green">
                                <i class="fa fa-plus"></i> Add Country                                   
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span class="selected-rows"></span>
                            <a href="javascript:void(0)" class="btn-filter">
                                <i class="fa fa-filter"></i>
                                <span>Filters</span>
                            </a>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive table-checkable service-table" id="datatable_ajax">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="200" class="all">Country</th>
                                    <th width="350" class="tablet-p tablet-l desktop">Time Zone</th> 
                                    <th width="350" class="tablet-p tablet-l desktop">Status</th> 
                                    <th width="350" class="tablet-p tablet-l desktop">Date Added</th>
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
                                            <input type="text" placeholder="Country" name="name" id="name" class="form-control form-filter input-sm">
                                            </div>
                                        </td>

                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <input type="text" placeholder="Time Zone" name="timezone" class="form-control form-filter input-sm">
                                            </div>
                                        </td> 

                                        <td rowspan="1" colspan="1">
                                           <div class="margin-bottom-5">
                                            <select class="form-control form-filter input-sm" name="status">
                                                <option value="">Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </td>

                                        <td rowspan="1" colspan="1">
                                             <div class="date-wrap d-flex">
                                            <div class="input-group date careefer-date-picker margin-bottom-5">
                                                <input type="text" placeholder="Date Added" name="date" readonly="" class="form-control form-filter input-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-sm default">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                           </div>
                                        </td>

                                        <td rowspan="1" colspan="1">
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

            var sort_arr = [
                            {
                                data: 'name',
                                name: 'name',
                                "bSortable": true
                            },
                            {
                                data: 'timezone.name',
                                name: 'timezone.name',
                                "bSortable": true
                            },
                            {
                                data: 'status',
                                name: 'status',
                                "bSortable": true
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                "bSortable": true
                            },
                            {
                                data: 'action',
                                name: 'action',
                                "bSortable": false
                            }
                        ];

            default_sort_column = [[0, "asc"]];
            
            var export_columns = [0,1,2,3];

            var file_name = 'Countries';
            
            datatable_with_export(sort_arr,default_sort_column,export_columns,file_name);
        });
    </script>

    <script>
       $(document).ready(function() {
        src = "{{ route('countries.country.allCountries') }}";
         $("#name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: src,
                    dataType: "json",
                    data: {
                        term : request.term
                    },
                    success: function(data) {
                        response(data);
                       
                    }
                });
            },
            minLength: 2,
           
        });
    });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.ui.autocomplete.css')}}">
@endpush

@endsection
