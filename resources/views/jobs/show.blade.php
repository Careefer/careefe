@extends('layouts.app')

@section('content')
    @php
      $currency_sign = '';

      if($obj_job->country->currency_sign)
      {
        $currency_sign = $obj_job->country->currency_sign->symbol;
      }
    @endphp

<div class="page-content">
    <div class="portlet light bordered">
        <!-- <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('jobs.job.index') }}">Jobs</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Create New Job</span>
                </li>
            </ul>
        </div> -->
        <div class="row">

            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase">
                            <i class="fa fa-edit"></i>&nbspView Job
                        </h4>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                              <th>Logo</th>
                              <th>@if($obj_job->company->logo!='default.png') <img  src="{{ asset('storage/employer_logos/'.@$obj_job->company->logo) }}"  alt="" height="50" width="50" class="rounded-circle">@else --  @endif</th>
                            </tr>    
                            <tr>
                                <th>Job Id</th>
                                <td>{{$obj_job->job_id}}</td>
                            </tr>
                            <tr>
                                <th>Employer Name</th>
                                <td>{{!empty($obj_job->company->company_name)?$obj_job->company->company_name:" "}}</td>
                            </tr>

                            <tr>
                                <th>Position</th>
                                <td>{{!empty($obj_job->position->name)?$obj_job->position->name:" "}}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>
                                    @if($obj_job->cities())
                               
                                     {{implode(',',$obj_job->cities())}}<br>
                                     <strong> {{implode(',',$obj_job->state())}}</strong><br>
                                     <strong>{{$obj_job->country->name}}</strong>
                                   
                                   @else
                                   
                                      echo 'location not available';
                                    
                                   @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Careefer Commission</th>
                                <td>
                                    @php
                                 $amount = '';
                                 if($obj_job->commission_type == 'amount')
                                 {
                                   $amount.=$currency_sign;
                                 }

                                 $amount .= $obj_job->commission_amt;

                                 if($obj_job->commission_type == 'percentage')
                                 {
                                   $amount.='%';                            
                                 }
                                 echo $amount;
                               @endphp
                                </td>
                            </tr>
                            <tr>
                                <th>Experience</th>
                                <td>{{$obj_job->experience_min.'-'.$obj_job->experience_max}} yrs.</td>
                            </tr>
                            <tr>
                                <th>Work Type</th>
                                <td>{{($obj_job->work_type)?$obj_job->work_type->name:'Not specified'}}</td>
                            </tr>
                            <tr>
                                <th>Specialist</th>
                                <td>

                                @if(!empty($obj_job->jobSpecialist) && @$obj_job->jobSpecialist->primary_specialist_status == 'decline' || @$obj_job->jobSpecialist->secondary_specialist_status == 'decline')
                                
                                {{ (@$obj_job->jobSpecialist->primary_specialist_status == 'decline' && @$obj_job->jobSpecialist->secondary_specialist_status == 'decline') ? $obj_job->primary_specialist->name .', '.$obj_job->secondary_specialist->name : (@$obj_job->jobSpecialist->primary_specialist_status == 'decline' ? $obj_job->primary_specialist->name : (@$obj_job->jobSpecialist->secondary_specialist_status == 'decline'? $obj_job->secondary_specialist->name : $obj_job->specialist->name )) }}

                              @elseif(@$obj_job->specialist->name)
                                {{ @$obj_job->specialist->name }}
                              @else 
                              <label style="color: red">Not specified</label> 
                              @endif
                              </td>
                            </tr>
                            <tr>
                                <th>Vacancies</th>
                                <td>
                                    {{$obj_job->vacancy}}
                                </td>
                            </tr>
                            <tr>
                                <th>Skills</th>
                                <td>
                                     @if($obj_job->skills())
                                   {{implode(', ',$obj_job->skills())}}
                                @else
                                  Not specified
                                @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Salary</th>
                                <td>
                                    <span><span>{{$currency_sign}}</span>{{$obj_job->salary_min}}K &nbsp;-&nbsp; <span>{{$currency_sign}}</span>{{$obj_job->salary_max}}K</span>
                                </td>
                            </tr>

                            <tr>
                                <th>Job Type</th>
                                <td>{{!empty($obj_job->job_nature->title)?$obj_job->job_nature->title:" "}}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>{{!empty($obj_job->status)?$obj_job->status:" "}}</td>
                            </tr>

                            <tr>
                                <th>Job Summary</th>
                                <td>
                                    {{$obj_job->summary}}
                                </td>
                            </tr>


                            <tr>
                                <th>Job Description</th>
                                <td>
                                    {{$obj_job->description}}
                                </td>
                            </tr>


                            <tr>
                                <th>Functional Area</th>
                                <td>
                                    @if($obj_job->functional_area())
                              {{implode(', ',$obj_job->functional_area())}}
                             @else
                              Not specified
                             @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Qualifications Required</th>
                                <td>
                                     @if($obj_job->educations())
                                        {{implode(', ',$obj_job->educations())}}
                                    @else
                                        Not specified
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Referral Bonus</th>
                                <td>
                                    @if($obj_job->referral_bonus_amt)
                               {{$obj_job->referral_bonus_amt}}
                            @else
                                Not specified
                            @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Specialist Bonus</th>
                                <td>
                                     @if($obj_job->specialist_bonus_amt)
                               {{$obj_job->specialist_bonus_amt}}
                            @else
                                Not specified
                            @endif  
                                </td>
                            </tr>

                            <tr>
                                <th>Views</th>
                                <td>
                                     @if($obj_job->total_views)
                               {{$obj_job->total_views}}
                            @else
                                0
                            @endif  
                                </td>
                            </tr>
                            <tr>
                                <th>Number of applications</th>
                                <td>
                                     @if($obj_job->applications())
                                       {{$obj_job->applications()}}
                                    @else
                                        0
                                    @endif  
                                </td>
                            </tr>
                            <tr>
                                <th>Posted</th>
                                <td>
                                     @php
                              echo date('d M, Y h:i a',strtotime($obj_job->created_at))
                            @endphp IST  
                                </td>
                            </tr>
                        </table>

                        @php 
                        $base_url    = App::make('url')->to('/');
                        $module_name = '/admin/jobs';
        
                        $edit_url = $base_url.'/'.$module_name.'/'.$obj_job->id.'/edit/';
                        
                        $delete_url = $base_url.'/'.$module_name.'/'.$obj_job->id.'/delete/';

                        @endphp 

                        <button class="btn btn-success" onclick="redirect_url($(this),'{{ $edit_url }}',true)">Edit</button>

                        <a href="javascript:void(0);" onclick="confirmation('{{$delete_url }}', 'Delete Job', 'Please confirm if you want to delete this job listing?')"><button class="btn btn-danger">Delete</button></a>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection