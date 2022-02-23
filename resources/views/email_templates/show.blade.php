@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('email_templates.email_template.index') }}">Email Templates</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Show Email Template</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspShow Email Template
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                      
                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Title:</strong>
                            </label>
                           <p>{{$emailTemplate->title}}</p>
                        </div>
 

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Content:</strong>
                            </label>
                           <p>@php echo html_entity_decode($emailTemplate->content); @endphp</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


