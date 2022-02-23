@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blog_categories.blog_category.index') }}">Blog Categories</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create New Blog Category</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspCreate New Blog Category
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                        <form method="POST" action="{{ route('blog_categories.blog_category.store') }}" accept-charset="UTF-8" id="create_blog_category_form" name="create_blog_category_form" >
                            <div class="form-body">
                                {{ csrf_field() }}
                                @include ('blog_categories.form', [
                                                        'blogCategory' => null,
                                                      ])
                                
                            </div>                                                  
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" onclick='submit_form($(this),$("#create_blog_category_form"))'>
                                    Add
                                </button>
                                
                                <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('blog_categories.blog_category.index') }}')">Cancel
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


