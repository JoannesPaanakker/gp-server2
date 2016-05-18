<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Review;
use App\User;
use App\Page;
use Image;
use App\Photo;

class ReviewsController extends Controller
{

    public function index(){    	
    	$reviews = Review::with('photos')->get();
        foreach($reviews as $index => $review){
            $reviews[$index]->place = $review->page->title;
        }
        return $reviews;
    }

    public function show(Review $review){
        $review->date = date('d/m/Y', strtotime($review->created_at));
        $review->photos = $review->photos()->get();
        $review->pictures = $review->getImages();
        $review->thumb = $review->getThumb();
        $review->user = $review->user()->get();
    	return $review;
    }

    public function update(Review $review){
        $request = request()->all();
        $review->title = $request['title'];
        $review->content = $request['content'];
        $review->rating = $request['rating'];
        $review->save();
        return response()->json(['status' => 'success']);
    }

    public function delete(Review $review){
        $review->delete();
        return response()->json(['status' => 'success']);
    }

    public function userReviews(User $user){
        $reviews = $user->reviews()->with('photos')->get();
        foreach($reviews as $index => $review){
            $reviews[$index]->thumb = $review->getThumb();
            $reviews[$index]->place = $review->page->title;
        }
        return $reviews;
    }

    public function pageReviews(Page $page){
    	$reviews = $page->reviews()->with('photos')->get();
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

        return response()->json(['status' => 'success', 'review_id' => $review->id]);

    }


    public function addImage(Review $review){
        
        $request = request()->all();

        // create the photo record
        $photo = new Photo;
        $photo->review_id = $review->id;
        $photo->save();

        // upload photo and generate thumbs
        if(isset($request['file'])){
            $request['file']->move('photos', $photo->id . '.jpg');
            // generate thumbs
            Image::make('photos/' . $photo->id . '.jpg')->fit(1000, 1000)->save('photos/' . $photo->id . '.jpg')->fit(160,160)->save('photos/' . $photo->id . '_thumb.jpg');
        }

        /*
        ### Nativescript image uploading
        
        $request_body = @file_get_contents('php://input');

        // Get some information on the file
        $file_info = new \finfo(FILEINFO_MIME);

        // Extract the mime type
        $mime_type = $file_info->buffer($request_body);

        error_log('post received:');
        error_log($mime_type);
        error_log('headers:');
        
        $headers = getallheaders();
        foreach (getallheaders() as $name => $value) {
            error_log($name . ' : ' . $value);
        }

        if(strstr($mime_type, 'image/png')){
            $extension = 'png';
        }elseif(strstr($mime_type, 'image/jpeg')){
            $extension = 'jpg';
        }else{
            error_log('mime not valid');
            return;
        }
        
        @mkdir('files/reviews/' .  $review->id);

        // write image from raw post to file
        file_put_contents('files/reviews/' . $review->id . '/image.' . $extension, $request_body);
    
        //$request['file']->move('files/reviews/' . $review->id, 'image.jpg');
        // generate thumbs
        Image::make('files/reviews/' . $review->id . '/image.' . $extension)->fit(1000,1000)->save('files/reviews/' . $review->id . '/image.jpg')->fit(160,160)->save('files/reviews/' . $review->id . '/thumb.jpg');
    
        */
       
         return response()->json(['status' => 'success']);

    }

}
