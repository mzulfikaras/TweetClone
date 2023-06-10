<?php

namespace App\Repositories\Auth;

use App\Services\GoogleService;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    protected $googleService;

    public function __construct(GoogleService $googleService)
    {
        $this->googleService = $googleService;
    }

    public function googleAuthRedirect($provider)
    {
        if ($provider != null) {
            $res = $this->googleService->redirectLinkToProvider($provider);
        }

        return $res;
    }

    public function loginOrRegisterGoogle($provider)
    {
        $userGoogle = $this->googleService->handleProvideCallback($provider);
        $findUser = User::where('provider_id', $userGoogle->id)->first();

        if (!$findUser) {
            $data = User::create([
                'name' => $userGoogle->name,
                'email' => $userGoogle->email,
                'provider_id'=> $userGoogle->id,
                'provider_name' => $provider,
                'password' => Hash::make(Str::random(8))
            ]);

            Auth::login($data);
            $token = $data->createToken('TweetClone')->accessToken;
            return $token;
        } else {
            Auth::login($findUser);
            $token = $findUser->createToken('TweetClone')->accessToken;
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            $token = Auth::user()->token();
            return $token->revoke();
        }
    }
}
