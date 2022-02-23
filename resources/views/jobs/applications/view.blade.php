@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="portlet light bordered">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('admin.job_applications') }}">Job Applications</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View job application</span>
                </li>
            </ul>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase">
                            <i class="fa fa-edit"></i>&nbspView job application
                        </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('admin.job_applications.status.update', [$obj_application->id]) }}">
                        <table class="table">
                            @csrf
                            <tr>
                                <th>Application id</th>
                                <td>
                                    {{$obj_application->application_id }}
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant name</th>
                                <td>
                                    {{$obj_application->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Job id</th>
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
                                <th>Employer name</th>
                                <td>
                                    {{$obj_application->job->company->company_name }}
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
                                <th>Job location</th>
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
                                            $job_location .= "<b>".implode(', ',$obj_application->job->state())."</b>";
                                            $job_location .= ",&nbsp";
                                        }

                                        $job_location .= '<b>'.$obj_application->job->country->name."</b>";
                                    @endphp
                                    {!!$job_location!!}
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
                                <th>Status</th>
                                <td>
                                    <!-- {{ucwords(str_replace('_', ' ', $obj_application->status))}} -->

                                    <select class="sts-select" id="select-application-status" name="status">
                                      <option value="">Application Status</option>
                                      @foreach($application_status as $key=>$val)

                                      @php
                                         $selected = '';
                                         if(isset($obj_application->status) && $obj_application->status == $key)
                                         {
                                           $selected = 'selected="selected"';
                                         }
                                       @endphp
                                      <option {{$selected}} value="{{ $key }}">{{ $val }}</option>
                                      @endforeach
                                    </select>

                                </td>
                            </tr>
                            <tr class="salary-box">
                                <th>Salary</th>
                                <td><input type="number" name="salary" value="{{ @$obj_application->salary }}"> </td>
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
                                <th>Download Cover letter</th>
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
                                <th>Rating by Specialist</th>
                                <td>
                                    @if($obj_application->rating_by_specialist)
                                    {!!display_rating($obj_application->rating_by_specialist)!!}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Rating by Employer</th>
                                <td>
                                    @if($obj_application->rating_by_employer)
                                    {!!display_rating($obj_application->rating_by_employer)!!}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ratings by Referee</th>
                                <td>
                                    @if($obj_application->rating_by_referee)
                                    {!!display_rating($obj_application->rating_by_referee)!!}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Specialist's notes</th>
                                <td>
                                    @if($obj_application->specialist_notes)
                                    {{$obj_application->specialist_notes}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Employer's notes</th>
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
                                <th>Applicant's email</th>
                                <td>
                                    {{$obj_application->email}}
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant's phone number</th>
                                <td>
                                    {{$obj_application->mobile}}
                                </td>
                            </tr>
                            <tr>
                                <th>Specialist bonus amount</th>
                                <td>
                                    @if(isset($obj_application->job->specialist_bonus_amt))
                                    {{get_amount($obj_application->job->specialist_bonus_amt)}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Referral bonus amount</th>
                                <td>
                                    @if(isset($obj_application->job->referral_bonus_amt))
                                    {{get_amount($obj_application->job->referral_bonus_amt)}}
                                    @else
                                    --
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Referee's Name</th>
                                <td>
                                    @if($obj_application->refer_by)
                                   {{ $obj_application->referred_by->name }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Referee's Email</th>
                                <td>
                                    @if($obj_application->refer_by)
                                     {{ $obj_application->referred_by->email }}
                                    @endif    
                                </td>
                            </tr>

                            <tr>
                                <th>Referee's Phone</th>
                                <td>
                                    @if($obj_application->refer_by)
                                     {{ $obj_application->referred_by->phone }}
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <th>Message Applicant</th>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <th>Message specialist</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <th>Message Employer</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <th>Message Referee</th>
                                <td>
                                    --
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>

                                @if(@$obj_application->status !=='hired') 
                                <button type="submit" class="btn green">Update</button>
                                @endif   

                                    <button type="button" class="btn red" onclick="redirect_url($(this),'{{route('admin.job_applications')}}')">Cancel
                                    </button>
                                </td>
                            </tr>
                        </table>
                        </form>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
  var status =  $('#select-application-status').val();
   if(status == 'hired'){
      $('.salary-box').show();
   }else{
    $('.salary-box').hide();
   }
});

$('.sts-select').on('change', function(){
 var status =  $('#select-application-status').val();
 //price_update('abc','helo', 'text');
 if(status == 'hired'){
    $('.salary-box').show();
 }else{
  $('.salary-box').hide();
 }

 if(status){
  $('#status_application').val(status);
 }   
});
</script>
@endsection