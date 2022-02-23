<?php

// Route::get('/home', function () {
//     $users[] = Auth::user();
//     $users[] = Auth::guard()->user();
//     $users[] = Auth::guard('employer')->user();

//     return view('employerApp.dashboard');
// })->name('home');

Route::get('/home', 'EmployerApp\DashboardController@index')->name('home');



Route::get('/profile','EmployerApp\AccountSettingController@view')->name('profile.view');

Route::get('/profile/edit','EmployerApp\AccountSettingController@profile_edit')->name('profile.edit');
Route::post('/update_profile','EmployerApp\AccountSettingController@update_profile')->name('profile.post');

Route::post('/update-profile-pic', 'EmployerApp\AccountSettingController@update_profile_pic')->name('update.profile-pic');

Route::post('/update_company_profile','EmployerApp\AccountSettingController@update_company_profile')->name('profile.company.post');

Route::get('/my-account', 'EmployerApp\AccountSettingController@account_setting')->name('my-account');
Route::post('/change-password', 'EmployerApp\AccountSettingController@change_password')->name('change-password');

Route::get('/jobs', 'EmployerApp\ManageJobsController@listing')->name('job.listing');

Route::get('/job/add', 'EmployerApp\ManageJobsController@view_add_job_form')->name('job.add');

Route::post('/job/add', 'EmployerApp\ManageJobsController@save_job')->name('job.add.post');

Route::get('/job/view/{id}', 'EmployerApp\ManageJobsController@view_job')->name('job.view');

Route::get('/job/edit/{id}', 'EmployerApp\ManageJobsController@job_edit_form')->name('job.edit');

Route::post('/job/edit', 'EmployerApp\ManageJobsController@edit_job')->name('job.edit.post');

// applications
Route::get('/{application_type}/applications', 'EmployerApp\ApplicationController@listing')->name('applications');

// applications
Route::get('/{slug}/application-listing', 'EmployerApp\ApplicationController@applicationDetail')->name('application.detail');

// applications
Route::get('/{slug}/application-detail', 'EmployerApp\ApplicationController@viewJobDetail')->name('job.application.detail');

//update employer note
Route::post('update-specialist_notes/{id}', 'EmployerApp\ApplicationController@updateEmployerNotes')->name('update.employer_notes');

Route::get('export-application-detail/{id}', 'EmployerApp\ApplicationController@exportApplicationDetail')->name('export.application-detail');

// applications
Route::get('/payments', 'EmployerApp\PaymentController@listing')->name('payments');

Route::get('/{id}/payment-detail', 'EmployerApp\PaymentController@paymentDetail')->name('payment-detail');

Route::get('export-payments/{id}', 'EmployerApp\PaymentController@exportPayments')->name('export-payments');


// messages
Route::get('/messages', 'EmployerApp\MessageController@allThreads')->name('messages');
Route::get('/chat/{room_id}', 'EmployerApp\MessageController@chat');
Route::post('/send_message', 'EmployerApp\MessageController@sendMessage')->name('send_message');
Route::get('/delete-thread/{id}', 'EmployerApp\MessageController@deleteThread')->name('deleteThread');

// notifications
Route::get('/notifications', 'NotificationController@index')->name('notifications');

Route::post('/readNotification', 'NotificationController@readNotification')->name('readNotification');

Route::post('/notification-status', 'NotificationController@notification_status')->name('notification-status');