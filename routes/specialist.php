<?php

// Route::get('/home', function ()
// {	
//     $users[] = Auth::user();
//     $users[] = Auth::guard()->user();
//     $users[] = Auth::guard('specialist')->user();

//     return view('specialistApp.dashboard');
// })->name('home');


Route::get('/home', 'SpecialistApp\DashboardController@index')->name('home');

//account
Route::get('/profile','SpecialistApp\AccountSettingController@my_profile')->name('profile');


Route::post('/update_profile','SpecialistApp\AccountSettingController@update_profile')->name('profile.post');

Route::post('/update-profile-pic', 'SpecialistApp\AccountSettingController@update_profile_pic')->name('update.profile-pic');

Route::post('/upload_my_resume','SpecialistApp\AccountSettingController@upload_resume')->name('upload_my_resume'); // drag & drop

Route::get('/my-account', 'SpecialistApp\AccountSettingController@account_setting')->name('my-account');

Route::post('/change-password', 'SpecialistApp\AccountSettingController@change_password')->name('change-password');




// jobs
Route::get('/{job_type}/jobs', 'SpecialistApp\JobController@listing')->name('jobs');

Route::get('/job/decline/{job_id}', 'SpecialistApp\JobController@make_job_decline')->name('make_job_decline');

Route::get('/job/accept/{job_id}', 'SpecialistApp\JobController@make_job_accept')->name('make_job_accept');

// applications
Route::get('/{application_type}/applications', 'SpecialistApp\ApplicationController@listing')->name('applications');

// applications
Route::get('/{slug}/application-listing', 'SpecialistApp\ApplicationController@applicationDetail')->name('application.detail');

// applications
Route::get('/{slug}/application-detail', 'SpecialistApp\JobDetailController@viewJobDetail')->name('job.application.detail');
//
Route::get('/application-detail/{app_id}', 'SpecialistApp\JobDetailController@shareWithEmployer')->name('job.application.share-with-employer');
//update specilist note
Route::post('update-specialist_notes/{id}', 'SpecialistApp\JobDetailController@updateSpecialistNotes')->name('update.specialist_notes');
//Referrals
Route::get('referral/{type}', 'SpecialistApp\ReferralController@index')->name('referral-section');

Route::get('bank-detail', 'SpecialistApp\PaymentController@bankDetail')->name('bank_detail');

Route::post('update-bank-detail', 'SpecialistApp\PaymentController@updateBankDetail')->name('update_bank_detail');

Route::get('referral/sent-detail/{id}', 'SpecialistApp\ReferralController@referralSentDetail')->name('referral-send-detail');

Route::get('referral/receive-detail/{id}', 'SpecialistApp\ReferralController@referralReceivetDetail')->name('referral-receive-detail');

Route::post('update-application-rating', 'SpecialistApp\ReferralController@updateRating')->name('update-application-rating');
Route::get('referral-payment', 'SpecialistApp\PaymentHistoryController@index')->name('referral-payment');

Route::get('specialist-payment', 'SpecialistApp\PaymentHistoryController@specialistPayment')->name('specialist-payment');

Route::get('{id}/specialist-payment-detail', 'SpecialistApp\PaymentHistoryController@specialistPaymentDetail')->name('specialist-payment-detail');

Route::get('referral-score', 'SpecialistApp\PaymentHistoryController@referralScore')->name('referral-score');

Route::get('specialist-score', 'SpecialistApp\PaymentHistoryController@specialistScore')->name('specialist-score');

Route::get('{id}/referral-payment-detail', 'SpecialistApp\PaymentHistoryController@referralPaymentDetail')->name('referral-payment-detail');

// messages
Route::get('/messages', 'SpecialistApp\MessageController@allThreads')->name('messages');
Route::get('/chat/{room_id}', 'SpecialistApp\MessageController@chat');
Route::post('/send_message', 'SpecialistApp\MessageController@sendMessage')->name('send_message');
Route::get('/delete-thread/{id}', 'SpecialistApp\MessageController@deleteThread')->name('deleteThread');

// notifications
Route::get('/notifications', 'NotificationController@index')->name('notifications');

Route::post('/readNotification', 'NotificationController@readNotification')->name('readNotification');

Route::post('/notification-status', 'NotificationController@notification_status')->name('notification-status');