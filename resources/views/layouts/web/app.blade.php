<!DOCTYPE html>
<html lang="en">
  @include('layouts.web.head')
  <body class="@yield('body-class')">
    <div id="wrapper" class="@yield('page-class')">
      <header class="header header-center">
        <div class="container">
          <a href="{{url('')}}" class="logo">
            @php $logo = site_config('site_logo');  @endphp 
             <img src="{{asset('storage/site_logo/'.$logo)}}" alt="careefer">
            <!-- <img src="{{asset('assets/web/images/logo.png')}}" alt="careefer"> -->
          </a>
        </div>
      </header>
      <div class="content @yield('content-class')">
          @yield('content')
      </div>
       <footer class="footer">
        <div class="container">
          @include('layouts.web.bottom_footer')
        </div>
      </footer> 
    </div>
  </body>
</html>