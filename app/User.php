<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name' ,'last_name' , 'phone', 'email', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //default value for the atribute
    protected $attributes = array(
        'image_url' => 'NULL'
    );

    /**
     * Get the announcements for the user.
     *
     * $announcements = App\Post::find(1)->announcements;
     * foreach ($announcements as $announcement) {
     *     echo $announcement->name;
     *}
    }
     */
    public function announcements()
    {
        return $this->hasMany('App\Announcement');
    }


}
