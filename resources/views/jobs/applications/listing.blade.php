@extends('layouts.app')
@section('content')

<div class="page-content application-page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">Job Applications
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
                                    <th width="200" class="all">Application id</th> 

                                    <th width="350" class="tablet-p tablet-l desktop">Applicant name</th> 

                                    <th width="250" class="tablet-p tablet-l desktop">Applicant's Location</th>

                                    <th width="250" class="tablet-p tablet-l desktop">Applicant's Phone</th>

                                    <th width="250" class="tablet-p tablet-l desktop">Date & time applied</th>

                                    <th width="250" class="tablet-p tablet-l desktop">Job id</th>

                                    <th width="250" class="tablet-p tablet-l desktop">Position</th>

                                    <th width="250" class="tablet-p tablet-l desktop">Employer</th>

                                    <th width="250" class="none">Job location</th>

                                    <th width="250" class="none">Specialist assigned</th>

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

                                        <td>
                                            <input type="text" placeholder="Application Id" name="application_id" class="form-control form-filter input-sm">
                                        </td> 

                                        <td>
                                            <input type="text" placeholder="Applicant Name" name="applicant_name" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Application Location" name="application_location" class="form-control form-filter input-sm">
                                        </td>
                                        <td rowspan="1" colspan="1">
                                             <div class="date-wrap d-flex">
                                            <div class="input-group date careefer-date-picker margin-bottom-5">
                                                <input type="text" placeholder="Date & time applied" name="date" readonly="" class="form-control form-filter input-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-sm default">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                           </div>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Job Id" name="job_id" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Position" name="position" class="form-control form-filter input-sm">
                                        </td>

                                        <td>
                                            <input type="text" placeholder="Employer" name="company_name" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <select data-placeholder="Job Location" name="job_location" class="loadAjaxSuggestion form-control form-filter input-sm">
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" placeholder="Specialist Assigned" name="assigned_specialist" class="form-control form-filter input-sm">
                                        </td>

                                        <td>
                                            <select class="form-control form-filter input-sm" name="status">
                                                <option value="">Status</option>
                                                @foreach(APPLICATION_STATUS as $key => $val)
                                                 <option value="{{$key}}">{{$val}}</option>
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
                                data: 'application_id',
                                name: 'application_id',
                                "bSortable": true
                            },
                            {
                                data: 'name',
                                name: 'name',
                                "bSortable":true
                            },
                            {
                                data: 'applicant_location',
                                name: 'applicant_location',
                                "bSortable": false
                            },
                            {
                                data: 'mobile',
                                name: 'mobile',
                                "bSortable": true
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                "bSortable": true
                            },
                            {
                                data: 'job_id',
                                name: 'job_id',
                                "bSortable": true
                            },
                            {
                                data: 'job.position.name',
                                name: 'job.position.name',
                                "bSortable": true
                            },
                            {
                                data: 'job.company.company_name',
                                name: 'job.company.company_name',
                                "bSortable": true
                            },
                            {
                                data: 'job_location',
                                name: 'job_location',
                                "bSortable": false
                            },
                            {
                                data: 'job.primary_specialist.name',
                                name: 'job.primary_specialist.name',
                                "bSortable": true
                            },
                            {
                                data: 'status',
                                name: 'status',
                                "bSortable": true
                            },
                            {
                                data: 'action',
                                name: 'action',
                                "bSortable": false,
                                searchable: false
                            }
                        ];

            default_sort_column = [[0, "desc"]];
            
            var export_columns = [0,1,2,3,4,5,6,7,8,9,10];

            var file_name = 'Job Applications';
            
            datatable_with_export(sort_arr,default_sort_column,export_columns,file_name);
        });
    </script>

@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
@endpush
@endsection
