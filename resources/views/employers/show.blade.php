@extends('layouts.app')
@section('content')
    
    <div class="page-content">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{route('employers.employer.index')}}"> Manage Employers</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View Employer</span>
                </li>
            </ul>
        </div> -->

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-eye"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                VIEW EMPLOYER
                            </span>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Employer ID</th>
                                <td>{{ $employer->employer_id }}</td>
                            </tr>
                            <tr>
                                <th>Company name</th>
                                <td>{{ $employer->company_name }}</td>
                            </tr>                           
                            <tr>
                                <th>Head Office</th>
                                <td>    
                                    @if(isset($employer->head_office->location))
                                    {{ $employer->head_office->location }}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Branch Offices</th>
                                <td>
                                    @php
                                        $branchs = $employer->branch_locations();
                                    @endphp

                                    @if($branchs->count())
                                        <ol>
                                            @foreach($branchs->toarray() as $val)
                                                <li>{{$val}}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        {{ "--" }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Industry</th>
                                <td>{{ optional($employer->industry)->name }}</td>
                            </tr>
                            <tr>
                                <th>Company Size</th>
                                <td>{{ $employer->size_of_company }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>{{ $employer->website_url }}</td>
                            </tr>
                            <tr>
                                <th>About Company</th>
                                <td width="800">{{ $employer->about_company }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $employer->status }}</td>
                            </tr>
                            <tr>
                                <th>Logo</th>
                                <td>
                                    <img width="150" src="{{ asset('storage/employer_logos/'.$employer->logo) }}">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <!-- <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('employers.employer.index') }}')">
                                        Cancel
                                    </button> -->
                                </td>
                            </tr>    
                        </table>
                    </div>
                                            
                </div>
            </div>
        </div>
    </div>
@endsection