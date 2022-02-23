<!DOCTYPE html>
<html lang="en">
  @include('layouts.web.head')
  <body class="@yield('body-class')">
    <div id="wrapper" class="@yield('page-class','home-page')">
      @include('layouts.web.header')
      <div class="website-loader" style="display: none;">
        <img src="{{asset('assets/web/images/loader.gif')}}">
      </div>
      <div class="content @yield('content-class','')">
          @yield('content')
      </div>
      @include('layouts.web.footer')
      @stack('script')
    </div>
  </body>
</html>
