<!DOCTYPE html>
<html>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white admin-panel">
         <!-- BEGIN HEAD -->
         @include('layouts.header')
         <!-- END HEAD -->
        <div class="page-wrapper">
           <div class="page-header navbar navbar-fixed-top">
              <div class="page-header-inner ">
                 <div class="page-logo">
                    <a href="{{route('admin.dashboard')}}" style="width: 136px;">
                     @php $logo = site_config('site_logo');  @endphp 
                     <img style="width: 100%;" src="{{asset('storage/site_logo/'.$logo)}}" alt="logo" class="logo-default" /> 
                    <!-- <img style="width: 100%;" src="{{asset('assets/images/logo.png')}}" alt="logo" class="logo-default" />  --></a>
                    <div class="menu-toggler sidebar-toggler">
                       <span></span>
                    </div>
                 </div>
                 <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                 <span></span>
                 </a>
                 <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                       <li class="dropdown dropdown-user">
                          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                          <img alt="" class="img-circle" src="{{asset('storage/admin_profile_images/'.Auth::user()->profile_image)}}" />
                          <span class="username username-hide-on-mobile">{{Auth::user()->name}}</span>
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-default">
                             <li>
                                <a href="{{ route('myprofile') }}">
                                <i class="icon-user"></i> My Profile </a>
                             </li>
                             <li>
                                <a href="{{ url('/admin/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="icon-key"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                             </li>
                          </ul>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
            <div class="clearfix"></div>
            <div class="page-container">
                @include('layouts.left_menue')              
                <div class="page-content-wrapper">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </body>
</html>
