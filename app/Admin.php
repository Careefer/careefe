<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role as Role;
use App\Model_has_roles as Model_has_roles;



class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function role()
    {   
        return $this->hasOneThrough(
                                    Role::class, // final table what data you want
                                    Model_has_roles::class, // intermediate table
                                    'model_id', // intermeditate ID 
                                    'id', // role table id
                                    'id', // admin table id
                                    'role_id' // intermediate table(model_has_role) role_id
                                    );
    }
}
