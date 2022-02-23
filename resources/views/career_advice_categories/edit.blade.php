@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blog_categories.blog_category.index') }}">Career Advice Categories</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Update Career Advice Category</span>
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-12">
                    
                    </br>

                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-edit"></i>&nbspUpdate Career Advice Category
                            </h4>
                        </div>
                    </div>

                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('career_advice_categories.career_advices.update', $adviceCategory->id) }}" id="edit_blog_category_form" name="edit_blog_category_form" accept-charset="UTF-8" >

                            <div class="form-body">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                @include ('career_advice_categories.form', [
                                                        'adviceCategory' => $adviceCategory,
                                                      ])

                            </div>
                            <div class="form-actions noborder">
                                
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#edit_blog_category_form"))'>
                                    Update
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
