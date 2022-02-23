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
                        <span>Update Email Template</span>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspUpdate Email Template
                            </h4>
                        </div>
                    </div>

                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('email_templates.email_template.update', $emailTemplate->id) }}" id="edit_email_template_form" name="edit_email_template_form" accept-charset="UTF-8"  enctype="multipart/form-data">

                            <div class="form-body">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                @include ('email_templates.form', [
                                                        'emailTemplate' => $emailTemplate,
                                                      ])

                            </div>
                            <div class="form-actions noborder">
                                
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_email_template_form"))'>
                                    Update
                                </button>
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('email_templates.email_template.index') }}')">Cancel
                                </button>
                            </div>    
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    @push('css')
        <link href="{{asset('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
    <script src="{{asset('assets/global/plugins/bootstrap-summernote/summernote.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/pages/scripts/components-editors.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/faq.js')}}" type="text/javascript"></script>
      
    <script>
        function generateSlug(str){
            $('#slug').val(slug(str));
        }      
    </script>
    @endpush

@endsection
