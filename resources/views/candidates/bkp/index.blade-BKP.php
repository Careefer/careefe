@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Manage Candidates</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase"><i class="fa fa-list"></i>&nbspCandidate
                            <button class="btn blue active btn-outline btn-circle pull-right" onclick="redirect_url($(this),'{{ route('candidates.candidate.create') }}');">
                                Create New Candidate
                            </button>
                        </h4>
                    </div>
						@if(session('success'))
							<br>
							<div  class="alert alert-success ">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
								<i class="fa-lg fa fa-check"></i>
								{{ session('success') }}
							</div>
						@elseif(session('error')) 
							<br>   
							<div  class="alert alert-danger ">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
								<i class="fa-lg fa fa-close"></i>
								{{ session('error') }}
							</div>
						@endif

                </div>
                 <div class="portlet-body form">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="10%">Candidate id</th>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Location</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th width="25%">Action</th>
                            </tr>

                            <tr class="filter" role="row">
                                <td rowspan="1" colspan="1">
                                    <input type="text" placeholder="Candidate id" name="candidate_id" class="form-control form-filter input-sm">
                                </td>
                                
                                <td rowspan="1" colspan="1">
                                    <input type="text" placeholder="Name" name="name" class="form-control form-filter input-sm">
                                </td>

                                <td rowspan="1" colspan="1">
                                    <input type="text" placeholder="Email" name="email" class="form-control form-filter input-sm">
                                </td>

                                <td rowspan="1" colspan="1">
                                    <input type="text" placeholder="Location" name="location" class="form-control form-filter input-sm">
                                </td>

                                <td rowspan="1" colspan="1">
                                    <input type="text" placeholder="phone" name="phone" class="form-control form-filter input-sm">
                                </td>

                                <td rowspan="1" colspan="1">
                                    <select class="form-control form-filter input-sm" name="status">
                                        <option value=""> All </option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </td>
                                <td rowspan="1" colspan="1">
                                    <div class="margin-bottom-5">
                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-search"></i> Search</button>
                                        <button class="btn btn-sm red btn-outline filter-cancel">
                                            <i class="fa fa-times"></i> Reset</button>
                                    </div>
                                </td>
                                
                            </tr>

                        </thead>
                        <body>                            
                        </body>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.datatables')

@push('scripts')
    <script>
        jQuery(document).ready(function()
        {   
            var sorts = [
                            {
                                data: 'candidate_id',
                                name: 'candidate_id',
                                "bSortable": true
                            },
                            {
                                data: 'name',
                                name: 'name',
                                "bSortable": true
                            },
                            {
                                data: 'email',
                                name: 'email',
                                "bSortable": true
                            },
                            {
                                data: 'current_location.world_location.location',
                                name: 'current_location.world_location.location',
                                "bSortable": true
                            },
                            {
                                data: 'phone',
                                name: 'phone',
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

            var export_column = [0,1,2,3,4,5];

            var default_sort_column = 0;

            var download_excel_file_name = 'Candidates';                     
            draw_ajax_table_with_export(sorts,export_column,default_sort_column,download_excel_file_name);
        });
    </script>
@endpush

@endsection
