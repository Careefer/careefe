@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('faqs.faq.index') }}">Faqs</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Faq</span>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspUpdate Faq
                            </h4>
                        </div>
                    </div>

                    <div class="portlet-body form margin-top-25">
                        <form class="faq-form" method="POST" action="{{ route('faqs.faq.update', $faq->id) }}" id="edit_faq_form" name="edit_faq_form" accept-charset="UTF-8" >

                            <div class="form-body">
                                {{ csrf_field() }}
                                @include ('faqs.form', [
                                                        'faq' => $faq,
                                                      ])

                            </div>
                            <div class="form-actions noborder">
                                
                                <button type="button" class="btn blue" id="edit_faq_btn" onclick="edit_faq('edit_faq_btn','edit_faq_form',{{$faq->id}});">
                                    Update
                                </button>

                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('faqs.faq.index') }}')">Cancel
                                </button>
                            </div>    
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    @push('css')
        <link href="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/pages/scripts/components-editors.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/js/faq.js')}}" type="text/javascript"></script>
    @endpush

@endsection
