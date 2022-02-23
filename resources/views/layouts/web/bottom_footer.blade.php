<div class="bottom-footer">
    <div class="container">
      <div class="footer-logo-wrapper">
        <a href="{{url('')}}" class="footer-logo"><img src="{{asset('assets/web/images/footer-logo.png')}}" alt="careefer"></a>
      </div>
      <p class="footer-text">
        <!-- This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh velit auctor.
        <span>Aenean sollicitudin, lorem quis bibendum auctor,</span> -->
      </p>
      <ul class="footer-social-links">
        <li>
          <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
        </li>
        <li>
          <a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
        </li>
        <li>
          <a href="https://linkedin.com/"><i class="fa fa-linkedin"></i></a>
        </li>
        <li>
          <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
        </li>
        <li>
          <a href="https://www.youtube.com/"><img src="{{asset('assets/web/images/youtube-icon.png')}}" alt="youtube"></a>
        </li>
        <li>
          <a href="https://www.pinterest.com/"><i class="fa fa-pinterest-p"></i></a>
        </li>
      </ul>
      <ul class="terms">
        @php $pages = cmsPages(); @endphp
        @foreach($pages as $value)
        <li>
          <a href="{{url($value->slug)}}">{{$value->title}}</a>
        </li>
        @endforeach
      </ul>
      <span class="copyright">
        @php $copyrightContent = site_config('copyright_content'); @endphp
        © {{date('Y')}} {{$copyrightContent}}
      </span>
    </div>
  </div>