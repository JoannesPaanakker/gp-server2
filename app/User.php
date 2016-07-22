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

}
