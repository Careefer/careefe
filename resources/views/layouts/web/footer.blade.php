<footer class="footer">
  <div class="top-footer">
    <div class="container clearfix">
      <div class="footer-col">
        <h5 class="footer-tab">Tools</h5>
        <ul class="footer-list">
          <li>
            <a href="javascript:void(0);"  onclick="redirect_url($(this),'{{url('')}}',true)">Jobs</a>
          </li>
          <li>
            <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.companies.listing')}}',true)">Companies</a>
          </li>
          <li>
            <a href="javascript:void(0);" onclick="redirect_url($(this),'{{route('web.career_advice')}}',true)">Career Advice</a>
          </li>
        </ul>
      </div>
      <div class="footer-col">
        <h5 class="footer-tab">Company</h5>
        <ul class="footer-list">
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{url('about-us')}}',true)">About Us</a>
          </li>
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{url('how-it-works')}}',true)">How It Works</a>
          </li>
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{route('web.blogs')}}',true)">Blog</a>
          </li>
        </ul>
      </div>
      <div class="footer-col">
        <h5 class="footer-tab">Connect</h5>
        <ul class="footer-list">
          <li>
            <a href="#">Contact Us</a>
          </li>
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{route('web.faq')}}',true)">FAQs</a>

          </li>
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{url('work-for-careefer')}}',true)">Work for Careefer</a>
          </li>
        </ul>
      </div>
      <div class="footer-col">
        <h5 class="footer-tab">Specialists</h5>
        <ul class="footer-list">
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{route('specialist.register')}}',true)">Become a Specialist</a>

          </li>
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{route('web.faq')}}',true)">FAQs</a>

          </li>
        </ul>
      </div>
      <div class="footer-col">
        <h5 class="footer-tab">Employers</h5>
        <ul class="footer-list">
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{route('employer.register')}}',null)">Employer Registration</a>

          </li>
          <li>
            <a href="javascript:void(0)" onclick="redirect_url($(this),'{{url('benefits')}}',true)">Benefits</a>
          </li>
          <li>
            <a href="#">Help</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  @include('layouts.web.bottom_footer')
</footer>