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
                <span>Manage Jobs</span>
            </li>
        </ul>
    </div> -->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">Manage Jobs
                        </span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <button onclick="redirect_url($(this),'{{ route('jobs.job.create') }}');" class="btn sbold green">
                                <i class="fa fa-plus"></i> Create New                                   
                            </button>
                        </div>
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
                                    <th width="200" class="all">Job Id</th>
                                    <th width="350" class="tablet-p tablet-l desktop">Employer Name</th> 
                                    <th width="350" class="tablet-p tablet-l desktop">Position</th> 
                                    <th width="250" class="tablet-p tablet-l desktop">Work Type</th>
                                    <th class="none">Location</th>
                                    <th class="tablet-p tablet-l desktop">Posted</th>
                                    <th class="none">Specialist</th>
                                    <th class="none">Careefer Commission</th>
                                    <th class="none">Referral Bonus</th>
                                    <th class="none">Specialist Bonus</th>
                                    <th class="tablet-p tablet-l desktop">Views</th>
                                    <th class="tablet-p tablet-l desktop">Applications</th>
                                    <th width="250" class="tablet-p tablet-l desktop">Status</th>
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
                                                <input type="text" placeholder="Job Id" name="job_id" class="form-control form-filter input-sm">
                                            </div>
                                        </td>

                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <input type="text" placeholder="Employer" name="employer" class="form-control form-filter input-sm">
                                            </div>
                                        </td> 

                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <input type="text" placeholder="Position" name="position" class="form-control form-filter input-sm">
                                            </div>
                                        </td>

                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <input type="text" placeholder="Specialist" name="specialist" class="form-control form-filter input-sm">
                                            </div>    
                                        </td>

                                        <td rowspan="1" colspan="1">
                                            <div class="margin-bottom-5">
                                                <input type="text" placeholder="Status" name="status" class="form-control form-filter input-sm">
                                            </div>
                                        </td>

                                        

                                        <td rowspan="1" colspan="1">
                                            <div class="date-wrap d-flex">
                                                <div class="input-group date careefer-date-picker margin-bottom-5">
                                                    <input type="text" placeholder="Posted Date" name="date" readonly="" class="form-control form-filter input-sm">
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
                                        <td rowspan="1" colspan="1">
                                        </td>

                                        <td rowspan="1" colspan="1">
                                        </td>

                                        <td rowspan="1" colspan="1">
                                        </td>

                                        <td rowspan="1" colspan="1">
                                        </td>
                                        
                                        <td rowspan="1" colspan="1">
                                        </td>
                                        
                                        <td rowspan="1" colspan="1">
                                        </td>

                                        <td rowspan="1" colspan="1">
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
                {data: 'job_id', name: 'job_id', "bSortable": true},
                {data: 'company.company_name', name: 'company.company_name', "bSortable": true},
                {data: 'position.name', name: 'position.name', "bSortable": true},
                {data: 'work_type.name', name: 'work_type.name', "bSortable": true},
                {data: 'job_location', name: 'job_location', "bSortable": false},
                {data: 'created_at', name: 'created_at', "bSortable": true},
                {data: 'specialist.name', name: 'specialist.name', "bSortable": false},
                {data: 'commission_amt', name: 'commission_amt', "bSortable": true},
                {data: 'referral_bonus_amt', name: 'referral_bonus_amt', "bSortable": true},
                {data: 'specialist_bonus_amt', name: 'specialist_bonus_amt', "bSortable": true},
                {data: 'total_views', name: 'total_views', "bSortable": true},
                {data: 'no_of_applications', name: 'no_of_applications', "bSortable": true},
                {data: 'status', name: 'status', "bSortable": true},
                {data: 'action', name: 'action', "bSortable": false, searchable: false}
            ];

            default_sort_column = [[5, "desc"]];
            
            var export_columns = [0,1,2,3,4,5,6,7,8,9];

            var file_name = 'Jobs';
            
            datatable_with_export(sort_arr,default_sort_column,export_columns,file_name);
        });
    </script>

@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
@endpush

@endsection
