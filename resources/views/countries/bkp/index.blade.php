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
                    <span>Create New Country</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase"><i class="fa fa-list"></i>&nbspCountry
                            
                        </h4>
                    </div>

                    <div class="actions-wrap">
                        <button class="btn blue active btn-outline btn-circle pull-right" onclick="redirect_url($(this),'{{ route('countries.country.create') }}');">
                                Create New Country
                        </button>
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
                                <th width="20%">Name</th>
                                <th>Timezone</th>
                                <th>Status</th>
                                <th>Created_at</th>
                                <th width="20%">Action</th>
                            </tr>

                            <tr class="filter" role="row">                               

                                <td rowspan="1" colspan="1">
                                   <div class="margin-bottom-5">
                                    <input type="text" placeholder="Name" name="name" class="form-control form-filter input-sm">
                                </td>
                                
                                <td rowspan="1" colspan="1">
                                   <div class="margin-bottom-5">
                                    <input type="text" placeholder="Timezone" name="timezone" class="form-control form-filter input-sm">
                                </td>
                                
                                <td rowspan="1" colspan="1">
                                   <div class="margin-bottom-5">
                                    <select class="form-control form-filter input-sm" name="status">
                                        <option value=""> All </option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
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
            
            draw_country_table();
        });
    </script>
@endpush

@endsection
