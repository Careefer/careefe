@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="portlet light bordered">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Settings</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
					<br>
                
                    @if(session('error'))    
                        <div  class="alert alert-danger ">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <i class="fa-lg fa fa-close"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div class="portlet-body form">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold" id="settings">Site Configuration</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab" class="site-configuration">Site Configuration</a>
                                </li>
                                
                                <li>
                                    <a href="#tab_1_3" data-toggle="tab" class="social-media">Social Media Settings</a>
                                </li>
                                <li>
                                    <a href="#tab_1_4" data-toggle="tab" class="copyright-text">Copyright Footer Text</a>
                                </li>
                                <li>
                                    <a href="#tab_1_5" data-toggle="tab" class="site-logo">Site Logo</a>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- Site Configuration TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <form method="POST" action="{{ route('site_setting.setting.store') }}" accept-charset="UTF-8"   enctype="multipart/form-data" id="site-configuration-form">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label class="control-label">Site Name</label>
                                            @if( $errors->has('site_title'))
                                                <span class="err-msg">
                                                  {!! $errors->first('site_title', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" placeholder="Site Name" name="site_title" id="site_title" class="form-control" value="{{$data['site_title']}}"> 
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Site Email</label>
                                            @if( $errors->has('site_email'))
                                                <span class="err-msg">
                                                  {!! $errors->first('site_email', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" placeholder="Site Email" name="site_email" id="site_email" class="form-control" value="{{$data['site_email']}}"> 
                                        </div>
                                        
                                        <div class="margiv-top-10">
                                            <button type="submit" class="btn blue" id="site-configuration-submit">
                                                Save
                                            </button>
                                             <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('site_setting.setting.index') }}')">Cancel
                                             </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END Site Configuration  TAB -->


                                <!-- Social Media TAB -->
                                <div class="tab-pane" id="tab_1_3">
                                    <form method="POST" action="{{ route('site_setting.setting.store') }}" accept-charset="UTF-8"  enctype="multipart/form-data" id="social-media-form">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="control-label">Facebook Url</label>
                                            @if( $errors->has('fb_url'))
                                                <span class="err-msg">
                                                  {!! $errors->first('fb_url', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="fb_url" class="form-control" value="{{$data['fb_url']}}"></div>
                                        <div class="form-group">
                                            <label class="control-label">Twitter url</label>
                                            @if( $errors->has('twitter_url'))
                                                <span class="err-msg">
                                                  {!! $errors->first('twitter_url', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="twitter_url" class="form-control" value="{{$data['twitter_url']}}"> </div>
                                        <div class="form-group">
                                            <label class="control-label">LinkedIn url</label>
                                            @if( $errors->has('linkedin_url'))
                                                <span class="err-msg">
                                                  {!! $errors->first('linkedin_url', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="linkedin_url" class="form-control" value="{{$data['linkedin_url']}}"> </div>

                                        <div class="form-group">
                                            <label class="control-label">Google +</label>
                                            @if( $errors->has('google_plus'))
                                                <span class="err-msg">
                                                  {!! $errors->first('google_plus', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="google_plus" class="form-control" value="{{$data['google_plus']}}"> </div>  

                                        <div class="form-group">
                                            <label class="control-label">Instagram Url</label>
                                            @if( $errors->has('instagram_url'))
                                                <span class="err-msg">
                                                  {!! $errors->first('instagram_url', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="instagram_url" class="form-control" value="{{$data['instagram_url']}}"> </div>   

                                         <div class="form-group">
                                            <label class="control-label">Youtube Url</label>
                                            @if( $errors->has('youtube_url'))
                                                <span class="err-msg">
                                                  {!! $errors->first('youtube_url', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="youtube_url" class="form-control" value="{{$data['youtube_url']}}"> </div>   
                                            

                                         <div class="form-group">
                                            <label class="control-label">Pinterest Url</label>
                                            @if( $errors->has('pinterest_url'))
                                                <span class="err-msg">
                                                  {!! $errors->first('pinterest_url', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="pinterest_url" class="form-control" value="{{$data['pinterest_url']}}"> </div>               
                                        
                                        <div class="margin-top-10">
                                            <button type="submit" class="btn blue" id="social-media-submit">
                                                Save
                                            </button>
                                             <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('site_setting.setting.index') }}')">Cancel
                                             </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END Social Media TAB -->


                                 <!-- Copyright Text  TAB -->
                                <div class="tab-pane" id="tab_1_4">
                                    <form method="POST" action="{{ route('site_setting.setting.store') }}" accept-charset="UTF-8"  enctype="multipart/form-data" id="copyright-text-form">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="control-label">Content</label>
                                            @if( $errors->has('copyright_content'))
                                                <span class="err-msg">
                                                  {!! $errors->first('copyright_content', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                            <input type="text" name="copyright_content" value="{{$data['copyright_content']}}" class="form-control"> </div>
                                        
                                        <div class="margin-top-10">
                                           <button type="submit" class="btn blue" id="copyright-text-submit">
                                                Save
                                            </button>
                                             <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('site_setting.setting.index') }}')">Cancel
                                             </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END Copyright Text TAB -->

                                <!-- CHANGE Site logo TAB -->

                                <div class="tab-pane" id="tab_1_5">
                                    <form method="POST" action="{{ route('site_setting.setting.updateSiteLogo') }}" accept-charset="UTF-8"  enctype="multipart/form-data" id="site-logo-form">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="{{asset('storage/site_logo/'.$data['site_logo'])}}" alt=""> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Upload </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" name="site_logo"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                                
                                            </div>
                                            @if( $errors->has('site_logo'))
                                                <span class="err-msg">
                                                  {!! $errors->first('site_logo', '<p class="help-block">:message</p>') !!}
                                                </span>
                                            @endif
                                           <div class="clearfix margin-top-10">
                                               <span class="label label-danger">NOTE! </span>
                                               <span>Site logo must be 221x47 px.</span>
                                           </div>
                                        </div>
                                        <div class="margin-top-10">
                                           <button type="submit" class="btn blue" id="site-logo-submit">
                                                Save
                                            </button>
                                            <button type="button" class="btn red" onclick="redirect_url($(this),'{{ route('site_setting.setting.index') }}')">Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END Site logo  TAB -->
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure you want to Submit?</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" id="continuebtn">Continue</button>
                <button class="btn btn-danger" data-dismiss="modal">cancel</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    @push('css')
        <link href="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
    <script type="text/javascript">
         $(document).on("click", ".site-configuration, .social-media, .copyright-text, .site-logo", function (e) {
             var text = $(this).text();
             $("#settings").text(text);
        });
    </script>
    <script type="text/javascript">
        $(document).on("click", "#site-configuration-submit, #social-media-submit, #copyright-text-submit, #site-logo-submit", function (e) {
            e.preventDefault();
            $('#myModal').modal('toggle');
            if ($(this).attr("id") == "site-configuration-submit") 
            {
              $(document).on("click", "#continuebtn", function (e) {
                   $('#site-configuration-form').submit();
               });   
            }
            if ($(this).attr("id") == "social-media-submit") 
            {
              $(document).on("click", "#continuebtn", function (e) {
                   $('#social-media-form').submit();
               });   
            }
            if ($(this).attr("id") == "copyright-text-submit") 
            {
              $(document).on("click", "#continuebtn", function (e) {
                   $('#copyright-text-form').submit();
               });   
            }
            if ($(this).attr("id") == "site-logo-submit") 
            {
              $(document).on("click", "#continuebtn", function (e) {
                   $('#site-logo-form').submit();
               });   
            }
        });
       
       
    </script>
    <script src="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    @endpush

@endsection
