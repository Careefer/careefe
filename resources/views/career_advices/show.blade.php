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
                        <span>Show Career Advice</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    </br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-plus"></i>&nbspShow Career Advice
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body form margin-top-25">
                      
                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Title:</strong>
                            </label>
                           <p>{{$careerAdvice->title}}</p>
                        </div>

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Category:</strong>
                            </label>
                            <p>{{$careerAdvice->category->title}}</p>
                        </div>

                        <div class="form-group form-md-line-input has-info"> 
                            <label for="category_id">
                                <strong>Type:</strong>
                            </label>
                            <p>
                                @if($careerAdvice->type == "image")
                                    <img src="{{asset('storage/career_advice_images/thumbnail_image/'.$careerAdvice->image)}}" alt="" height="80" width="80" class="rounded-circle">
                                
                                @else
                                   <video width="150" height="150" controls>
                                     <source src="{{asset('storage/career_advice_images/'.$careerAdvice->image)}}">
                                   </video>
                                
                                @endif
                            </p>
                        </div>   

                        <div class="form-group form-md-line-input has-info">
                            <label for="category_id">
                                <strong>Content:</strong>
                            </label>
                           <p>@php echo html_entity_decode($careerAdvice->content); @endphp</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


