<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = [
        'google_place_id',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    public function getThumb()
    {
        if (count($this->photos) > 0) {
            return env('APP_URL') . '/photos/' . $this->photos[0]->id . '_thumb.jpg';
        } else {
            return env('APP_URL') . '/photos/default_page.jpg';
        }
    }

    public function getImages()
    {
        $images = [];
        if (count($this->photos) > 0) {
            foreach ($this->photos as $photo) {
                $images[] = ['url' => env('APP_URL') . '/photos/' . $photo->id . '.jpg', 'id' => $photo->id, 'date' => date('d/m/Y', strtotime($photo->created_at))];
            }
        } else {
            $images[] = ['url' => env('APP_URL') . '/photos/default_page.jpg', 'id' => 0];
        }
        return $images;
    }

    public function followed()
    {
        return $this->belongsToMany(User::class, 'follows')->withTimestamps();
    }

    public function updateRating()
    {
        $reviews = $this->reviews;
        $totalRating = 0;
        $numReviews = count($reviews);
        foreach ($reviews as $review) {
            $reviewRating = ceil(($review->rating_1 + $review->rating_2 + $review->rating_3 + $review->rating_4) / 4);
            $totalRating += $reviewRating;
        }
        $totalRating = $totalRating / $numReviews;
        $this->rating = $totalRating;
        $this->save();
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

}
