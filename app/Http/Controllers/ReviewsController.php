<?php

namespace App\Http\Controllers;

use App\Page;
use App\Photo;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Image;

class ReviewsController extends Controller {

	public function index() {
		$reviews = Review::with('photos')->get();
		foreach ($reviews as $index => $review) {
			$reviews[$index]->place = $review->page->title;
		}
		return $reviews;
	}

	public function show(Review $review) {
		$review->date = date('d/m/Y', strtotime($review->created_at));
		$review->photos = $review->photos()->get();
		$review->pictures = $review->getImages();
		$review->thumb = $review->getThumb();
		$review->user = $review->user()->get();
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

		$review->save();

		// update page rating
		$page = $review->page;
		$page->updateRating();

		return response()->json(['status' => 'success']);
	}

	public function delete(Review $review) {
		$review->delete();
		return response()->json(['status' => 'success']);
	}

	public function userReviews(User $user) {
		$reviews = $user->reviews()->with('photos')->get();
		foreach ($reviews as $index => $review) {
			$reviews[$index]->thumb = $review->getThumb();
			$reviews[$index]->place = '';
			if (count($review->page)) {
				$reviews[$index]->place = $review->page->title;
			}

		}
		return $reviews;
	}

	public function pageReviews(Page $page) {
		$reviews = $page->reviews()->with('photos')->get();
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

		$user->reviews()->save($review);
		$page->reviews()->save($review);

		return response()->json(['status' => 'success', 'review_id' => $review->id]);

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
