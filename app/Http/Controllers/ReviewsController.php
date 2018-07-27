<?php

namespace App\Http\Controllers;

use App\Page;
use App\Photo;
use App\Review;
use App\Update;
use App\User;
use Illuminate\Http\Request;
use Image;

class ReviewsController extends Controller {

	public function index() {
		$reviews = Review::with('photos')->with('page')->get();
		foreach ($reviews as $index => $review) {
			$reviews[$index]->place = $review->page->title;
			$reviews[$index]->page->thumb = $reviews[$index]->page->getThumb();
		}
		return $reviews;
	}

	public function show(Review $review) {
		$review->date = date('d/m/Y', strtotime($review->created_at));
		$review->photos = $review->photos()->get();
		$review->pictures = $review->getImages();
		$review->thumb = $review->getThumb();
		$review->user = $review->user()->get();
		$review->page = $review->page()->get();
		return $review;
	}

	public function update(Review $review) {
		$request = request()->all();
		$review->title = $request['title'];
		$review->content = $request['content'];

		$review->rating_0 = $request['rating_0'];
		$review->rating_1 = $request['rating_1'];
		$review->rating_2 = $request['rating_2'];
		$review->rating_3 = $request['rating_3'];

		$review->prize_thumb = $request['prize_thumb'];

		$review->save();

		// update page rating
		$page = $review->page;
		$page->updateRating();

		// update page prize thumbs count
		$page->updateThumbs();

		return response()->json(['status' => 'success']);
	}

	public function delete(Review $review) {
		$review->delete();
		return response()->json(['status' => 'success']);
	}

	public function userReviews(User $user) {
		//$reviews = $user->reviews()->with('photos')->get();
		$reviews = $user->reviews()->join('pages as page', 'reviews.page_id', '=', 'page.id')
   		->orderBy('page.title')
   		->select('reviews.*')->with('page')->get();

		foreach ($reviews as $index => $review) {
			$reviews[$index]->user = $user;
			$reviews[$index]->thumb = $review->getThumb();
			$reviews[$index]->place = '';
			if (count($review->page)) {
				$reviews[$index]->page->thumb = $review->page->getThumb();
				$reviews[$index]->place = $review->page->title;
			}
		}

		return $reviews;
	}

	public function pageReviews(Page $page) {
		$reviews = $page->reviews()->with('photos', 'user')->get();
		foreach ($reviews as $index => $review) {
			$reviews[$index]->thumb = $review->getThumb();
			$reviews[$index]->place = '';
			if (count($review->page)) {
				$reviews[$index]->place = $review->page->title;
			}
		}
		return $reviews;
	}

  public function store(User $user) {
    $request = request()->all();
    $page = Page::find($request['page_id']);

    error_log(print_r($request, 1));

    $review = new Review;
    $review->title = $request['title'];
    $review->content = $request['content'];
    $review->rating_0 = $request['rating_0'];
    $review->rating_1 = $request['rating_1'];
    $review->rating_2 = $request['rating_2'];
    $review->rating_3 = $request['rating_3'];


    $review->prize_thumb = $request['prize_thumb'];

    $user->reviews()->save($review);
    $page->reviews()->save($review);

    // update page rating
    $page = $review->page;
    $page->updateRating();

    // update page prize thumbs count
    $page->updateThumbs();

    // upload the review photo
    $photo = request()->file('photo');
    if (!is_null($photo)) {
      $destinationPath = public_path() . '/reviews-photos/';
      $path = $review->id . '-orig.jpg';
      if ($photo->move($destinationPath, $path)) {
        Image::make($destinationPath . $review->id . '-orig.jpg')->fit(500, 500)->save($destinationPath . $review->id . '.jpg');
        $review->picture = url('/reviews-photos') . '/' . $review->id . '.jpg';
        $review->save();
      }
    }

    // post update
    $update = new Update;
    $update->user_id = $user->id;
    $update->content = 'Posted a review';
    $update->kind = 'create-review';
    $update->entity_id = $page->id;
    $update->entity_name = $page->title;
    $update->save();
    if(!$user->following_pages->contains($page)){
      $user->following_pages()->save($page);
    }

    // send a push notification to followers
    $message = $user->first_name . ' ' . $user->last_name . ' has reviewed ' . $page->title;
    User::sendPushNotificationToMultipleUsers($user->followed_by, $message);

    return response()->json(['status' => 'success', 'review_id' => $review->id, 'page_name' => $page->title, 'page_id' => $page->id]);

  }

  public function storeB(User $user) {
    $request = request()->all();
    $page = Page::find($request['page_id']);

    error_log(print_r($request, 1));

    $review = new Review;
    $review->title = $request['title'];
    $review->content = $request['content'];
    $review->rating_0 = $request['rating_0'];
    $review->rating_1 = $request['rating_1'];
    $review->rating_2 = $request['rating_2'];
    $review->rating_3 = $request['rating_3'];


    $prize_num = $request['prize_num'];
    if ( $prize_num == 1) {
     $review->prize_thumb = "up";
    } else {
     $review->prize_thumb = "down";
    }

    $user->reviews()->save($review);
    $page->reviews()->save($review);

    // update page rating
    $page = $review->page;
    $page->updateRating();

    // update page prize thumbs count
    $page->updateThumbs();

    // upload the review photo
    if (isset($request['photo'])) {
      $request['photo']->move('reviews-photos', $review->id . '-orig.jpg');
      // generate thumbs
      Image::make('reviews-photos/' . $review->id . '-orig.jpg')->fit(500, 500)->save('reviews-photos/' . $review->id . '.jpg');
      $review->picture = '/reviews-photos/' . $review->id . '.jpg';
      $review->save();
    }

    // post update
    $update = new Update;
    $update->page_id = $page->id;
    $update->user_id = $user->id;
    $update->content = 'Posted a review';
    $update->kind = 'create-review';
    $update->entity_id = $page->id;
    $update->entity_name = $page->title;
    $update->save();
    if(!$user->following_pages->contains($page)){
      $user->following_pages()->save($page);
    }

    // send a push notification to followers
    $message = $user->first_name . ' ' . $user->last_name . ' has reviewed ' . $page->title;
    User::sendPushNotificationToMultipleUsers($user->followed_by, $message);

    // return response()->json(['status' => 'success', 'review_id' => $review->id, 'page_name' => $page->title, 'page_id' => $page->id]);
    return back()->withInput();
    }

	public function addImage(Review $review) {

		$request = request()->all();

		// create the photo record
		$photo = new Photo;
		$photo->review_id = $review->id;
		$photo->save();

		// upload photo and generate thumbs
		if (isset($request['file'])) {
			$request['file']->move('photos', $photo->id . '.jpg');
			// generate thumbs
			Image::make('photos/' . $photo->id . '.jpg')->fit(1000, 1000)->save('photos/' . $photo->id . '.jpg')->fit(160, 160)->save('photos/' . $photo->id . '_thumb.jpg');
		}

		return response()->json(['status' => 'success']);

	}

}
