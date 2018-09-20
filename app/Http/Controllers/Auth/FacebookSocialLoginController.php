<?php

namespace App\Http\Controllers;

use Auth;
use Socialite;
use App\User;
//()
class FacebookSocialLoginController extends Controller
{
    public function redirectToProvider()
    {
      return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
      // user returned by the provider
      $user = Socialite::driver('facebook')->user();

      // find or create user
      $authUser = User::where('provider_id', $user->id)->first();
      if(!$authUser) {
        $authUser = User::create([
          'name' => $user->name,
          'email' => $user->email,
          'provider' => 'facebook',
          'provider_id' => $user->id,
        ]);
      }

      Auth::login($authUser);
      return redirect()->route('home');
    }
}
