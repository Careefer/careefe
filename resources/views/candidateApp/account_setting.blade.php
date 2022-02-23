@extends('layouts.web.web')
@section('content')

<div class="dashboard-wrapper">
   <div class="container">
      <div class="main-tab-wrapper clearfix">
        @include('layouts.web.left_menue')
         <div class="main-tabs-content">
         <h1 class="heading-tab">My Accounts</h1>
            <div class="profile-content shadow setting-wrapper profile-current">
            <div class="" id="settings-tab">
                  <h2>Account Settings</h2>
                  <h4>Change Password</h4>
                  <form class="setting-form spe-setting" method="POST" action="{{ route('candidate.change-password') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                         {{ csrf_field() }}
                        <div class="setting-inner">
                           <div class="form-detail clearfix">
                              <div class="form-input">
                                 <label class="form-label">Existing Password</label>
                                 <div class="pw-wrap">
                                    <input type="password" name="existing_password" id="existing_password" placeholder="Enter" value="" class="exist_pass">
                                 </div>
                                 <div class="pass-visible">
                                     <div class="eye eye-icon exist_eye1">
                                         eye
                                     </div>
                                 </div>
                                 @if($errors->has('existing_password'))
                                     <span class="err_msg">{{ $errors->first('existing_password') }}.</span>
                                 @endif
                              </div>
                           </div>
                           <div class="form-detail clearfix">
                              <div class="form-input">
                                 <label class="form-label">New Password</label>
                                 <div class="pw-wrap">
                                    <input type="password" name="new_password" id="new_password" placeholder="Enter" value="" class="new_pass">
                                 </div>
                                 <div class="pass-visible">
                                     <div class="eye eye-icon new_eye1">
                                         eye
                                     </div>
                                 </div>
                                 @if($errors->has('new_password'))
                                  <span class="err_msg">{{ $errors->first('new_password') }}.</span>
                                 @endif
                              </div>
                              <div class="form-input">
                                 <label class="form-label">Confirm Password</label>
                                 <div class="pw-wrap">
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter" value="" class="conf_pass">
                                 </div>
                                 <div class="pass-visible">
                                     <div class="eye eye-icon conf_eye1">
                                         eye
                                     </div>
                                 </div>
                                 @if($errors->has('confirm_password'))
                                 <span class="err_msg">{{ $errors->first('confirm_password') }}.</span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="update-pw">
                           <button type="submit" class="button-link">
                              Update
                           </button>
                        </div>
                     </form>
                  </div>
                </div>

         </div>
      </div>
   </div>
</div>
<div class="bottom-image">
   Image
</div>

   @push('css')
      <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/fancy_fileupload.css')}}" media="screen">

      <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/selectstyle.css')}}" media="screen">
   @endpush

   @push('js')
      <script src="{{asset('assets/web/js/jquery.ui.widget.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.fileupload.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.iframe-transport.js')}}"></script>
      <script src="{{asset('assets/web/js/jquery.fancy-fileupload.js')}}"></script>
      <script src="{{asset('assets/web/js/selectstyle.js')}}"></script>
      <script src="{{asset('assets/web/js/inview.js')}}"></script>


   @endpush

@endsection


