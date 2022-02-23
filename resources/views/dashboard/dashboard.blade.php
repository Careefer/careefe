@extends('layouts.app')

@section('content')

        <div class="page-content">
            <div class="page-bar">
               <ul class="page-breadcrumb">
                  <li>
                     <a href="index.html">Home</a>
                     <i class="fa fa-circle"></i>
                  </li>
                  <li>
                     <span>Dashboard</span>
                  </li>
               </ul>
            </div>
            <div>
                <h1 class="page-title">Dashboard Stats</h1>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
                        <div class="dashboard-stat" style="float: right; width: 200px;">
                        <form method="GET" action="{{ route('admin.dashboard') }}" id="filter">    
                        @php

                        $date_filter = ['today'=>'Today', 'week'=>'Week', 'month'=>'Month', 'all'=>'ALL'];

                        @endphp
                        <select data-parsley-required="timezone" class="careefer-select2 form-control" id="date_type" name="type">
                        <option></option>
                        @foreach ($date_filter as $key => $value)
                            <option value="{{ $key }}" {{ app('request')->input('type') == $key ? "selected" : ''   }}>
                                {{ $value }}
                            </option>
                        @endforeach
                        </select>

                        </form>
                        </div>
                    </div>        
                </div>    
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                            <div class="visual">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    @php
                                    $total_users = isset($total_users)?$total_users:0;
                                    @endphp
                                    <span data-counter="counterup" data-value="{{ $total_users }}">{{ $total_users }}</span>
                                </div>
                                <div class="desc">Total number of users </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_candidate }}">{{ $total_candidate }}</span>
                                </div>
                                <div class="desc">Total number of Candidates </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_specialist }}">{{ $total_specialist }}</span>
                                </div>
                                <div class="desc">Total number of Specialists</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_employer }}">{{ $total_employer }}</span></div>
                                <div class="desc">Total number of Employers </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_jobs }}">{{ $total_jobs }}</span></div>
                                <div class="desc">Total Jobs </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_applications }}">{{ $total_applications }}</span></div>
                                <div class="desc">Total Applications </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $hired_applications }}">{{ $hired_applications }}</span></div>
                                <div class="desc">Total Hired Applications </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $successful_applications }}">{{ $successful_applications }}</span></div>
                                <div class="desc">Successful Applications</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_referrals }}">{{ $total_referrals}}</span></div>
                                <div class="desc">Total Referrals</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $due_payment_specialist_applictions}}">{{ $due_payment_specialist_applictions }}</span></div>
                                <div class="desc">Applications with payment due for specialist</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $due_payment_referee_applictions }}">{{ $due_payment_referee_applictions }}</span></div>
                                <div class="desc">Applications with payment due for referee</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $due_payment_from_employer_applictions }}">{{ $due_payment_from_employer_applictions }}</span></div>
                                <div class="desc">Applications with payment due from employers</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $employer_posted_jobs }}">{{ $employer_posted_jobs}}</span></div>
                                <div class="desc">Number of employers who posted jobs</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $unpublish_jobs }}">{{ $unpublish_jobs }}</span></div>
                                <div class="desc">Total unpublished jobs</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $unassign_jobs }}">{{ $unassign_jobs }}</span></div>
                                <div class="desc">Unassigned jobs</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_open_jobs }}">{{ $total_open_jobs }}</span></div>
                                <div class="desc">Total open jobs</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $job_with_no_application }}">{{ $job_with_no_application }}</span></div>
                                <div class="desc">Jobs with no applications</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $successful_hire_jobs }}">{{ $successful_hire_jobs }}</span></div>
                                <div class="desc">Jobs with successful hires</div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
      
@push('scripts')
    <script src="{{asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            $('#date_type').on('change', function(){
               $('#filter').submit(); 
            });
        });

    </script>
@endpush
@endsection

