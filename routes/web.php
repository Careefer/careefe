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


Route::get('run-queue', function () {
    /* php artisan migrate */
    \Artisan::call('queue:work --sleep=3 --tries=3');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/my-ip', function() {
    return \Request::ip();
});


Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function()
{
  
  // Dashbaord
  Route::get('/dashboard','AdminApp\DashboardController@dashboard')->name('admin.dashboard');

  // Roles 
  Route::get('/add_role','AdminApp\RoleController@add_role')->name('admin.role.add')->middleware('permission:manage-role-add');
  Route::post('/add_role','AdminApp\RoleController@add_role')->name('admin.role.add.post')->middleware('permission:manage-role-add');

  Route::get('role/listing','AdminApp\RoleController@role_listing')->name('role.list')->middleware('permission:manage-role-view');
  
  Route::get('role/listing/ajax','AdminApp\RoleController@role_list_ajax')->name('role.list.ajax')->middleware('permission:manage-role-view');

  Route::get('role/edit/{role_id}','AdminApp\RoleController@edit_role')->name('role.edit')->middleware('permission:manage-role-edit');
  Route::post('role/edit/{role_id}','AdminApp\RoleController@edit_role')->name('role.edit.post')->middleware('permission:manage-role-edit');
  
  Route::get('role/delete/{role_id}','AdminApp\RoleController@delete')->name('role.delete')->middleware('permission:manage-role-del');
  Route::get('dashboard/change_status','AdminApp\DashboardController@change_status')->name('dashboard.change.status')->middleware('permission:manage-role-del');
  
  // Users
  Route::get('user/add','AdminApp\UserController@add')->name('user.add')->middleware('permission:manage-administrator-add');
  Route::post('user/add','AdminApp\UserController@add')->name('user.add.post')->middleware('permission:manage-administrator-add');

  Route::get('user/edit/{user_id}','AdminApp\UserController@edit')->name('user.edit')->middleware('permission:manage-administrator-edit');
  Route::post('user/edit/{user_id}','AdminApp\UserController@edit')->name('user.edit.post')->middleware('permission:manage-administrator-edit');
  
  Route::get('user/listing','AdminApp\UserController@listing')->name('user.list')->middleware('permission:manage-administrator-view');
  Route::get('user/listing/ajax','AdminApp\UserController@user_listing_ajax')->name('user.list.ajax')->middleware('permission:manage-administrator-view');
  Route::get('user/delete/{user_id}','AdminApp\UserController@delete')->name('user.delete')->middleware('permission:manage-administrator-del');

  Route::get('user/myprofile/','AdminApp\UserController@my_profile')->name('myprofile');

  Route::post('user/myprofile/','AdminApp\UserController@change_profile_image')->name('myprofile.image.post');
  Route::post('user/info','AdminApp\UserController@update_my_info')->name('user.info.post');
  Route::post('user/change_password','AdminApp\UserController@change_password')->name('user.change.password.post');

  
});

Route::group(['prefix' => 'admin'], function ()
{
  Route::get('/','AdminAuth\LoginController@showLoginForm');

  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});


Route::group([
    'prefix' => 'admin/blog_categories', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\BlogCategoriesController@index')
         ->name('blog_categories.blog_category.index')->middleware('permission:category-view');
         
    Route::get('/create','AdminApp\BlogCategoriesController@create')
         ->name('blog_categories.blog_category.create')->middleware('permission:category-add');
         
    Route::get('/show/{blogCategory}','AdminApp\BlogCategoriesController@show')
         ->name('blog_categories.blog_category.show')->where('id', '[0-9]+')->middleware('permission:category-view');
         
    Route::get('/{blogCategory}/edit','AdminApp\BlogCategoriesController@edit')
         ->name('blog_categories.blog_category.edit')->where('id', '[0-9]+')->middleware('permission:category-edit');
         
    Route::post('/', 'AdminApp\BlogCategoriesController@store')
         ->name('blog_categories.blog_category.store')->middleware('permission:category-add');
         
    Route::put('blog_category/{blogCategory}', 'AdminApp\BlogCategoriesController@update')
         ->name('blog_categories.blog_category.update')->where('id', '[0-9]+')->middleware('permission:category-edit');
         
    Route::get('/{blogCategory}/delete','AdminApp\BlogCategoriesController@destroy')
         ->name('blog_categories.blog_category.destroy')->where('id', '[0-9]+')->middleware('permission:category-del');

});


/**  route for career advice categories  **/
Route::group([
    'prefix' => 'admin/career_advice_categories', 'middleware'=>['auth:admin']
], function () {
     
    Route::get('/', 'AdminApp\CareerAdviceCategoriesController@index')
         ->name('career_advice_categories.career_advices.index')->middleware('permission:career-advice-category-view');
         
    Route::get('/create','AdminApp\CareerAdviceCategoriesController@create')
         ->name('career_advice_categories.career_advices.create')->middleware('permission:career-advice-category-add');;
         
    Route::get('/show/{careerAdviceCategory}','AdminApp\CareerAdviceCategoriesController@show')
         ->name('career_advice_categories.career_advices.show')->middleware('permission:career-advice-category-view');
         
    Route::get('/{careerAdviceCategory}/edit','AdminApp\CareerAdviceCategoriesController@edit')
         ->name('career_advice_categories.career_advices.edit')->middleware('permission:career-advice-category-edit');
         
    Route::post('/', 'AdminApp\CareerAdviceCategoriesController@store')
         ->name('career_advice_categories.career_advices.store')->middleware('permission:career-advice-category-add');
         
    Route::put('career_advices/{careerAdviceCategory}', 'AdminApp\CareerAdviceCategoriesController@update')
         ->name('career_advice_categories.career_advices.update')->middleware('permission:blogs-edit');
         
    Route::get('/{careerAdviceCategory}/delete','AdminApp\CareerAdviceCategoriesController@destroy')
         ->name('career_advice_categories.career_advices.destroy')->middleware('permission:career-advice-category-del');
});
/**  end route for career advice categories  **/


