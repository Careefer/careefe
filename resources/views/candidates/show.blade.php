@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('candidates.candidate.index') }}">Candidates</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View Candidate</span>
                </li>
            </ul>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase">
                            <i class="fa fa-edit"></i>&nbspUpdate Candidate
                        </h4>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <th>Candidate id</th>
                                <td>{{$candidate->candidate_id}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{$candidate->name}}</td>
                            </tr>
                            <tr>
                                <th>Location</th>

                                <td>
                                    @if(isset($candidate->current_location->world_location->location))
                                    {{$candidate->current_location->world_location->location}}
                                    @else
                                    --
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$candidate->email}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{($candidate->phone)?$candidate->phone:'--'}}</td>
                            </tr>
                            <tr>
                                <th>Current company</th>
                                <td>
                                    @if(isset($candidate->current_company->company_name))
                                    {{$candidate->current_company->company_name}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Recent education</th>
                                <td>
                                    @if(isset($candidate->recent_education->course))
                                    {{$candidate->recent_education->course}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>CV</th>

                                <td>
                                    @php
                                      $cv_path = storage_path('app/public/candidate/resume/'.$candidate->resume);
                                      $encrypt = base64_encode($cv_path);
                                    @endphp

                                    @if($candidate->resume && file_exists($cv_path))
                                        <a href="{{route('admin.dashboard')}}?f={{$encrypt}}">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                            Click to download
                                        </a>
                                    @else
                                    --
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <th>Cover letter</th>
                                <td>
                                    @php
                                      $cover_letter_path = storage_path('app/public/candidate/cover_letter/'.$candidate->cover_letter);

                                      $encrypt = base64_encode($cover_letter_path);
                                    @endphp

                                    @if($candidate->cover_letter && file_exists($cover_letter_path))
                                        <a href="{{route('admin.dashboard')}}?f={{$encrypt}}">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                            Click to download
                                        </a>
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection