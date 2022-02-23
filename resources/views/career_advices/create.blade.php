@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blogs.blog.index') }}">Career Advice</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Career Advice</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspCreate New Career Advice
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('career_advices.career_advice.store') }}" accept-charset="UTF-8" id="create_career_advice_form" name="create_career_advice_form"  enctype="multipart/form-data">
                            <div class="form-body">
                                {{ csrf_field() }}
                                @include ('career_advices.form', [
                                                        'careerAdvice' => null,
                                                      ])
                                
                            </div>                                                  
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_career_advice_form"))'>
                                    Add
                                </button>
                                
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('career_advices.career_advice.index') }}')">Cancel
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



