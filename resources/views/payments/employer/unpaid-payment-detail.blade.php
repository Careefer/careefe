@extends('layouts.app')
@section('content')
    
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-title">
                        <div class="caption caption-back">
                            <i class="fa fa-eye"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                VIEW Unpaid Payment Detail
                            </span>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Job id</th>
                                <td>{{ @$payment->job->job_id }}</td>
                            </tr>
                            <tr>
                                <th>Job posted date</th>
                                <td>{{ @$payment->job ? display_date_time($payment->job) : ''  }}</td>
                            </tr>                           
                            <tr>
                                <th>Application id</th>
                                <td>{{ @$payment->application->application_id }}</td>
                            </tr>
                            <tr>
                                <th>Application received date</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Date of submission</th>
                                <td>{{ @$payment->application->created_at ? display_date_time($payment->application->created_at) : '' }}</td>
                            </tr>
                            <tr>
                                <th>Position/ Designation</th>
                                <td>{{ @$payment->job->position->name }}</td>
                            </tr>
                            <tr>
                                <th>Employer name</th>
                                <td>{{ @$payment->job->company->company_name }}</td>
                            </tr>
                            <tr>
                                <th>Careefer Commission</th>
                                <td>{{ (@$payment->commission) ? $payment->commission : '-'  }}</td>
                            </tr>
                            <tr>
                                <th>Candidate name</th>
                                <td>{{ @$payment->application->name }}</td>
                            </tr>
                            <tr>
                                <th>Candidate email</th>
                                <td>{{ @$payment->application->email }}</td>
                            </tr>
                            <tr>
                                <th>Candidate phone number</th>
                                <td>{{ @$payment->application->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Specialist name</th>
                                <td>{{ @$payment->job->primary_specialist ? $payment->job->primary_specialist->name : (@$payment->job->secondary_specialist ? $payment->job->secondary_specialist->name : '' ) }}</td>
                            </tr>
                            
                            <tr>
                                <th>Change Payment status</th>
                                <td>  <form id="payment_form" action="{{ route('admin.payment-status-update')}}" type="GET">
                                      <input type="hidden" name="id" value="{{ $payment->id }}">   
                                      <input type="radio" id="Paid" name="payment_status" value="1" class="payment_status" {{$payment->is_paid == 1 ?  'checked':'' }}>
                                      <label for="Paid"> Paid</label><br>
                                      <input type="radio" id="Unpaid" name="payment_status" value="0" class="payment_status" {{$payment->is_paid == 0 ?  'checked':'' }}>
                                      <label for="Unpaid"> Unpaid</label><br>
                                      <input type="radio" id="Hold" name="payment_status" value="2" class="payment_status" {{$payment->is_paid == 2 ?  'checked':'' }}>
                                      <label for="Hold"> Hold</label><br>
                                      <input type="radio" id="Cancelled-" name="payment_status" value="3" class="payment_status" {{$payment->is_paid == 3 ?  'checked':'' }}>
                                      <label for="Cancelled"> Cancelled</label>
                                      </form>
                                </td>
                            </tr>
                            <tr>
                                <th>Message Applicant</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Message specialist</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Message Employer</th>
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
@push('scripts')
<script type="text/javascript">
    $(function(){
      $('input[type="radio"]').click(function(){
        if ($(this).is(':checked'))
        {
          var payment_status = $(this).val();
          $('#payment_form').submit();
        }
      });
    });
</script>
@endpush    
@endsection