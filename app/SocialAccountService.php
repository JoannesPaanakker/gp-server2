<?php

namespace App;
use File; 
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $user = User::whereProvider('facebook')
            ->whereProviderId($providerUser->getId())
            ->first();

        if ($user) {
            $fileContents = file_get_contents($providerUser->getAvatar());
            File::put(public_path() . '/profile-images/' . $user->id . ".jpg", $fileContents);
            return $user;
        } else {
          $user = User::whereEmail($providerUser->getEmail())->first();
          if ($user) {
            $user = 'bestaat al' ;
            return $user;
          } else {
            $user = new User;
            $user->last_name = $providerUser->getName();
            $user->provider = 'facebook';
            $user->provider_id = $providerUser->getId();
            $user->email = $providerUser->getEmail();
            $user->save();
            $fileContents = file_get_contents($providerUser->getAvatar());
            $user = User::whereProvider('facebook')
            ->whereProviderId($providerUser->getId())
            ->first();
            File::put(public_path() . '/profile-images/' . $user->id . ".jpg", $fileContents);
            $user->picture = '/profile-images/' . $user->id . '.jpg';
            $user->save();
            return $user;
          }
        }

    }
}
