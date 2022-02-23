@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('specialists.specialist.index') }}">Specialists</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>View Specialist</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                    <div class="caption">
                        <h4 class="caption-subject bold uppercase">
                            <i class="fa fa-edit"></i>&nbspUpdate Specialist
                        </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <th>Specialists id</th>
                                <td>{{$specialist->specialist_id}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{$specialist->name}}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>
                                    @if(isset($specialist->current_location->world_location->location))
                                    {{$specialist->current_location->world_location->location}}
                                    @else
                                    --
                                    @endif                                 
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$specialist->email}}</td>
                            </tr>
                            <tr>
                                <th>Functional Area</th>
                                <td>
                                    @php
                                        if($specialist->functional_area())
                                        {   
                                            $arr = $specialist->functional_area();
                                            echo  $arr?implode(', ', $arr):'--';
                                        }
                                        else
                                        {
                                            echo '--';
                                        }
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <th>Resume</th>
                                <td>
                                    @php
                                      $cv_path = storage_path('app/public/specialist/resume/'.$specialist->resume);
                                      $encrypt = base64_encode($cv_path);
                                    @endphp

                                    @if($specialist->resume && file_exists($cv_path))
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