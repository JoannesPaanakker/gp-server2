<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;

class HomeController extends Controller {

   // public function __construct(){
   //  $this->middleware('auth');
   // }

	public function index() {
		return view('home');
	}

  public static function dflt() {
    $pages = Page::all();
    foreach ($pages as $page) {
      if(is_null($page->user_id)) {
        $page->user_id = 1;
      }
      if(is_null($page->about)) {
        $page->about = 'About ' . $page->title . '.';
      }
      if(is_null($page->rating)) {
        $page->rating = 1;
      }
      if(is_null($page->quiz_score)) {
        $page->quiz_score = 0;
      }
      if(is_null($page->categories)) {
        $page->categories = 'new, greenplaform';
      }
      $page->save();
    }
  }
}
