@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blog_categories.blog_category.index') }}">Career Advice Category</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Career Advice Category</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspCreate New  Career Advice Category
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('career_advice_categories.career_advices.store') }}" accept-charset="UTF-8" id="create_career_advice_category_form" name="create_career_advice_category_form" >
                            <div class="form-body">
                                {{ csrf_field() }}
                                @include ('career_advice_categories.form', [
                                                        'adviceCategory' => null,
                                                      ])
                                
                            </div>                                                  
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_career_advice_category_form"))'>
                                    Add
                                </button>
                                
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('career_advice_categories.career_advices.index') }}')">Cancel
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function generateSlug(str){
                $('#slug').val(slug(str));
            }      
        </script>
    @endpush
@endsection


