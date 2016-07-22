<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImage()
    {
        return env('APP_URL') . '/photos_updates/' . $this->id . '.jpg';
    }
}
