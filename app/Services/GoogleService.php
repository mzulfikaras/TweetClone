<?php

namespace App\Services;
use Laravel\Socialite\Facades\Socialite;

class GoogleService
{
    public function redirectLinkToProvider($provider)
    {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }

    public function handleProvideCallback($provider)
    {
        return Socialite::driver($provider)->stateless()->user();
    }

    public function logout()
    {

    }
}
