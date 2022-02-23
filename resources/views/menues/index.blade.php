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
                    <span>Create New Menues</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
					<br>
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase"><i class="fa fa-list"></i>&nbspMenues
                            <button class="btn blue active btn-outline btn-circle pull-right" onclick="redirect_url($(this),'{{ route('menues.menues.create') }}');">
                                Create New Menues
                            </button>
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
                <div class="portlet-body form margin-top-25">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="2%">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable" data-set="#datatable_ajax .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Status</th>
                            <th>Sort</th>
                            <th>Action</th>
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
            draw_table();
        });
    </script>
@endpush

@endsection
