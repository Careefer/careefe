@extends('layouts.web.web')
@section('title','CMS')
@section('content')

    <div class="faq-wrapper">
        <div class="container">
            <h1></h1>
            <ul class="faq-accordion-wrapper">
                <li>
                     <div class="emp-inner">
                          <h1>{{$pages->title}}</h1>
                          <div class="signup-tabs-wrapper">
                              <div id="employer" class="tab-signup">
                                 <p>@php echo html_entity_decode($pages->content); @endphp</p> 
                              </div>
                          </div> 
                      </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bottom-image">
        Image
    </div>

@endsection