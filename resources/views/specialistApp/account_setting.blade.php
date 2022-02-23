@extends('layouts.web.web')
@section('content')

<div class="dashboard-wrapper">
 <div class="container">
  <h1 class="heading-tab">My Accounts</h1>
  <div class="main-tab-wrapper clearfix">
    @include('layouts.web.left_menue')
    <div class="main-tabs-content">
      
      <div class="dashboard-content shadow setting-wrapper dashboard-current" id="corrent-tab">
        <h2>My Account</h2>
        <ul class="job-tabs-list clearfix">
          <li data-tab="acc-profile" onclick="redirect_url($(this),'{{ url('specialist/profile') }}');" class="account-link">
            Profile
          </li>
          <li data-tab="acc-password" class="account-link account-current">
            Change Password
          </li>
        </ul>
        <div class="" id="settings-tab">
         <h2>Account Settings</h2>
         <h4>Change Password</h4>
         <form class="setting-form spe-setting" method="POST" action="{{ route('specialist.change-password') }}" accept-charset="UTF-8" enctype="multipart/form-data">
           {{ csrf_field() }}
           <div class="setting-inner">
            <div class="form-detail clearfix">
             <div class="form-input">
              <label class="form-label">Existing Password</label>
              <div class="pw-wrap">
               <input type="password" name="existing_password" id="existing_password" placeholder="Enter" value="{{old('existing_password')}}">
             </div>
             @if ($errors->has('existing_password'))
              <span class="err_msg">{{ $errors->first('existing_password') }}.</span>
            @endif
          </div>
        </div>
        <div class="form-detail clearfix">
         <div class="form-input">
          <label class="form-label">New Password</label>
          <div class="pw-wrap">
           <input type="password" name="new_password" id="new_password" placeholder="Enter" value="{{ old('new_password') }}">
         </div>
         @if ($errors->has('new_password'))
         <span class="err_msg">{{ $errors->first('new_password') }}.</span>
        @endif
      </div>
      <div class="form-input">
        <label class="form-label">Confirm Password</label>
        <div class="pw-wrap">
         <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter" value="{{ old('confirm_password') }}">
       </div>
       @if ($errors->has('confirm_password'))
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

@endsection
