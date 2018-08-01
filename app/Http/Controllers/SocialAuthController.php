<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
  public function faceBookRedirect(){
    return Socialite::driver('facebook')->redirect();
  }

 // public function callback(SocialAccountService $service)
  public function facebookCallback(SocialAccountService $service)
  {
      $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
      if ($user == 'bestaat al') {
        request()->session()->flash('alert-danger', 'account exists as other with this email');
        return back()->withInput();
      } else {
        auth()->login($user);
        return redirect()->route('user', [$user]);
      } 
  }
}
