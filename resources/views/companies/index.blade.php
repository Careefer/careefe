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
                    <span>Create New Company</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase"><i class="fa fa-list"></i>&nbspCompany
                            <!-- <button class="btn blue active btn-outline btn-circle pull-right" onclick="redirect_url($(this),'{{ route('manage_companies.manage_company.create') }}');">
                                Create New Company
                            </button> -->
                        </h4>
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
                </div>
                <div class="portlet-body form">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th style="width: 100px;">Company Name</th>
                                <th>Company Logo</th>
                                <th>Website Url</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            <tr class="filter" role="row">                               
  
                                <td rowspan="1" colspan="1">
                                   <div class="margin-bottom-5">
                                    <input type="text" placeholder="Company Name" name="company_name" class="form-control form-filter input-sm">
                                </td>

                                <td></td>

                                <td rowspan="1" colspan="1">
                                   <div class="margin-bottom-5">
                                    <input type="text" placeholder="Website Url" name="website_url" class="form-control form-filter input-sm">
                                </td>


                               <td rowspan="1" colspan="1">
                                    <div data-date-format="dd/mm/yyyy" class="input-group date date-picker margin-bottom-5" data-date-container=".portlet-body">
                                        <input type="text" placeholder="Date" name="created_at" readonly="" class="form-control form-filter input-sm">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-sm default">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
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
        jQuery(document).ready(function() {
            sort_arr = [
                        {"bSortable": true},
                        {"bSortable": false},
                        {"bSortable": true},
                        {"bSortable": true},
                        {"bSortable": false},
                    ];
            draw_table(sort_arr);
        });
    </script>
@endpush

@endsection
