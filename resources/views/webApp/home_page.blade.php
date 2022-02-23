@extends('layouts.web.web')
@section('content')

    <div class="video-wrapper">
      <video class="banner-video" autoplay muted playsinline loop>
        <source src="{{asset('assets/web/images/dummy.mp4')}}" type="video/mp4">
      </video>
    </div>
    <div class="home-banner">
      <div class="container">
        <div class="banner-text">
          <h1>Find Your Dream Job Today!</h1>
          <div class="search-form-wrapper clearfix">
            <form class="search-form custom-sel-drop">
              <div class="input-search-wrapper clearfix">
                <div class="search-input keyword-wrapper"><img src="{{asset('assets/web/images/search-icon.png')}}" alt="search">
                  <input type='text'
                  placeholder='Keywords'
                  class='flexdatalist'
                  data-data='countries.json'
                  data-search-in='name'
                  data-visible-properties='["name","capital","continent"]'
                  data-selection-required='false'
                  data-value-property='*'
                  data-min-length='3'
                  data-limit-of-values='1'
                  name='country_limit_values'>
                </div>
                <div class="search-input func-area-wrapper"><img src="{{asset('assets/web/images/functional-area.png')}}" alt="functional-area">
                  <input required type='text'
                  placeholder='Functional Area'
                  class='flexdatalist'
                  data-data='countries.json'
                  data-search-in='name'
                  data-visible-properties='["name","capital","continent"]'
                  data-selection-required='false'
                  data-value-property='*'
                  data-min-length='3'
                  data-limit-of-values='1'
                  name='country_limit_values'>
                </div>
                <div class="search-input country-wrapper"><img src="{{asset('assets/web/images/location-img.png')}}" alt="location">
                  <input required type='text'
                  placeholder='City, State or Country'
                  class='flexdatalist'
                  data-data='countries.json'
                  data-search-in='name'
                  data-visible-properties='["name","capital","continent"]'
                  data-selection-required='false'
                  data-value-property='*'
                  data-min-length='3'
                  data-limit-of-values='1'
                  name='country_limit_values'>
                </div>
              </div>
              <div class="btn-center">
                <button type="button" class="button search-btn search-form-btn">
                  Search
                </button>
              </div>
            </form>
            <div class="searched">
              <h3>Recently Searched</h3>
              <button class="clear button" type="button">
                Clear
              </button>
              <ul class="searched-list">
                <li>
                  <a href="#" class="clearfix" title="Product Manager, Mum..">Product Manager, Mum..<span class="search-no">1001</span></a>
                </li>
                <li>
                  <a href="#" class="clearfix" title="Product Manager, Mum..">Product Manager, Mum..<span class="search-no">1001</span></a>
                </li>
                <li>
                  <a href="#" class="clearfix" title="Product Manager, Mum..">Product Manager, Mum..<span class="search-no">1001</span></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="jobs-wrapper">
      <div class="container">
        <div class="job-inner-wrapper">
          <div class="top-wrapper clearfix">
            <h2>Find your dream job today!</h2>
            <ul>
              <li>
                <a href="#">Recent Jobs </a>
              </li>
              <li>
                <a href="#">Popular jobs</a>
              </li>
            </ul>
          </div>
          <table class="job-table">
            <tr>
              <th></th>
              <th class="regular">Position</th>
              <th>City</th>
              <th class="regular">Work Type</th>
              <th>Salary</th>
              <th>Referral Bonus</th>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/tesco.png')}}" alt="tesco"></a></td>
              <td class="position"><a href="#">Digital Analyst</a><span>Commonwealth Bank</span></td>
              <td class="city">Sydney</td>
              <td class="type">Full-time</td>
              <td class="salary">$3110 - $3250</td>
              <td class="bonus"><span>$650</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/google.png')}}" alt="google"></a></td>
              <td class="position"><a href="#">Marketing Manager</a><span>Google Technology company</span></td>
              <td class="city">Melbourne</td>
              <td class="type">Half-time</td>
              <td class="salary">$440 - $500</td>
              <td class="bonus"><span>$400</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/sony.png')}}" alt="sony"></a></td>
              <td class="position"><a href="#">Senior Analyst</a><span>Technology company</span></td>
              <td class="city">Sydney</td>
              <td class="type">Full-time</td>
              <td class="salary">$4230 - $5300</td>
              <td class="bonus"><span>$750</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/intel.png')}}" alt="intel"></a></td>
              <td class="position"><a href="#">Performance Analyst</a><span>Technology company</span></td>
              <td class="city">Sydney</td>
              <td class="type">Contract</td>
              <td class="salary">$310 - $350</td>
              <td class="bonus"><span>$620</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/tech.png')}}" alt="tech-mahindra"></a></td>
              <td class="position"><a href="#">Digital Analyst</a><span>Technology company</span></td>
              <td class="city">Sydney</td>
              <td class="type">Entry Level</td>
              <td class="salary">$400 - $450</td>
              <td class="bonus"><span>$650</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/amazon.png')}}" alt="amazon"></a></td>
              <td class="position"><a href="#">Analytics Lead</a><span>Technology company</span></td>
              <td class="city">Melbourne</td>
              <td class="type">Full-time</td>
              <td class="salary">$310 - $350</td>
              <td class="bonus"><span>$650</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/ebay.png')}}" alt="ebay"></a></td>
              <td class="position"><a href="#">Digital Analyst</a><span>Commonwealth Bank</span></td>
              <td class="city">Sydney</td>
              <td class="type">Full-time</td>
              <td class="salary">$440 - $500</td>
              <td class="bonus"><span>$650</span></td>
            </tr>
            <tr>
              <td class="company-logo"><a href="#"><img src="{{asset('assets/web/images/samsung.png')}}" alt="samsung"></a></td>
              <td class="position"><a href="#">Digital Analyst</a><span>Technology company</span></td>
              <td class="city">Sydney</td>
              <td class="type">Full-time</td>
              <td class="salary">$250 - $300</td>
              <td class="bonus"><span>$650</span></td>
            </tr>
          </table>
          <div class="view-job-wrapper">
            <a href="#" class="view-jobs">View more jobs</a>
          </div>
        </div>
      </div>
    </div>
    <div class="easiest-way">
      <div class="container clearfix">
        <div class="way-text">
          <h2>Easiest Way To Used</h2>
          <p>
            This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.
          </p>
        </div>
        <div class="way-img"><img src="{{asset('assets/web/images/easiest-way.png')}}" alt="img">
        </div>
      </div>
    </div>
    <div class="featured">
      <div class="container">
        <h2>Featured Employer</h2>
        <p>
          This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,
        </p>
        <div class="breaking-news-ticker" id="newsticker">
          <div class="bn-news">
            <ul class="company-list clearfix">
              <li class="expedia">
                <div class="ticker-wrapper">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/expedia-logo.png')}}" alt="expedia">
                  </div> <strong>Expedia Group</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="trivago">
                <div class="ticker-wrapper even">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/trivago-logo.png')}}" alt="trivago">
                  </div> <strong>Trivago</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="hello">
                <div class="ticker-wrapper">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/hello.jpg')}}" alt="hellofresh">
                  </div> <strong>Hello Fresh</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="amazon">
                <div class="ticker-wrapper even">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/amazon-logo.jpg')}}" alt="amazon">
                  </div> <strong>Amazon.com</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="expedia">
                <div class="ticker-wrapper">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/expedia-logo.jpg')}}" alt="expedia">
                  </div> <strong>Expedia Group</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="trivago">
                <div class="ticker-wrapper even">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/trivago-logo.png')}}" alt="trivago">
                  </div> <strong>Trivago</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="hello">
                <div class="ticker-wrapper">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/hello.jpg')}}" alt="hellofresh">
                  </div> <strong>Hello Fresh</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
              <li class="amazon">
                <div class="ticker-wrapper  even">
                  <a href="#">
                  <div class="card"><img src="{{asset('assets/web/images/amazon-logo.jpg')}}" alt="amazon">
                  </div> <strong>Amazon.com</strong> <span>1104 Jobs</span> </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="our-blog">
      <div class="container">
        <h2>Blog</h2>
        <p>
          This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,
        </p>
        <div class="blog-slider">
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img1.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img2.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img3.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img4.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img1.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img2.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img3.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img4.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img4.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img4.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img4.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
          <div class="box">
            <a href="#" class="box-link">
            <div class="slider-img"><img src="{{asset('assets/web/images/blog-img4.png')}}" alt="img">
            </div>
            <div class="blog-text">
              <span class="blog-date"><img src="{{asset('assets/web/images/date-icon.png')}}" alt="date">19 November 2018</span>
              <h3>Photoshop's version of Lorem Ipsum. </h3>
              <span class="read-story">Read Story</span>
            </div> </a>
          </div>
        </div>
        <a href="#" class="view-all">View All</a>
      </div>
    </div>
    <div class="bottom-image">
      Image
    </div>

@endsection
