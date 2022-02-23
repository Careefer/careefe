@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blogs.blog.index') }}">Cms</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Show Cms</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspShow Cms
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                      
                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Page Name:</strong>
                            </label>
                           <p>{{$cms->title}}</p>
                        </div>

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Slug Url:</strong>
                            </label>
                            <p>{{$cms->slug}}</p>
                        </div>   

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Content:</strong>
                            </label>
                           <p>@php echo html_entity_decode($cms->content); @endphp</p>
                        </div>
                       

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Meta Title:</strong>
                            </label>
                            <p>{{$cms->meta_title}}</p>
                        </div>

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Meta Keyword:</strong>
                            </label>
                            <p>{{$cms->meta_keyword}}</p>
                        </div>

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Meta Description:</strong>
                            </label>
                            <p>{{$cms->meta_desc}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