/**  route for career advices **/
Route::group([
    'prefix' => 'admin/career_advices', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CareerAdviceController@index')
         ->name('career_advices.career_advice.index')->middleware('permission:career-advices-view');
         
    Route::get('/create','AdminApp\CareerAdviceController@create')
         ->name('career_advices.career_advice.create')->middleware('permission:career-advices-add');;
         
    Route::get('/show/{career_advice}','AdminApp\CareerAdviceController@show')
         ->name('career_advices.career_advice.show')->middleware('permission:career-advices-view');
         
    Route::get('/{career_advice}/edit','AdminApp\CareerAdviceController@edit')
         ->name('career_advices.career_advice.edit')->middleware('permission:career-advices-edit');
         
    Route::post('/', 'AdminApp\CareerAdviceController@store')
         ->name('career_advices.career_advice.store')->middleware('permission:career-advices-add');
         
    Route::put('career_advice/{career_advice}', 'AdminApp\CareerAdviceController@update')
         ->name('career_advices.career_advice.update')->middleware('permission:career-advices-edit');
         
    Route::get('/{career_advice}/delete','AdminApp\CareerAdviceController@destroy')
         ->name('career_advices.career_advice.destroy')->middleware('permission:career-advices-del');

});
/**  end route for career advices **/


/**  route for manage banners **/
Route::group([
    'prefix' => 'admin/manage_banners', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\BannerController@index')
         ->name('manage_banners.manage_banner.index')->middleware('permission:manage-banners-view');
         
    Route::get('/create','AdminApp\BannerController@create')
         ->name('manage_banners.manage_banner.create')->middleware('permission:manage-banners-add');;
         
    Route::get('/show/{manage_banner}','AdminApp\BannerController@show')
         ->name('manage_banners.manage_banner.show')->middleware('permission:manage-banners-view');
         
    Route::get('/{manage_banner}/edit','AdminApp\BannerController@edit')
         ->name('manage_banners.manage_banner.edit')->middleware('permission:manage-banners-edit');
         
    Route::post('/', 'AdminApp\BannerController@store')
         ->name('manage_banners.manage_banner.store')->middleware('permission:manage-banners-add');
         
    Route::put('manage_banner/{manage_banner}', 'AdminApp\BannerController@update')
         ->name('manage_banners.manage_banner.update')->middleware('permission:manage-banners-edit');
         
    Route::get('/{manage_banner}/delete','AdminApp\BannerController@destroy')
         ->name('manage_banners.manage_banner.destroy')->middleware('permission:manage-banners-del');

});
/**  end route for manage banners **/


/**  route for cms pages **/
Route::group([
    'prefix' => 'admin/manage_cms_pages', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CmsController@index')
         ->name('manage_cms_pages.manage_cms_page.index')->middleware('permission:manage-cms-pages-view');
         
    Route::get('/create','AdminApp\CmsController@create')
         ->name('manage_cms_pages.manage_cms_page.create')->middleware('permission:manage-cms-pages-add');;
         
    Route::get('/show/{manage_cms_page}','AdminApp\CmsController@show')
         ->name('manage_cms_pages.manage_cms_page.show')->middleware('permission:manage-cms-pages-view');
         
    Route::get('/{manage_cms_page}/edit','AdminApp\CmsController@edit')
         ->name('manage_cms_pages.manage_cms_page.edit')->middleware('permission:manage-cms-pages-edit');
         
    Route::post('/', 'AdminApp\CmsController@store')
         ->name('manage_cms_pages.manage_cms_page.store')->middleware('permission:manage-cms-pages-add');
         
    Route::put('manage_cms_page/{manage_cms_page}', 'AdminApp\CmsController@update')
         ->name('manage_cms_pages.manage_cms_page.update')->middleware('permission:manage-cms-pages-edit');
         
    Route::get('/{manage_cms_page}/delete','AdminApp\CmsController@destroy')
         ->name('manage_cms_pages.manage_cms_page.destroy')->middleware('permission:manage-cms-pages-del');

});
/**  end route for cms pages **/


/**  route for settings **/
Route::group([
    'prefix' => 'admin/site_setting', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\SettingController@index')
         ->name('site_setting.setting.index')->middleware('permission:site-setting-view');
         
    Route::get('/create','AdminApp\SettingController@create')
         ->name('site_setting.setting.create')->middleware('permission:site-setting-add');
         
    Route::get('/show/{setting}','AdminApp\SettingController@show')
         ->name('site_setting.setting.show')->middleware('permission:site-setting-view');
         
    Route::get('/{setting}/edit','AdminApp\SettingController@edit')
         ->name('site_setting.setting.edit')->middleware('permission:site-setting-edit');
         
    Route::post('/', 'AdminApp\SettingController@store')
         ->name('site_setting.setting.store')->middleware('permission:site-setting-add');

    Route::post('updateSiteLogo', 'AdminApp\SettingController@updateSiteLogo')
         ->name('site_setting.setting.updateSiteLogo')->middleware('permission:site-setting-add');     

         
    Route::put('setting/{setting}', 'AdminApp\SettingController@update')
         ->name('site_setting.setting.update')->middleware('permission:site-setting-edit');
         
    Route::get('/{setting}/delete','AdminApp\SettingController@destroy')
         ->name('site_setting.setting.destroy')->middleware('permission:site-setting-del');

});
/**  end route for settings **/

