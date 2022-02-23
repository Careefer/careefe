<?php
Route::get('/home', function()
{
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('candidate')->user();
    //return view('candidateApp.home');
	return redirect()->route('candidate.my-profile');
})->name('home');

// Route::get('/home', 'CandidateApp\DashboardController@index')->name('candidateApp.home');

Route::get('/my-account', 'CandidateApp\AccountSettingController@account_setting')->name('my-account');
Route::post('/change-password', 'CandidateApp\AccountSettingController@change_password')->name('change-password');

Route::get('/my-profile', 'CandidateApp\ProfileController@profile_setting')->name('my-profile');
Route::post('/update-profile', 'CandidateApp\ProfileController@update_profile')->name('update-profile');




Route::post('/update-profile-pic', 'CandidateApp\ProfileController@update_profile_pic')->name('update.profile-pic');

Route::post('/resume', 'CandidateApp\ProfileController@upload_resume')->name('upload_resume'); // drag profile resume

Route::post('/cover_letter', 'CandidateApp\ProfileController@upload_cover_letter')->name('upload_cover_letter');

Route::post('/make_job_favorite','CandidateApp\JobController@make_job_favorite')->name('make_job_favorite');

// refer job by email
Route::post('job/refer_by_email/','CandidateApp\JobController@job_refer_to_email')->name('refer_job_email');

// apply on job
Route::get('/apply-job/{job_slug}', 'CandidateApp\JobController@view_apply_job_form')->name('apply_job');
Route::post('/apply-job/{job_slug}', 'CandidateApp\JobController@apply_job')->name('apply_job.post');

Route::post('/save-dragged-cover-letter', 'CandidateApp\JobController@upload_new_cv_cover_letter')->name('save_dragged_cover_letter');


Route::get('/apply-friend-job/{job_slug}', 'CandidateApp\JobController@show_friend_apply_job_form')->name('friend.apply_job');

Route::post('/apply-friend-job/{job_slug}', 'CandidateApp\JobController@apply_friend_job')->name('friend.apply_job.post');

Route::get('job/{type}', 'CandidateApp\SavedJobController@index')->name('saved_job');

Route::get('bank-detail', 'CandidateApp\ReferralController@bankDetail')->name('bank_detail');

Route::post('update-bank-detail', 'CandidateApp\ReferralController@updateBankDetail')->name('update_bank_detail');

Route::get('referral/{type}', 'CandidateApp\ReferralController@referral')->name('referral');

Route::get('referral/sent-detail/{id}', 'CandidateApp\ReferralController@referralSentDetail')->name('referral-sent-detail');
Route::get('referral/receive-detail/{id}', 'CandidateApp\ReferralController@referralReceivetDetail')->name('referral-receive-detail');

Route::post('update-application-rating', 'CandidateApp\ReferralController@updateRating')->name('update-application-rating');

Route::get('payment-history', 'CandidateApp\PaymentHistoryController@paymentHistory')->name('payment-history');

Route::get('payment-history/{id}/detail', 'CandidateApp\PaymentHistoryController@paymentHistoryDetail')->name('payment-history-detail');

Route::get('score-card', 'CandidateApp\PaymentHistoryController@scoreCard')->name('score-card');

// alerts
Route::get('/alerts', 'CandidateApp\AlertController@index')->name('alerts');
Route::get('/delete-alert/{id}', 'CandidateApp\AlertController@deleteAlert')->name('deleteAlert');

// messages
Route::get('/messages', 'CandidateApp\MessageController@allThreads')->name('messages');
Route::get('/chat/{room_id}', 'CandidateApp\MessageController@chat');
Route::post('/send_message', 'CandidateApp\MessageController@sendMessage')->name('send_message');
Route::get('/delete-thread/{id}', 'CandidateApp\MessageController@deleteThread')->name('deleteThread');

// notifications
Route::get('/notifications', 'NotificationController@index')->name('notifications');

Route::post('/readNotification', 'NotificationController@readNotification')->name('readNotification');

Route::post('/notification-status', 'NotificationController@notification_status')->name('notification-status');





