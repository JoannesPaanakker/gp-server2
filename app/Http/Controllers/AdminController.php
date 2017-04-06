<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;

class AdminController extends Controller {

	function __construct() {
		\Httpauth::secure();
	}

	public function index() {
		$users = User::all();
		return view('admin.users', compact('users'));
	}

	public function companies($order = 'title') {
		if ($order == 'reviews') {
			$companies = Page::all()->sortByDesc(function ($company) {
				return $company->reviews->count();
			});
		} else {
			$companies = Page::orderBy($order)->get();
		}

		return view('admin.companies', compact('companies', 'order'));
	}

}