/**  route for email templates **/
Route::group([
    'prefix' => 'admin/email_templates', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\EmailTemplateController@index')
         ->name('email_templates.email_template.index')->middleware('permission:email-template-view');
         
    Route::get('/create','AdminApp\EmailTemplateController@create')
         ->name('email_templates.email_template.create')->middleware('permission:email-template-add');
         
    Route::get('/show/{email_template}','AdminApp\EmailTemplateController@show')
         ->name('email_templates.email_template.show')->middleware('permission:email-template-view');
         
    Route::get('/{email_template}/edit','AdminApp\EmailTemplateController@edit')
         ->name('email_templates.email_template.edit')->middleware('permission:email-template-edit');
         
    Route::post('/', 'AdminApp\EmailTemplateController@store')
         ->name('email_templates.email_template.store')->middleware('permission:email-template-add');
         
    Route::put('email_template/{email_template}', 'AdminApp\EmailTemplateController@update')
         ->name('email_templates.email_template.update')->middleware('permission:email-template-edit');
         
    Route::get('/{email_template}/delete','AdminApp\EmailTemplateController@destroy')
         ->name('email_templates.email_template.destroy')->middleware('permission:email-template-del');

});
/**  end route for email templates **/


Route::group([
    'prefix' => 'admin/menues', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\MenuesController@index')
         ->name('menues.menues.index');
         
    Route::get('/create','AdminApp\MenuesController@create')
         ->name('menues.menues.create');
         
    Route::get('/show/{menues}','AdminApp\MenuesController@show')
         ->name('menues.menues.show')->where('id', '[0-9]+');
         
    Route::get('/{menues}/edit','AdminApp\MenuesController@edit')
         ->name('menues.menues.edit')->where('id', '[0-9]+');
         
    Route::post('/', 'AdminApp\MenuesController@store')
         ->name('menues.menues.store');
         
    Route::put('menues/{menues}', 'AdminApp\MenuesController@update')
         ->name('menues.menues.update')->where('id', '[0-9]+');
         
    Route::get('/{menues}/delete','AdminApp\MenuesController@destroy')
         ->name('menues.menues.destroy')->where('id', '[0-9]+');

});

Route::group([
    'prefix' => 'admin/blogs', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\BlogsController@index')
         ->name('blogs.blog.index')->middleware('permission:blogs-view');
         
    Route::get('/create','AdminApp\BlogsController@create')
         ->name('blogs.blog.create')->middleware('permission:blogs-add');;
         
    Route::get('/show/{blog}','AdminApp\BlogsController@show')
         ->name('blogs.blog.show')->middleware('permission:blogs-view');
         
    Route::get('/{blog}/edit','AdminApp\BlogsController@edit')
         ->name('blogs.blog.edit')->middleware('permission:blogs-edit');
         
    Route::post('/', 'AdminApp\BlogsController@store')
         ->name('blogs.blog.store')->middleware('permission:blogs-add');
         
    Route::put('blog/{blog}', 'AdminApp\BlogsController@update')
         ->name('blogs.blog.update')->middleware('permission:blogs-edit');
         
    Route::get('/{blog}/delete','AdminApp\BlogsController@destroy')
         ->name('blogs.blog.destroy')->middleware('permission:blogs-del');

});


Route::group([
    'prefix' => 'admin/faqs', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\FaqsController@index')
         ->name('faqs.faq.index')->middleware('permission:manage-faq-view');
         
    Route::get('/create','AdminApp\FaqsController@create')
         ->name('faqs.faq.create')->middleware('permission:manage-faq-add');
         
    Route::get('/show/{faq}','AdminApp\FaqsController@show')
         ->name('faqs.faq.show')->where('id', '[0-9]+')->middleware('permission:manage-faq-show');
         
    Route::get('/{faq}/edit','AdminApp\FaqsController@edit')
         ->name('faqs.faq.edit')->where('id', '[0-9]+')->middleware('permission:manage-faq-edit');
         
    Route::post('/store', 'AdminApp\FaqsController@store')
         ->name('faqs.faq.store')->middleware('permission:manage-faq-add');
         
    Route::post('faq/{faq}', 'AdminApp\FaqsController@update')
         ->name('faqs.faq.update')->where('id', '[0-9]+')->middleware('permission:manage-faq-edit');
         
    Route::get('/{faq}/delete','AdminApp\FaqsController@destroy')
         ->name('faqs.faq.destroy')->where('id', '[0-9]+')->middleware('permission:manage-faq-del');

});


Route::get('/link', function () {
    Artisan::call('storage:link');
});

Route::group([
    'prefix' => 'admin/location/countries', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CountriesController@index')
         ->name('countries.country.index')->middleware('permission:country-view');
         
    Route::get('/create','AdminApp\CountriesController@create')
         ->name('countries.country.create')->middleware('permission:country-add');
         
    Route::get('/show/{country}','AdminApp\CountriesController@show')
         ->name('countries.country.show')->where('id', '[0-9]+')->middleware('permission:country-view');
         
    Route::get('/{country}/edit','AdminApp\CountriesController@edit')
         ->name('countries.country.edit')->where('id', '[0-9]+')->middleware('permission:country-edit');
         
    Route::post('/', 'AdminApp\CountriesController@store')
         ->name('countries.country.store')->middleware('permission:country-add');
         
    Route::put('country/{country}', 'AdminApp\CountriesController@update')
         ->name('countries.country.update')->where('id', '[0-9]+')->middleware('permission:country-edit');
         
    Route::get('/{country}/delete','AdminApp\CountriesController@destroy')
         ->name('countries.country.destroy')->where('id', '[0-9]+')->middleware('permission:country-del');
         
    Route::get('/import', 'AdminApp\CountriesController@import')
             ->name('countries.country.import')->middleware(['permission:import-view']);

    Route::post('/import', 'AdminApp\CountriesController@import')
             ->name('countries.country.import.post')->middleware(['permission:import-add']);

    Route::get('/downloadsample', 'AdminApp\CountriesController@download_sample_country_csv')
             ->name('countries.country.download')->middleware(['permission:import-view']);

    Route::get('/allCountries', 'AdminApp\CountriesController@countries')
            ->name('countries.country.allCountries');         

});

