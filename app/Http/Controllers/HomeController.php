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

  public function testPage($id) {
    $page = Page::where("id", $id)->first();
    return view('testpage', compact('page'));
  }

  public static function testPage2() {
    return view('testpage2', compact('user'));
  }

}
