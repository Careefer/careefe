<?php

/*Route::get('/home',function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    return view('dashboard.dashboard');
})->name('home')->middleware('permission:dashboard-view');*/

// job application
Route::get('/job-applications','AdminApp\JobApplicationsController@listing')->name('job_applications')->middleware('permission:manage-applications-view');

Route::get('/job-applications/show/{application_id}','AdminApp\JobApplicationsController@view')->name('job_applications_view')->middleware('permission:manage-applications-view');

Route::post('/job-applications/status-update/{id}', 'AdminApp\JobApplicationsController@updateJobStatus')->name('job_applications.status.update')->middleware('permission:manage-applications-view');

// job referrals
Route::get('/manage-referrals','AdminApp\ManageReferralController@listing')->name('referral_job_applications')->middleware('permission:manage-referral-view');
Route::get('/manage-referrals/show/{application_id}','AdminApp\ManageReferralController@view_detail')->name('referral_job_application_view')->middleware('permission:manage-referral-view');

// company associated accounts

Route::get('/employers/list_associated_acc/{company_id}','AdminApp\EmployersController@list_associated_acc')->name('list_associated_acc')->middleware('permission:employer-view');

Route::get('/employers/create_associated_acc/{company_id}','AdminApp\EmployersController@create_associated_acc')->name('create_associated_acc')->middleware('permission:employer-add');

Route::post('/employers/store_associated_acc/{company_id}','AdminApp\EmployersController@store_associated_acc')->name('store_associated_acc')->middleware('permission:employer-add');

Route::get('/employers/edit_associated_acc/{user_id}','AdminApp\EmployersController@edit_associated_acc')->name('edit_associated_acc')->middleware('permission:employer-edit');

Route::post('/employers/update_associated_acc/{company_id}','AdminApp\EmployersController@update_associated_acc')->name('update_associated_acc')->middleware('permission:employer-edit');

Route::get('/employers/delete_associated_acc/{user_id}','AdminApp\EmployersController@delete_associated_acc')->name('delete_associated_acc')->middleware('permission:employer-del');

Route::get('/payment-candidate', 'AdminApp\PaymentController@candidatePayment')->name('candidate-payment');

Route::get('/employer/payment-summary', 'AdminApp\PaymentController@employerPayment')->name('employer-payment-summary');

Route::get('/employer/paid-payments', 'AdminApp\PaymentController@employerPaidPayment')->name('employer-payment-paid');

Route::get('/employer/unpaid-payments', 'AdminApp\PaymentController@employerUnPaidPayment')->name('employer-payment-unpaid');

Route::get('/employer/{id}/unpaid-payment-detail', 'AdminApp\PaymentController@unpaidPaymentDetail')->name('employer-unpaid-payment-detail');

Route::get('/employer/{id}/paid-payment-detail', 'AdminApp\PaymentController@paidPaymentDetail')->name('employer-paid-payment-detail');

Route::get('/employer/payment-status-update', 'AdminApp\PaymentController@paymentStatusUpdate')->name('payment-status-update');

Route::get('employer/update-payment-status-by-csv', 'AdminApp\PaymentController@paymentStatusUpdateByCSV')->name('payment-status-update-by-csv');

Route::post('employer/import-payment-csv','AdminApp\PaymentController@importPaymentCSV')->name('import-payment-csv');


Route::get('/referee/payment-summary', 'AdminApp\RefereePaymentController@paymentSummary')->name('referee-payment-summary');

Route::get('/referee/unpaid-payment', 'AdminApp\RefereePaymentController@unpaidPayment')->name('referee-unpaid-payment');

Route::get('/referee/paid-payment', 'AdminApp\RefereePaymentController@paidPayment')->name('referee-paid-payment');

Route::get('/referee/import-payment-status', 'AdminApp\RefereePaymentController@paymentStatus')->name('referee-payment-status');
Route::post('/referee/update-payment-status', 'AdminApp\RefereePaymentController@updatePaymentStatus')->name('referee-update-payment-status');

Route::get('/referee/{id}/unpaid-payment-detail', 'AdminApp\RefereePaymentController@unpaidPaymentDetail')->name('referee-unpaid-payment-detail');

Route::get('/referee/payment-status-update', 'AdminApp\RefereePaymentController@paymentStatusUpdate')->name('referee-payment-status-update');

Route::get('/referee/{id}/paid-payment-detail', 'AdminApp\RefereePaymentController@paidPaymentDetail')->name('referee-paid-payment-detail');

Route::get('/specialist/payment-summary', 'AdminApp\SpecialistPaymentController@paymentSummary')->name('specialist-payment-summary');

Route::get('/specialist/unpaid-payments', 'AdminApp\SpecialistPaymentController@unpaidPayments')->name('specialist-unpaid-payments');

Route::get('/specialist/paid-payments', 'AdminApp\SpecialistPaymentController@paidPayments')->name('specialist-paid-payments');

Route::get('/specialist/import-payment-status', 'AdminApp\SpecialistPaymentController@paymentStatus')->name('specialist-payment-status');

Route::post('/specialist/update-payment-status', 'AdminApp\SpecialistPaymentController@updatePaymentStatus')->name('specialist-update-payment-status');

Route::get('/specialist/{id}/unpaid-payment-detail','AdminApp\SpecialistPaymentController@unpaidPaymentDetail')->name('specialist-unpaid-payment-detail');

Route::get('/specialist/payment-status-update', 'AdminApp\SpecialistPaymentController@paymentStatusUpdate')->name('specialist-payment-status-update');

Route::get('/specialist/{id}/paid-payment-detail','AdminApp\SpecialistPaymentController@paidPaymentDetail')->name('specialist-paid-payment-detail');

Route::get('/rate-setting/{type}', 'AdminApp\RateSettingController@rateSetting')->name('rate-setting');

Route::post('/rate-setting-update', 'AdminApp\RateSettingController@updateRateSetting')->name('rate-setting-update');

Route::get('/bouns-rating', 'AdminApp\RateSettingController@bounsRatingSetting')->name('bouns-rating-setting');

Route::post('/bouns-rate', 'AdminApp\RateSettingController@updateBounsRating')->name('update-bouns-rating-setting');

Route::get('/success-rate-setting', 'AdminApp\RateSettingController@successRateSetting')->name('success-rate-setting');

Route::post('/update-success-rate', 'AdminApp\RateSettingController@updateSuccessRateSetting')->name('update-success-rate-setting');