<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralPaymentHistoryLog extends Model
{
    protected $table = 'referral_payment_history_log';
    public $fillable = ['payment_history_id','rating_by_referee', 'successful','unsuccessful','total_referred','success_rate','expected_success_rate','penalty','penalty_x_total_referred'];
}
