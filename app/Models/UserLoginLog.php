<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
	protected $table = 'user_login_log';

    protected $fillable = [
                  'user_id',
                  'user_type',
              ];
}
