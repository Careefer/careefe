@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('admin.referral_job_applications') }}">Manage referrals</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View referral job application</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase">
                            <i class="fa fa-edit"></i>&nbspView referral job application
                        </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <th>Application ID</th>
                                <td>
                                    {{$obj_application->application_id }}
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant's Name</th>
                                <td>
                                    {{$obj_application->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant's Email</th>
                                <td>
                                    {{$obj_application->email}}
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant's Phone</th>
                                <td>
                                    {{$obj_application->mobile}}
                                </td>
                            </tr>
                            <tr>
                                <th>Application Status</th>
                                <td>
                                    {{ucwords(str_replace('_', ' ', $obj_application->status))}}
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant's Location</th>
                                <td>
                                    @php
                                        if(isset($obj_application->candidate->current_location->world_location->location))
                                        {
                                            $location = $obj_application->candidate->current_location->world_location->location;
                                        }
                                        else
                                        {
                                            $location = '--';
                                        }
                                    @endphp
                                    {{$location}}
                                </td>
                            </tr>
                            <tr>
                                <th>Job ID</th>
                                <td>
                                    {{$obj_application->job->job_id }}
                                </td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td>
                                    {{$obj_application->job->position->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Employer Name and Logo</th>
                                <td>
                                    <a target="_blank" href="{{route('web.company.detail',[$obj_application->job->company->slug])}}">
                                    {{$obj_application->job->company->company_name }}

                                    @php
                                        $logo_path = public_path('storage/employer_logos/'.$obj_application->job->company->logo);
                                        $file = asset('storage/employer_logos/'.$obj_application->job->company->logo);
                                    @endphp

                                    @if(file_exists($logo_path))
                                    &nbsp&nbsp<img src="{{$file}}">
                                    @endif
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Job Location</th>
                                <td>
                                    @php
                                        $job_location = '';

                                        if($obj_application->job->cities())
                                        {
                                            $job_location .= implode(', ',$obj_application->job->cities());
                                            $job_location .= ",&nbsp";
                                        }

                                        if($obj_application->job->state())
                                        {
                                            $job_location .= "".implode(', ',$obj_application->job->state())."";
                                            $job_location .= ",&nbsp";
                                        }

                                        $job_location .= ''.$obj_application->job->country->name."";
                                    @endphp
                                    {!!$job_location!!}
                                </td>
                            </tr>
                            <tr>
                                <th>Job Status</th>
                                <td>
                                    {{ucwords(str_replace('_', ' ', $obj_application->job->status))}}
                                </td>
                            </tr>
                            <tr>
                                <th>Referee's Name</th>
                                <td>
                                    @if($obj_application->refer_by) 

                                    {{ $obj_application->referred_by->name }}
                                       
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Referee's Email</th>
                                <td>
                                    @if($obj_application->refer_by) 
                                    
                                    {{ $obj_application->referred_by->email }}
                                       
                                    @else
                                    --
                                    @endif
                                       
                                </td>
                            </tr>


                            <tr>
                                <th>Referee's Phone</th>
                                <td>
                                    @if($obj_application->refer_by) 
                                    
                                    {{ $obj_application->referred_by->phone }}
                                       
                                    @else
                                    --
                                    @endif
                               </td>
                            </tr>
                            
                            
                            <tr>
                                <th>Primary Specialist</th>
                                <td>
                                    @php
                                    if(isset($obj_application->job->primary_specialist->name))
                                    {
                                        $spc1 = ucwords($obj_application->job->primary_specialist->name);
                                    }
                                    else
                                    {
                                        $spc1 = '--';
                                    }
                                    @endphp
                                    {{$spc1}}
                                </td>
                            </tr>
                            <tr>
                                <th>Secondary Specialist</th>
                                <td>
                                    @php
                                    if(isset($obj_application->job->secondary_specialist->name))
                                    {
                                        $spc2 = ucwords($obj_application->job->secondary_specialist->name);
                                    }
                                    else
                                    {
                                        $spc2 = '--';
                                    }
                                    @endphp
                                    {{$spc2}}
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Download Resume</th>
                                <td>
                                    @php
                                      $cv_path = storage_path('app/public/candidate/resume/'.$obj_application->resume);
                                      $encrypt = base64_encode($cv_path);
                                    @endphp

                                    @if(file_exists($cv_path))
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
                                <th>Download Cover Letter</th>
                                <td>
                                    @php
                                      $cl_path = storage_path('app/public/candidate/cover_letter/'.$obj_application->cover_letter);
                                      $encrypt = base64_encode($cl_path);
                                    @endphp

                                    @if(file_exists($cl_path))
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
                                <th>'Specialist's Rating</th>
                                <td>
                                    @if($obj_application->rating_by_specialist)
                                    {!!display_rating($obj_application->rating_by_specialist)!!}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Employer's Rating</th>
                                <td>
                                    @if($obj_application->rating_by_employer)
                                    {!!display_rating($obj_application->rating_by_employer)!!}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Referee's Rating</th>
                                <td>
                                    @if($obj_application->rating_by_referee)
                                    {!!display_rating($obj_application->rating_by_referee)!!}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Specialist's Note</th>
                                <td>
                                    @if($obj_application->specialist_notes)
                                    {{$obj_application->specialist_notes}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Employer's Note</th>
                                <td>
                                    @if($obj_application->employer_notes)
                                    {{$obj_application->employer_notes}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date & time of application received</th>
                                <td>
                                    {{display_date_time($obj_application->created_at)}}
                                </td>
                            </tr>
                            <tr>
                                <th>Specialist Bonus Amount</th>
                                <td>
                                    @if(isset($obj_application->job->specialist_bonus_amt))
                                    {{get_amount($obj_application->job->specialist_bonus_amt)}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Referral Bonus Amount</th>
                                <td>
                                    @if(isset($obj_application->job->referral_bonus_amt))
                                    {{get_amount($obj_application->job->referral_bonus_amt)}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Message specialist</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <th>Message employer</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <th>Message referee</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <th>Message candidate</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <th>Further information for Employer</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <!-- <button type="button" class="btn red" onclick="redirect_url($(this),'{{route('admin.referral_job_applications')}}')">Cancel
                                    </button> -->
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