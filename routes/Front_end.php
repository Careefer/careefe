<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'web'],function()
{
  Route::get('/', 'Web\WelcomeController@home')->name('welcome.home');

  Route::get('/faq', 'Web\FaqController@index')->name('web.faq');



  Route::get('/get_states/{country_id?}', 'Web\WelcomeController@get_states')->name('state.ajax');

  Route::get('/get_cities/{state_id?}', 'Web\WelcomeController@get_cities')->name('city.ajax');
  Route::get('/get_currency/{country_id?}', 'Web\WelcomeController@getCurrency')->name('currency.ajax');
  Route::post('/currency_rate_conversion', 'Web\WelcomeController@currencyRateConversion')->name('currency_rate_conversion.ajax');


  /* blogs route   */
  Route::get('/blogs','Web\BlogsController@listing')->name('web.blogs');
  Route::get('/blog/detail/{slug}','Web\BlogsController@detail')->name('web.blog.detail');
  Route::get('/all-blogs/{slug?}','Web\BlogsController@all_blogs')->name('web.all_blogs');

  /* end blogs route  */


  /*  career advice route */
  Route::get('/career-advice/{slug?}','Web\CareerAdviceController@listing')->name('web.career_advice');
  Route::get('/all-career-advices/{slug?}','Web\CareerAdviceController@all_career_advices')->name('web.all_career_advices');
  Route::get('/career-advice/detail/{slug}','Web\CareerAdviceController@detail')->name('web.career_advice.detail');
  /*  end career advice route  */


  Route::get('/companies-listing/{sector_slug?}','Web\CompaniesController@listing')->name('web.companies.listing');

  Route::get('/company/detail/{sector_slug}','Web\CompaniesController@detail')->name('web.company.detail');

  // search job form home page
  Route::post('job/save_recent_searched_job','Web\JobController@save_recent_searched_job')->name('web.save_recent_searched_job');

  Route::get('job/search','Web\JobController@searched_job_listing')->name('web.job.search.listing');
  Route::get('jobs','Web\JobController@searchJobs')->name('web.jobs');
  Route::get('job/delete','Web\JobController@clearAllSearchedJobs')->name('web.job.clear.listing');

  Route::get('job/filter_top_company','Web\JobController@ajax_top_company_filter')->name('web.filter_top_company');

  Route::get('job-detail/{slug}','Web\JobController@job_detail')->name('web.job_detail');

  // manage job alerts
  Route::post('job/create_alert','Web\JobAlertController@create')->name('web.create_alert');

  Route::post('job/create_job_alert/{slug}','Web\JobAlertController@create_job_alert')->name('web.create_job_alert');

  Route::get('search_job_keywords','Web\JobController@job_search_keywords')->name('web.job_keyword');
  Route::get('search_job_location','Web\JobController@job_search_locations')->name('web.job_location');

  Route::get('/{page}', 'Web\CmsController@page')->name('web.cms');
});

  Route::post('search_job_keyword_suggestion','Web\JobController@job_search_keyword_suggestion')->name('web.job_keyword_suggestation');
  Route::post('search_jog_location_suggestion','Web\JobController@job_search_location_suggestion')->name('web.job_keyword_suggestation');
  
  Route::post('/location_suggestion','Web\WelcomeController@ajax_location_suggestion');

  







