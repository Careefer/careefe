@extends('layouts.app')
@section('content')
<div class="page-content application-page-content">
    <div class="row">
        <div class="col-md-12">
           @include('payments.specialist.include.top_bar')
        </div>    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">Specialist Unpaid Payments
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
                                    <th width="200" class="all">Job id</th> 
                                    <th width="200" class="tablet-p tablet-l desktop">Transaction Id</th>
                                    <th width="200" class="tablet-p tablet-l desktop">Position</th> 
                                    <th width="200" class="tablet-p tablet-l desktop">Employer name</th>
                                    <th width="200" class="tablet-p tablet-l desktop">Specialist Bonus amount</th>
                                    <th width="200" class="tablet-p tablet-l desktop">Specialist Name</th>
                                    <th width="200" class="tablet-p tablet-l desktop">Applicant's Name</th>
                                    <th width="200" class="none">Payment status</th>
                                    <th width="200" class="none">Bank detail</th> 
                                    <th width="100" class="all">Actions</th>
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
                                            <input type="text" placeholder="Job Id" name="job_id" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Txn Id" name="txn_id" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Position" name="position" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Employer Name" name="company_name" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Specialist Name" name="name" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Candidate Name" name="candidate_name" class="form-control form-filter input-sm">
                                        </td>
                                        <td>
                                            <select class="form-control form-filter input-sm" name="payment_status">
                                                <option value="">Payment Status</option>
                                                 <option value="1">Paid</option>
                                                 <option value="zero">Unpaid</option>
                                                 <option value="2">Hold</option>
                                                 <option value="3">Cancelled</option>
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
                                data: 'job.job_id',
                                name: 'job.job_id',
                                "bSortable": true
                            },
                            {
                                data: 'txn_id',
                                name: 'txn_id',
                                "bSortable": true
                            },
                            {
                                data: 'job.position.name',
                                name: 'job.position.name',
                                "bSortable":true
                            },
                            {
                                data: 'job.company.company_name',
                                name: 'job.company.company_name',
                                "bSortable": true
                            },
                            {
                                data: 'amount',
                                name: 'amount',
                                "bSortable": true
                            },
                            {
                                data: 'specilist.name',
                                name: 'specilist.name',
                                "bSortable": true
                            },
                            {
                                data: 'application.name',
                                name: 'application.name',
                                "bSortable": true
                            },
                            {   
                                data: 'is_paid',
                                name: 'is_paid',
                                "bSortable": false
                            },
                            {
                                data: 'bank_detail',
                                name: 'bank_detail',
                                "bSortable": false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                "bSortable": false,
                                searchable: false
                            }                            
                        ];

            default_sort_column = [];
            
            var export_columns = [0,1,2,3,4,5,6,7];

            var file_name = 'Specialist Paid Payments';
            
            datatable_with_export(sort_arr,default_sort_column,export_columns,file_name);
        });
    </script>
@endpush
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
@endpush
@endsection
