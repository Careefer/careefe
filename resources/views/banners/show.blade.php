@extends('layouts.app')

@section('content')

    <div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('blogs.blog.index') }}">Banner</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Show Banner</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspShow Banner
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                      
                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Title:</strong>
                            </label>
                           <p>{{$banner->title}}</p>
                        </div>

                        {{--<div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Link:</strong>
                            </label>
                           <p>{{$banner->link}}</p>
                        </div>--}}

                        <div class="form-group form-md-line-input has-info"> 
                            <label for="category_id">
                                <strong>Type:</strong>
                            </label>
                            <p><p>{{$banner->type}}</p>
                                @if($banner->type == "image")
                                
                                    <img src="{{asset('storage/banner_images/'.$banner->image)}}" alt="" height="80" width="80" class="rounded-circle">
                                
                                @else
                                
                                   <video width="150" height="150" controls>
                                     <source src="{{asset('storage/banner_images/'.$banner->image)}}">
                                   </video>
                                
                                @endif
                            </p>
                        </div>   

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Content:</strong>
                            </label>
                           <p>@php echo html_entity_decode($banner->content); @endphp</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


