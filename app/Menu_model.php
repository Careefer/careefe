<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu_model extends Model
{
	protected $table     = 'menues';
	protected $fillable  = ['name','permission_name','parent','url','status','sort'];
	protected $timestamp = true;
}
