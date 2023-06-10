<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Auth\AuthRepository;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function googleAuthRedirect($provider = null)
    {
        try {
            $data = $this->authRepository->googleAuthRedirect($provider);

            return response()->json([
                "success" => true,
                "message" => "Succesfully get Data",
                "data"    => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
                "data"    => null
            ]);
        }
    }

    public function loginRegisterGoogle($provider = null)
    {
        try {
            $data = $this->authRepository->loginOrRegisterGoogle($provider);

            return response()->json([
                "success" => true,
                "message" => "Succesfully login",
                "token"   => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        try {
            $this->authRepository->logout();
            return response()->json([
                "success" => true,
                "message" => "Succesfully logout"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }
}
