<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeStatusLog extends Model
{

	protected $primaryKey = 'id';

    //
    protected $fillable = [
                  'user_id',
                  'user_type',
                  'status',
                  'application_id'
              ];
}