Route::group([
    'prefix' => 'admin/location/states', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\StatesController@index')
         ->name('states.state.index');
         
    Route::get('/create','AdminApp\StatesController@create')
         ->name('states.state.create');
         
    Route::get('/show/{state}','AdminApp\StatesController@show')
         ->name('states.state.show')->where('id', '[0-9]+');
         
    Route::get('/{state}/edit','AdminApp\StatesController@edit')
         ->name('states.state.edit')->where('id', '[0-9]+');
         
    Route::post('/', 'AdminApp\StatesController@store')
         ->name('states.state.store');
         
    Route::put('state/{state}', 'AdminApp\StatesController@update')
         ->name('states.state.update')->where('id', '[0-9]+');
         
    Route::get('/{state}/delete','AdminApp\StatesController@destroy')
         ->name('states.state.destroy')->where('id', '[0-9]+');

    Route::get('/allStates', 'AdminApp\StatesController@states')
            ->name('states.state.allStates');
});

Route::group([
    'prefix' => 'admin/location/cities', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CitiesController@index')
         ->name('cities.city.index');
         
    Route::get('/create','AdminApp\CitiesController@create')
         ->name('cities.city.create');
         
    Route::get('/show/{city}','AdminApp\CitiesController@show')
         ->name('cities.city.show')->where('id', '[0-9]+');
         
    Route::get('/{city}/edit','AdminApp\CitiesController@edit')
         ->name('cities.city.edit')->where('id', '[0-9]+');
         
    Route::post('/', 'AdminApp\CitiesController@store')
         ->name('cities.city.store');
         
    Route::put('city/{city}', 'AdminApp\CitiesController@update')
         ->name('cities.city.update')->where('id', '[0-9]+');
         
    Route::get('/{city}/delete','AdminApp\CitiesController@destroy')
         ->name('cities.city.destroy')->where('id', '[0-9]+');

    Route::get('/get_state/{country}','AdminApp\CitiesController@load_state')
         ->name('cities.city.destroy')->where('id', '[0-9]+');

    Route::get('/allCities', 'AdminApp\CitiesController@cities')
            ->name('cities.city.allCities');     

});


Route::group([
    'prefix' => 'admin/job_attribute/functional_areas', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\FunctionalAreasController@index')
         ->name('functional_areas.functional_area.index')->middleware('permission:functional-area-view');
         
    Route::get('/create','AdminApp\FunctionalAreasController@create')
         ->name('functional_areas.functional_area.create')->middleware('permission:functional-area-add');
         
    Route::get('/show/{functionalArea}','AdminApp\FunctionalAreasController@show')
         ->name('functional_areas.functional_area.show')->where('id', '[0-9]+')->middleware('permission:functional-area-view');
         
    Route::get('/{functionalArea}/edit','AdminApp\FunctionalAreasController@edit')
         ->name('functional_areas.functional_area.edit')->where('id', '[0-9]+')->middleware('permission:functional-area-edit');
         
    Route::post('/', 'AdminApp\FunctionalAreasController@store')
         ->name('functional_areas.functional_area.store')->middleware('permission:functional-area-add');
         
    Route::put('functional_area/{functionalArea}', 'AdminApp\FunctionalAreasController@update')
         ->name('functional_areas.functional_area.update')->where('id', '[0-9]+')->middleware('permission:functional-area-edit');
         
    Route::get('/{functionalArea}/delete','AdminApp\FunctionalAreasController@destroy')
         ->name('functional_areas.functional_area.destroy')->where('id', '[0-9]+')->middleware('permission:functional-area-del');

});




Route::group([
    'prefix' => 'admin/job_attribute/skills', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\SkillsController@index')
         ->name('skills.skill.index')->middleware('permission:skill-view');
         
    Route::get('/create','AdminApp\SkillsController@create')
         ->name('skills.skill.create')->middleware('permission:skill-add');
         
    Route::get('/show/{skill}','AdminApp\SkillsController@show')
         ->name('skills.skill.show')->where('id', '[0-9]+')->middleware('permission:skill-view');
         
    Route::get('/{skill}/edit','AdminApp\SkillsController@edit')
         ->name('skills.skill.edit')->where('id', '[0-9]+')->middleware('permission:skill-edit');
         
    Route::post('/', 'AdminApp\SkillsController@store')
         ->name('skills.skill.store')->middleware('permission:skill-add');
         
    Route::put('skill/{skill}', 'AdminApp\SkillsController@update')
         ->name('skills.skill.update')->where('id', '[0-9]+')->middleware('permission:skill-edit');
         
    Route::get('/{skill}/delete','AdminApp\SkillsController@destroy')
         ->name('skills.skill.destroy')->where('id', '[0-9]+')->middleware('permission:skill-del');

});




Route::group([
    'prefix' => 'admin/job_attribute/work_types', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\WorkTypesController@index')
         ->name('work_types.work_type.index')->middleware('permission:work-type-view');
         
    Route::get('/create','AdminApp\WorkTypesController@create')
         ->name('work_types.work_type.create')->middleware('permission:work-type-add');
         
    Route::get('/show/{workType}','AdminApp\WorkTypesController@show')
         ->name('work_types.work_type.show')->where('id', '[0-9]+')->middleware('permission:work-type-view');
         
    Route::get('/{workType}/edit','AdminApp\WorkTypesController@edit')
         ->name('work_types.work_type.edit')->where('id', '[0-9]+')->middleware('permission:work-type-edit');
         
    Route::post('/', 'AdminApp\WorkTypesController@store')
         ->name('work_types.work_type.store')->middleware('permission:work-type-add');
         
    Route::put('work_type/{workType}', 'AdminApp\WorkTypesController@update')
         ->name('work_types.work_type.update')->where('id', '[0-9]+')->middleware('permission:work-type-edit');
         
    Route::get('/{workType}/delete','AdminApp\WorkTypesController@destroy')
         ->name('work_types.work_type.destroy')->where('id', '[0-9]+')->middleware('permission:work-type-del');

});

