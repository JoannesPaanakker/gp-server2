<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Review;
use App\User;
use App\Page;
use Image;

class ReviewsController extends Controller
{

    public function index(){    	
    	$reviews = Review::all();
    	foreach($reviews as $index => $review){
            $reviews[$index]->thumb = env('APP_URL') . '/files/reviews/' . $review->id . '/thumb.jpg';
            $reviews[$index]->picture = env('APP_URL') . '/files/reviews/' . $review->id . '/image.jpg';
            $reviews[$index]->place = $review->page->title;
        }
    	return $reviews;
    }

    public function show(Review $review){
        $review->thumb = env('APP_URL') . '/files/reviews/' . $review->id . '/thumb.jpg';
        $review->picture = env('APP_URL') . '/files/reviews/' . $review->id . '/image.jpg';
    	return $review;
    }

    public function userReviews(User $user){
        $reviews = $user->reviews()->get();
        foreach($reviews as $index => $review){
            $reviews[$index]->thumb = env('APP_URL') . '/files/reviews/' . $review->id . '/thumb.jpg';
            $reviews[$index]->picture = env('APP_URL') . '/files/reviews/' . $review->id . '/image.jpg';
            $reviews[$index]->place = $review->page->title;
        }
        return $reviews;
    }

    public function pageReviews(Page $page){
    	$reviews = $page->reviews()->get();
    	foreach($reviews as $index => $review){
            $reviews[$index]->thumb = env('APP_URL') . '/files/reviews/' . $review->id . '/thumb.jpg';
            $reviews[$index]->picture = env('APP_URL') . '/files/reviews/' . $review->id . '/image.jpg';
        }
        return $reviews;
    }


    public function store(User $user){
        $request = request()->all();
        $page = Page::find($request['page_id']);
        
        error_log(print_r($request,1));

        $review = new Review;
        $review->title = $request['title'];
        $review->content = $request['content'];
        $review->rating = $request['rating'];
        
        $user->reviews()->save($review);
        $page->reviews()->save($review);

        // upload photo and generate thumbs
        if(isset($request['file'])){
            $request['file']->move('files/reviews/' . $review->id, 'image.jpg');
            Image::make('files/reviews/' . $review->id . '/image.jpg')->fit(1000,1000)->save('files/reviews/' . $review->id . '/image.jpg')->fit(160,160)->save('files/reviews/' . $review->id . '/thumb.jpg');
        }

        
    }

}
