<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageConversation extends Model
{
    protected $table = 'message_conversations';

    protected $fillable = [
                  'room_id',
                  'sender_id',
                  'sender_type',
                  'receiver_id',
                  'receiver_type',
                  'message'
              ];


    public function candidate()
    {   
        return $this->belongsTo('App\Candidate','sender_id');
    }

    public function specialist()
    {
        return $this->belongsTo("App\Specialist",'sender_id');
    }

    
}