Route::group([
    'prefix' => 'admin/job_attribute/designations', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\DesignationsController@index')
         ->name('designations.designation.index')->middleware('permission:designation-view');
         
    Route::get('/create','AdminApp\DesignationsController@create')
         ->name('designations.designation.create')->middleware('permission:designation-add');
         
    Route::get('/show/{designation}','AdminApp\DesignationsController@show')
         ->name('designations.designation.show')->where('id', '[0-9]+')->middleware('permission:designation-view');
         
    Route::get('/{designation}/edit','AdminApp\DesignationsController@edit')
         ->name('designations.designation.edit')->where('id', '[0-9]+')->middleware('permission:designation-edit');
         
    Route::post('/', 'AdminApp\DesignationsController@store')
         ->name('designations.designation.store')->middleware('permission:designation-add');
         
    Route::put('designation/{designation}', 'AdminApp\DesignationsController@update')
         ->name('designations.designation.update')->where('id', '[0-9]+')->middleware('permission:designation-edit');
         
    Route::get('/{designation}/delete','AdminApp\DesignationsController@destroy')
         ->name('designations.designation.destroy')->where('id', '[0-9]+')->middleware('permission:designation-del');

});

Route::group([
    'prefix' => 'admin/job_attribute/industries', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\IndustriesController@index')
         ->name('industries.industry.index')->middleware('permission:industries-view');
         
    Route::get('/create','AdminApp\IndustriesController@create')
         ->name('industries.industry.create')->middleware('permission:industries-add');
         
    Route::get('/show/{industry}','AdminApp\IndustriesController@show')
         ->name('industries.industry.show')->where('id', '[0-9]+')->middleware('permission:industries-view');
         
    Route::get('/{industry}/edit','AdminApp\IndustriesController@edit')
         ->name('industries.industry.edit')->where('id', '[0-9]+')->middleware('permission:industries-edit');
         
    Route::post('/', 'AdminApp\IndustriesController@store')
         ->name('industries.industry.store')->middleware('permission:industries-add');
         
    Route::put('industry/{industry}', 'AdminApp\IndustriesController@update')
         ->name('industries.industry.update')->where('id', '[0-9]+')->middleware('permission:industries-edit');
         
    Route::get('/{industry}/delete','AdminApp\IndustriesController@destroy')
         ->name('industries.industry.destroy')->where('id', '[0-9]+')->middleware('permission:industries-del');

});

Route::group([
    'prefix' => 'admin/job_attribute/education', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\EducationController@index')
         ->name('education.education.index')->middleware('permission:education-view');
         
    Route::get('/create','AdminApp\EducationController@create')
         ->name('education.education.create')->middleware('permission:education-add');
         
    Route::get('/show/{education}','AdminApp\EducationController@show')
         ->name('education.education.show')->where('id', '[0-9]+')->middleware('permission:education-view');
         
    Route::get('/{education}/edit','AdminApp\EducationController@edit')
         ->name('education.education.edit')->where('id', '[0-9]+')->middleware('permission:education-edit');
         
    Route::post('/', 'AdminApp\EducationController@store')
         ->name('education.education.store')->middleware('permission:education-add');
         
    Route::put('education/{education}', 'AdminApp\EducationController@update')
         ->name('education.education.update')->where('id', '[0-9]+')->middleware('permission:education-edit');
         
    Route::get('/{education}/delete','AdminApp\EducationController@destroy')
         ->name('education.education.destroy')->where('id', '[0-9]+')->middleware('permission:education-del');

});

Route::group([
    'prefix' => 'admin/job_attribute/timezones', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\TimezonesController@index')
         ->name('timezones.timezone.index')->middleware('permission:timezones-view');
         
    Route::get('/create','AdminApp\TimezonesController@create')
         ->name('timezones.timezone.create')->middleware('permission:timezones-add');
         
    Route::get('/show/{timezone}','AdminApp\TimezonesController@show')
         ->name('timezones.timezone.show')->where('id', '[0-9]+')->middleware('permission:timezones-view');
         
    Route::get('/{timezone}/edit','AdminApp\TimezonesController@edit')
         ->name('timezones.timezone.edit')->where('id', '[0-9]+')->middleware('permission:timezones-edit');
         
    Route::post('/', 'AdminApp\TimezonesController@store')
         ->name('timezones.timezone.store')->middleware('permission:timezones-add');
         
    Route::put('timezone/{timezone}', 'AdminApp\TimezonesController@update')
         ->name('timezones.timezone.update')->where('id', '[0-9]+')->middleware('permission:timezones-edit');
         
    Route::get('/{timezone}/delete','AdminApp\TimezonesController@destroy')
         ->name('timezones.timezone.destroy')->where('id', '[0-9]+')->middleware('permission:timezones-del');

});


Route::group(['prefix' => 'candidate'], function () {

  Route::get('/', 'CandidateAuth\LoginController@showLoginForm')->name('candidate');

  Route::get('/login', 'CandidateAuth\LoginController@showLoginForm')->name('candidate.login');

  Route::post('/login', 'CandidateAuth\LoginController@login');
  Route::post('/logout', 'CandidateAuth\LoginController@logout')->name('logout');


  Route::get('login/{service}', 'CandidateAuth\LoginController@redirectToProvider');
  Route::get('login/{service}/callback', 'CandidateAuth\LoginController@handleProviderCallback');

  /*Route::get('login/twitter', 'CandidateAuth\LoginController@redirectToProvider');
  Route::get('login/twitter/callback', 'CandidateAuth\LoginController@handleProviderCallback');*/


  Route::get('/register', 'CandidateAuth\RegisterController@showRegistrationForm')->name('candidate.register');
  Route::post('/register', 'CandidateAuth\RegisterController@register');

  Route::post('/password/email', 'CandidateAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CandidateAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CandidateAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CandidateAuth\ResetPasswordController@showResetForm');
});

