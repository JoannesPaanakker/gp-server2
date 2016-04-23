<?php

namespace App\Http\Controllers;

use App\User;
use App\Page;
use App\Review;
use Image;

class PagesController extends Controller
{

    public function index(){
    	$pages = Page::all();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->picture = $page->getImage();
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
    	return $pages;
    }

    // gets all the pages around the user
    public function getPagesNearBy($coordinates){
        
        $api_key = env('GOOGLE_API');
        $type = 'restaurant';
        $radius = '200'; //metres
        $rankby = '';
        $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . $api_key . '&location=' . $coordinates . '&radius=' . $radius . '&type=' . $type . '&rankby=' . $rankby;
        
        $places_nearby = json_decode(file_get_contents($google_places_url));
        
        $nearby_ids = [];
        foreach($places_nearby->results as $place){
            $nearby_ids[] = "'" . $place->id . "'";
        }

        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) .')')->get();
        foreach($pages as $index => $page){
            $pages[$index]->num_reviews = $page->reviews()->count();
        }

        return $pages;
    }

    // gets all places arount the user
    public function getPlacesNearBy($coordinates){
        
        $api_key = env('GOOGLE_API');
        $type = 'restaurant';
        $radius = '200'; //metres
        $rankby = '';
        $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . $api_key . '&location=' . $coordinates . '&radius=' . $radius . '&type=' . $type . '&rankby=' . $rankby;
        
        $places_nearby = json_decode(file_get_contents($google_places_url));
        
        return $places_nearby->results;
    }

    public function show(Page $page){
        $page->thumb = $page->getThumb();
        $page->picture = $page->getImage();
        $page->num_reviews = $page->reviews()->count();
        return $page;
    }

    public function userPages(User $user){
		$pages = $user->pages()->get();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->picture = $page->getImage();
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
        return $pages;
    }

    public function getById(){
        $request = request()->all();
        //error_log(print_r($request,1));
        $requested_ids = [];
        foreach($request as $request){
            $requested_ids[] = "'".$request['id']."'";
        }
        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $requested_ids) .')')->get();
        foreach($pages as $index => $page){
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
        return $pages;
    }

    public function store(User $user){

    	$request = request()->all();

        $entityBody = file_get_contents('php://input');
        
    	error_log(print_r($entityBody,1));

        // get info for the place
        $place = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $request['google_place_id'] . '&key=' . env('GOOGLE_API')));
        $place->result->formatted_address;

    	$page = new Page;
    	$page->title = $place->result->name;
    	$page->address = $place->result->formatted_address;
    	$page->rating = $request['rating'];
        $page->about = $request['about'];
        $page->lat = $place->result->geometry->location->lat;
        $page->lng = $place->result->geometry->location->lng;
    	$page->google_place_id = $place->result->id;
    	$user->pages()->save($page);

    	// upload photo and generate thumbs
    	if(isset($request['file'])){
			$request['file']->move('files/pages/' . $page->id, 'image.jpg');
            // generate thumbs
            Image::make('files/pages/' . $page->id . '/image.jpg')->fit(1000,1000)->save('files/pages/' . $page->id . '/image.jpg')->fit(160,160)->save('files/pages/' . $page->id . '/thumb.jpg');
		}
        
    }

}
