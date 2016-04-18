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
            $pages[$index]->thumb = env('APP_URL') . '/files/pages/' . $page->id . '/thumb.jpg';
            $pages[$index]->picture = env('APP_URL') . '/files/pages/' . $page->id . '/image.jpg';
            $pages[$index]->num_reviews = $page->reviews()->count();
        }
    	return $pages;
    }

    public function show(Page $page){
        $page->thumb = env('APP_URL') . '/files/pages/' . $page->id . '/thumb.jpg';
        $page->picture = env('APP_URL') . '/files/pages/' . $page->id . '/image.jpg';
        $page->num_reviews = $page->reviews()->count();
        return $page;
    }

    public function userPages(User $user){
		$pages = $user->pages()->get();
        foreach($pages as $index => $page){
            $pages[$index]->thumb = env('APP_URL') . '/files/pages/' . $page->id . '/thumb.jpg';
            $pages[$index]->picture = env('APP_URL') . '/files/pages/' . $page->id . '/image.jpg';
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
    	error_log(print_r($request,1));

    	$page = new Page;
    	$page->title = $request['name'];
    	$page->address = $request['address'];
    	$page->rating = $request['rating'];
        $page->about = $request['about'];
        $page->lat = $request['lat'];
        $page->lng = $request['lng'];
    	$page->google_place_id = $request['place_id'];
    	$user->pages()->save($page);

    	// upload photo and generate thumbs
    	if(isset($request['file'])){
			$request['file']->move('files/pages/' . $page->id, 'image.jpg');
            // generate thumbs
            Image::make('files/pages/' . $page->id . '/image.jpg')->fit(1000,1000)->save('files/pages/' . $page->id . '/image.jpg')->fit(160,160)->save('files/pages/' . $page->id . '/thumb.jpg');
		}
        
    }

}
