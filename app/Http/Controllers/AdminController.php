<?php

namespace App\Http\Controllers;

use App\User;

class AdminController extends Controller
{

    public function index()
    {
        \Httpauth::secure();
        $users = User::all();
        return view('admin.users', compact('users'));
    }

}