Route::group([
    'prefix' => 'admin/users/candidates', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CandidatesController@index')
         ->name('candidates.candidate.index')->middleware('permission:candidate-view');

    Route::get('download_resume/{candidate}', 'AdminApp\CandidatesController@download_resume')->name('candidates.resume.download')->middleware('permission:candidate-view');

    Route::get('download_cover_letter/{candidate}', 'AdminApp\CandidatesController@download_cover_letter')->name('candidates.cover_letter.download')->middleware('permission:candidate-view');
         
    Route::get('/create','AdminApp\CandidatesController@create')
         ->name('candidates.candidate.create')->middleware('permission:candidate-add');
         
    Route::get('/show/{candidate}','AdminApp\CandidatesController@show')
         ->name('candidates.candidate.show')->where('id', '[0-9]+')->middleware('permission:candidate-view');
         
    Route::get('/{candidate}/edit','AdminApp\CandidatesController@edit')
         ->name('candidates.candidate.edit')->where('id', '[0-9]+')->middleware('permission:candidate-edit');
         
    Route::post('/', 'AdminApp\CandidatesController@store')
         ->name('candidates.candidate.store')->middleware('permission:candidate-add');
         
    Route::put('candidate/{candidate}', 'AdminApp\CandidatesController@update')
         ->name('candidates.candidate.update')->where('id', '[0-9]+')->middleware('permission:candidate-edit');
         
    Route::get('/{candidate}/delete','AdminApp\CandidatesController@destroy')
         ->name('candidates.candidate.destroy')->where('id', '[0-9]+')->middleware('permission:candidate-del');
     });



Route::group([
    'prefix' => 'admin/currencies', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CurrenciesController@index')
         ->name('currencies.currency.index')->middleware('permission:currencies-view');
         
    Route::get('/create','AdminApp\CurrenciesController@create')
         ->name('currencies.currency.create')->middleware('permission:currencies-add');
         
    Route::get('/show/{currency}','AdminApp\CurrenciesController@show')
         ->name('currencies.currency.show')->where('id', '[0-9]+')->middleware('permission:currencies-view');
         
    Route::get('/{currency}/edit','AdminApp\CurrenciesController@edit')
         ->name('currencies.currency.edit')->where('id', '[0-9]+')->middleware('permission:currencies-edit');
         
    Route::post('/', 'AdminApp\CurrenciesController@store')
         ->name('currencies.currency.store')->middleware('permission:currencies-add');
         
    Route::put('currency/{currency}', 'AdminApp\CurrenciesController@update')
         ->name('currencies.currency.update')->where('id', '[0-9]+')->middleware('permission:currencies-edit');
         
    Route::get('/{currency}/delete','AdminApp\CurrenciesController@destroy')
         ->name('currencies.currency.destroy')->where('id', '[0-9]+')->middleware('permission:currencies-del');


});

