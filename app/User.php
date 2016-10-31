<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // sends a push notification to the user
    public function push($message)
    {

        $system = 'Android';
        if (strlen($this->device_token) == 64) {
            $system = 'iOS';
        }

        \PushNotification::app($system)
            ->to($this->device_token)
            ->send($message);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }

    public function following_pages()
    {
        return $this->belongsToMany(Page::class, 'follows')->withTimestamps();
    }

    public function following_users()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followed_by()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id')->withTimestamps();
    }

}
