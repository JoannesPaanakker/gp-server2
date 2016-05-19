<?php

namespace App\Http\Controllers;

use App\User;
use App\Page;
use App\Review;
use Image;
use App\Photo;

class PagesController extends Controller
{

    public function index(){
    	$pages = Page::with('photos')->get();
        foreach($pages as $index => $page){
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
    	return $pages;
    }

    // it gets all places nearby and marks the ones with pages created
    public function getPagesAndPlacesNearby($coordinates){
        $api_key = env('GOOGLE_API');
        $type = 'restaurant';
        $radius = '200'; //metres
        $rankby = '';
        $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . $api_key . '&location=' . $coordinates . '&radius=' . $radius . '&type=' . $type . '&rankby=' . $rankby;
        
        $places_nearby = json_decode(file_get_contents($google_places_url));
        
        $places_list = [];
        $nearby_ids = [];
        foreach($places_nearby->results as $place){
            $nearby_ids[] = "'" . $place->place_id . "'";
            $places_list[] = [
                'title' => $place->name,
                'address' => $place->vicinity,
                'place_id' => $place->place_id,
                'about' => '',
                'rating' => '0',
                'lat' => $place->geometry->location->lat,
                'lng' => $place->geometry->location->lng,
                'withpage' => 'no'
            ];
        }

        if(count($nearby_ids) <= 0){
            return [];
        }

        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) .')')->get();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->num_reviews = $page->reviews()->count();
            $pages[$index]->withpage = 'yes';
            $places_list[] = $pages[$index];
        }

        return $places_list;
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
            $nearby_ids[] = "'" . $place->place_id . "'";
        }
        if(count($nearby_ids) <= 0){
            return [];
        }

        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) .')')->get();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->num_reviews = $page->reviews()->count();
        }

        return $pages;
    }

    public function search($query){
        error_log('searching');
        $pages = Page::with('photos')->where('title', 'LIKE', '%' . $query . '%')->take(10)->get();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = $page->getThumb();
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
        return $pages;
    }

    // gets all places without pages around the user
    public function getPlacesNearBy($coordinates){
        
        $api_key = env('GOOGLE_API');
        $type = 'restaurant';
        $radius = '200'; //metres
        $rankby = '';

        // get places nearby from google
        $google_places_url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=' . $api_key . '&location=' . $coordinates . '&radius=' . $radius . '&type=' . $type . '&rankby=' . $rankby;
        
        $places_nearby = json_decode(file_get_contents($google_places_url));
        
        // build query using these ids
        $nearby_ids = [];
        foreach($places_nearby->results as $place){
            $nearby_ids[] = "'" . $place->place_id . "'";
        }

        if(count($nearby_ids) <= 0){
            return [];
        }

        $nearby_pages = [];

        // get nearby pages
        $pages = Page::whereRaw('google_place_id IN (' . implode(',', $nearby_ids) .')')->get();
        foreach($pages as $index => $page){
            $nearby_pages[] = $page->google_place_id;
        }

        // exclude those pages from places
        $places_nearby_without_pages = [];
        foreach($places_nearby->results as $place){
            if(!in_array($place->place_id, $nearby_pages)){
                $places_nearby_without_pages[] = $place;
            }
        }

        return $places_nearby_without_pages;
    }

    public function show(Page $page){
        $page->photos = $page->photos()->get();
        $page->pictures = $page->getImages();
        $page->thumb = $page->getThumb();
        $page->user = $page->user()->get();
        $page->num_reviews = $page->reviews()->count();
        return $page;
    }

    public function update(Page $page){
        $request = request()->all();
        $page->about = $request['about'];
        $page->save();
        return response()->json(['status' => 'success']);
    }

    public function delete(Page $page){
        $page->delete();
        return response()->json(['status' => 'success']);
    }


    public function userPages(User $user){
		$pages = $user->pages()->with('photos')->get();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = $page->getThumb();
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

        error_log('store page');
        error_log(print_r($request, true));

        // get info for the place
        $place = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $request['google_place_id'] . '&key=' . env('GOOGLE_API')));
        
        $page = Page::firstOrNew(['google_place_id' => $place->result->place_id]);

    	$page->title = $place->result->name;
    	$page->address = $place->result->formatted_address;
    	$page->rating = $request['rating'];
        $page->about = $request['about'];
        $page->lat = $place->result->geometry->location->lat;
        $page->lng = $place->result->geometry->location->lng;
    	$page->google_place_id = $place->result->place_id;
    	$user->pages()->save($page);

        return response()->json(['status' => 'success', 'page_id' => $page->id]);

    }


    public function addImage(Page $page){

        $request = request()->all();

        // upload photo and generate thumbs
        if(isset($request['file'])){
            $request['file']->move('files/pages/' . $page->id, 'image.jpg');
            // generate thumbs
            Image::make('files/pages/' . $page->id . '/image.jpg')->fit(1000,1000)->save('files/pages/' . $page->id . '/image.jpg')->fit(160,160)->save('files/pages/' . $page->id . '/thumb.jpg');
        }
        
        /*
        #
        #   Nativescript Image uploading..
        #
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
        
        @mkdir('files/pages/' .  $page->id);

        // write image from raw post to file
        file_put_contents('files/pages/' . $page->id . '/image.' . $extension, $request_body);
    
        //$request['file']->move('files/pages/' . $page->id, 'image.jpg');
        // generate thumbs
        Image::make('files/pages/' . $page->id . '/image.' . $extension)->fit(1000,1000)->save('files/pages/' . $page->id . '/image.jpg')->fit(160,160)->save('files/pages/' . $page->id . '/thumb.jpg');
        */

        return response()->json(['status' => 'success']);

    }


}
