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
    public function sendPushNotification($message)
    {

        if (!$this->device_token) {
            return;
        }

        $system = 'Android';
        if (strlen($this->device_token) == 64) {
            $system = 'iOS';
        }

        \PushNotification::app($system)
            ->to($this->device_token)
            ->send($message);
    }

    public static function sendPushNotificationToMultipleUsers($users, $message)
    {
        $device_tokens_ios = [];
        $device_tokens_android = [];

        foreach ($users as $user) {
            if ($user->device_token) {
                if (strlen($user->device_token) == 64) {
                    $device_tokens_ios[] = \PushNotification::Device($user->device_token, array('badge' => 1));
                } else {
                    $device_tokens_android[] = \PushNotification::Device($user->device_token);
                }
            }
        }

        if (count($device_tokens_android) > 0) {
            $devices_android = \PushNotification::DeviceCollection($device_tokens_android);
            \PushNotification::app('Android')
                ->to($devices_android)
                ->send($message);
        }

        if (count($device_tokens_ios) > 0) {
            $devices_ios = \PushNotification::DeviceCollection($device_tokens_ios);
            $push = \PushNotification::app('iOS')
                ->to($devices_ios)
                ->send($message);

            ob_start();
            var_dump($push->getFeedback());
            $contents = ob_get_contents();
            ob_end_clean();
            error_log($contents);

        }

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

    public function sendEmail($subject, $body)
    {
        $user = $this;
        \Mail::raw($body, function ($m) use ($user, $subject) {
            $m->from('noreply@greenplatform.org', 'GreenPlatform');
            $m->to($user->email);
            $m->subject($subject);
        });
    }

}