Route::group(['prefix' => 'specialist'], function () {
  
  Route::get('/', 'SpecialistAuth\LoginController@showLoginForm')->name('specialist');

  Route::get('/login', 'SpecialistAuth\LoginController@showLoginForm')->name('specialist.login');

  Route::post('/login', 'SpecialistAuth\LoginController@login');
  Route::post('/logout', 'SpecialistAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'SpecialistAuth\RegisterController@showRegistrationForm')->name('specialist.register');
  Route::post('/register', 'SpecialistAuth\RegisterController@register');

  Route::post('/password/email', 'SpecialistAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'SpecialistAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'SpecialistAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'SpecialistAuth\ResetPasswordController@showResetForm');
});

Route::group([
    'prefix' => 'admin/users/specialist', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\SpecialistsController@index')
         ->name('specialists.specialist.index')->middleware('permission:specialist-view');
         
    Route::get('/create','AdminApp\SpecialistsController@create')
         ->name('specialists.specialist.create')->middleware('permission:specialist-add');
         
    Route::get('/show/{specialist}','AdminApp\SpecialistsController@show')
         ->name('specialists.specialist.show')->where('id', '[0-9]+')->middleware('permission:specialist-view');
         
    Route::get('/{specialist}/edit','AdminApp\SpecialistsController@edit')
         ->name('specialists.specialist.edit')->where('id', '[0-9]+')->middleware('permission:specialist-edit');
         
    Route::post('/', 'AdminApp\SpecialistsController@store')
         ->name('specialists.specialist.store')->middleware('permission:specialist-add');
         
    Route::put('specialist/{specialist}', 'AdminApp\SpecialistsController@update')
         ->name('specialists.specialist.update')->where('id', '[0-9]+')->middleware('permission:specialist-edit');
         
    Route::get('/{specialist}/delete','AdminApp\SpecialistsController@destroy')
         ->name('specialists.specialist.destroy')->where('id', '[0-9]+')->middleware('permission:specialist-del');
    
    Route::get('download_resume/{specialist}', 'AdminApp\SpecialistsController@download_resume')
    ->name('specialists.resume.download')->middleware('permission:specialist-view');
});


Route::group(['prefix' => 'employer'], function () {
  Route::get('/', 'EmployerAuth\LoginController@showLoginForm')->name('employer');
  Route::get('/login', 'EmployerAuth\LoginController@showLoginForm')->name('employer.login');
  Route::post('/login', 'EmployerAuth\LoginController@login');
  Route::post('/logout', 'EmployerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'EmployerAuth\RegisterController@showRegistrationForm')->name('employer.register');
  Route::post('/register', 'EmployerAuth\RegisterController@register');

  Route::post('/password/email', 'EmployerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'EmployerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'EmployerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'EmployerAuth\ResetPasswordController@showResetForm');
});



Route::group([
    'prefix' => 'admin/users/employers', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\EmployersController@index')
         ->name('employers.employer.index')->middleware('permission:employer-view');
         
    Route::get('/create','AdminApp\EmployersController@create')
         ->name('employers.employer.create')->middleware('permission:employer-add');
         
    Route::get('/show/{employer}','AdminApp\EmployersController@show')
         ->name('employers.employer.show')->where('id', '[0-9]+')->middleware('permission:employer-view');
         
    Route::get('/{employer}/edit','AdminApp\EmployersController@edit')
         ->name('employers.employer.edit')->where('id', '[0-9]+')->middleware('permission:employer-edit');
         
    Route::post('/', 'AdminApp\EmployersController@store')
         ->name('employers.employer.store')->middleware('permission:employer-add');
         
    Route::put('employer/{employer}', 'AdminApp\EmployersController@update')
         ->name('employers.employer.update')->where('id', '[0-9]+')->middleware('permission:employer-edit');
         
    Route::get('/{employer}/delete','AdminApp\EmployersController@destroy')
         ->name('employers.employer.destroy')->where('id', '[0-9]+')->middleware('permission:employer-del');
         });


Route::group([
    'prefix' => 'admin/users/specialist', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\SpecialistsController@index')
         ->name('specialists.specialist.index')->middleware('permission:specialist-view');
         
    Route::get('/create','AdminApp\SpecialistsController@create')
         ->name('specialists.specialist.create')->middleware('permission:specialist-add');
         
    Route::get('/show/{specialist}','AdminApp\SpecialistsController@show')
         ->name('specialists.specialist.show')->where('id', '[0-9]+')->middleware('permission:specialist-view');
         
    Route::get('/{specialist}/edit','AdminApp\SpecialistsController@edit')
         ->name('specialists.specialist.edit')->where('id', '[0-9]+')->middleware('permission:specialist-edit');
         
    Route::post('/', 'AdminApp\SpecialistsController@store')
         ->name('specialists.specialist.store')->middleware('permission:specialist-add');
         
    Route::put('specialist/{specialist}', 'AdminApp\SpecialistsController@update')
         ->name('specialists.specialist.update')->where('id', '[0-9]+')->middleware('permission:specialist-edit');
         
    Route::get('/{specialist}/delete','AdminApp\SpecialistsController@destroy')
         ->name('specialists.specialist.destroy')->where('id', '[0-9]+')->middleware('permission:specialist-del');
	
	Route::get('download_resume/{specialist}', 'AdminApp\SpecialistsController@download_resume')
	->name('specialists.resume.download')->middleware('permission:specialist-view');
    });

Route::group([
    'prefix' => 'admin/newsletters', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\NewsletterController@index')
         ->name('newsletters.newsletter.index')->middleware('permission:newsletters-view');
         
    Route::get('/create','AdminApp\NewsletterController@create')
         ->name('newsletters.newsletter.create')->middleware('permission:newsletters-add');
         
    Route::get('/show/{newsletter}','AdminApp\NewsletterController@show')
         ->name('newsletters.newsletter.show')->where('id', '[0-9]+')->middleware('permission:newsletters-show');

    Route::get('/send/{newsletter}','AdminApp\NewsletterController@send')
         ->name('newsletters.newsletter.send')->where('id', '[0-9]+')->middleware('permission:newsletters-show');     
         
    Route::get('/{newsletter}/edit','AdminApp\NewsletterController@edit')
         ->name('newsletters.newsletter.edit')->where('id', '[0-9]+')->middleware('permission:newsletters-edit');
         
    Route::post('/store', 'AdminApp\NewsletterController@store')
         ->name('newsletters.newsletter.store')->middleware('permission:newsletters-add');
         
    Route::put('newsletter/{newsletter}', 'AdminApp\NewsletterController@update')
         ->name('newsletters.newsletter.update')->where('id', '[0-9]+')->middleware('permission:newsletters-edit');
         
    Route::get('/{newsletter}/delete','AdminApp\NewsletterController@destroy')
         ->name('newsletters.newsletter.destroy')->where('id', '[0-9]+')->middleware('permission:newsletters-del');

});

Route::group([

    'prefix' => 'admin/bank_formats', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\BankFormatController@index')
         ->name('bank_format.index')->middleware('permission:bank-format-view');


    Route::get('/{bankFormat}/edit','AdminApp\BankFormatController@edit')
         ->name('bank_format.edit')->where('id', '[0-9]+')->middleware('permission:bank-format-edit');
         
    Route::post('/update/{bankFormat}', 'AdminApp\BankFormatController@update')
         ->name('bank_format.update')->middleware('permission:bank-format-edit');
         
    
         
    /*Route::get('/{blogCategory}/edit','AdminApp\BlogCategoriesController@edit')
         ->name('blog_categories.blog_category.edit')->where('id', '[0-9]+')->middleware('permission:category-edit');
         
    Route::post('/', 'AdminApp\BlogCategoriesController@store')
         ->name('blog_categories.blog_category.store')->middleware('permission:category-add');
         
    Route::put('blog_category/{blogCategory}', 'AdminApp\BlogCategoriesController@update')
         ->name('blog_categories.blog_category.update')->where('id', '[0-9]+')->middleware('permission:category-edit');
         
    Route::get('/{blogCategory}/delete','AdminApp\BlogCategoriesController@destroy')
         ->name('blog_categories.blog_category.destroy')->where('id', '[0-9]+')->middleware('permission:category-del');*/

});

Route::group([
    'prefix' => 'admin/currency_rate_conversions', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CurrencyConversionController@index')
         ->name('currency_rate_conversions.currency_rate_conversion.index')->middleware('permission:currency-rate-conversion-view');
         
    Route::get('/create','AdminApp\CurrencyConversionController@create')
         ->name('currency_rate_conversions.currency_rate_conversion.create')->middleware('permission:currency-rate-conversion-add');;
         
    Route::get('/show/{currency_rate_conversion}','AdminApp\CurrencyConversionController@show')
         ->name('currency_rate_conversions.currency_rate_conversion.show')->middleware('permission:currency-rate-conversion-view');
         
    Route::get('/{currency_rate_conversion}/edit','AdminApp\CurrencyConversionController@edit')
         ->name('currency_rate_conversions.currency_rate_conversion.edit')->middleware('permission:currency-rate-conversion-edit');
         
    Route::post('/', 'AdminApp\CurrencyConversionController@store')
         ->name('currency_rate_conversions.currency_rate_conversion.store')->middleware('permission:currency-rate-conversion-add');
         
    Route::put('currency_rate_conversion/{currency_rate_conversion}', 'AdminApp\CurrencyConversionController@update')
         ->name('currency_rate_conversions.currency_rate_conversion.update')->middleware('permission:currency-rate-conversion-edit');
         
    Route::get('/{currency_rate_conversion}/delete','AdminApp\CurrencyConversionController@destroy')
         ->name('currency_rate_conversions.currency_rate_conversion.destroy')->middleware('permission:currency-rate-conversion-del');

    Route::get('/import', 'AdminApp\CurrencyConversionController@import')
             ->name('currency_rate_conversions.currency_rate_conversion.import')->middleware(['permission:currency-rate-conversion-view']);

    Route::post('/import', 'AdminApp\CurrencyConversionController@import')
             ->name('currency_rate_conversions.currency_rate_conversion.import.post')->middleware(['permission:currency-rate-conversion-add']);

    Route::get('/downloadsample', 'AdminApp\CurrencyConversionController@download_sample_currency_rate_conversion_csv')
             ->name('currency_rate_conversions.currency_rate_conversion.download')->middleware(['permission:currency-rate-conversion-view']);

});

/* manage compony routes   */
Route::group([
    'prefix' => 'admin/manage_companies', 'middleware'=>['auth:admin']
], function () {
    Route::get('/', 'AdminApp\CompanyController@index')
         ->name('manage_companies.manage_company.index')->middleware('permission:listing-view');
         
    Route::get('/create','AdminApp\CompanyController@create')
         ->name('manage_companies.manage_company.create')->middleware('permission:listing-add');
         
    Route::get('/show/{manage_company}','AdminApp\CompanyController@show')
         ->name('manage_companies.manage_company.show')->where('id', '[0-9]+')->middleware('permission:listing-view');
         

    Route::get('/make_featured/{manage_company}','AdminApp\CompanyController@make_featured')
         ->name('manage_companies.manage_company.make_featured')->where('id', '[0-9]+')->middleware('permission:listing-show');
              
    Route::get('/{manage_company}/edit','AdminApp\CompanyController@edit')
         ->name('manage_companies.manage_company.edit')->where('id', '[0-9]+')->middleware('permission:listing-edit');
         
    Route::post('/', 'AdminApp\CompanyController@store')
         ->name('manage_companies.manage_company.store')->middleware('permission:listing-add');
         
    Route::put('manage_company/{manage_company}', 'AdminApp\CompanyController@update')
         ->name('manage_companies.manage_company.update')->where('id', '[0-9]+')->middleware('permission:listing-edit');
         
    Route::get('/{manage_company}/delete','AdminApp\CompanyController@destroy')
         ->name('manage_companies.manage_company.destroy')->where('id', '[0-9]+')->middleware('permission:listing-del');

});
/* end manage compony routes   */



Route::group([
    'prefix' => 'admin/jobs', 'middleware'=>['auth:admin']
], function () {
    
         
    Route::get('/create','AdminApp\ManageJobsController@create')
         ->name('jobs.job.create')->middleware('permission:jobs-add');
         
    Route::get('/show/{job}','AdminApp\ManageJobsController@show')
         ->name('jobs.job.show')->where('id', '[0-9]+')->middleware('permission:jobs-view');
         
    Route::get('/{job}/edit','AdminApp\ManageJobsController@edit')
         ->name('jobs.job.edit')->where('id', '[0-9]+')->middleware('permission:jobs-edit');
         
    Route::post('/store', 'AdminApp\ManageJobsController@store')
         ->name('jobs.job.store')->middleware('permission:jobs-add');
         
    Route::put('job/{job}', 'AdminApp\ManageJobsController@update')
         ->name('jobs.job.update')->where('id', '[0-9]+')->middleware('permission:jobs-edit');
         
    Route::get('/{job}/delete','AdminApp\ManageJobsController@destroy')
         ->name('jobs.job.destroy')->where('id', '[0-9]+')->middleware('permission:jobs-del');

    Route::get('/get_state/{country}','AdminApp\ManageJobsController@load_state')
         ->name('cities.city.destroy')->where('id', '[0-9]+');

    Route::get('/get_city/{state}','AdminApp\ManageJobsController@load_city')
         ->name('cities.city.destroy')->where('id', '[0-9]+');

    Route::get('/get_specialist/{functional_id}','AdminApp\ManageJobsController@load_specialist')
         ->name('cities.city.destroy')->where('id', '[0-9]+');  

    Route::get('/{status?}', 'AdminApp\ManageJobsController@index')
         ->name('jobs.job.index')->middleware('permission:jobs-view');                  

});

Route::group(['prefix' => 'cronjob'], function ()
{
    Route::get('/notify-to-employer-payment-status','Web\CronJobController@sentEmailToEmployer')->name('cronjob_url_notify_employer');

    Route::get('/notify-to-referee-payment-status','Web\CronJobController@sentEmailToReferee')->name('cronjob_url_notify_referee');

    Route::get('/notify-to-specialist-payment-status','Web\CronJobController@sentEmailToSpecialist')->name('cronjob_url_notify_specialist');

});  


Route::group([
    'prefix' => 'admin/messages', 'middleware'=>['auth:admin']
], function () {
    
    Route::get('/', 'AdminApp\MessageController@index')
         ->name('messages.message.index')->middleware('permission:messages-view');

    Route::get('/show/{roomId}','AdminApp\MessageController@show')
         ->name('messages.message.show')->middleware('permission:messages-view');
     
         
    Route::post('/', 'AdminApp\MessageController@store')
         ->name('messages.message.store')->middleware('permission:messages-add');
         
    Route::get('/{blog}/delete','AdminApp\BlogsController@destroy')
         ->name('blogs.blog.destroy')->middleware('permission:blogs-del');

});  
