<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TweetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/unauthenticated', function () {
    return response()->json(['message' => 'Unauthenticated.'], 403);
});

Route::group(['prefix' => 'auth'], function() {
    Route::get('/{provider}', [AuthController::class, 'googleAuthRedirect']);
    Route::get('/{provider}/loginOrRegister', [AuthController::class, 'loginRegisterGoogle']);
});

Route::group(['prefix' => 'tweet', 'middleware' => ['auth:api']], function() {
    Route::get('/logout', [AuthController::class, 'logout']);


    Route::get('/', [TweetController::class, 'index']);
    Route::post('/', [TweetController::class, 'store']);
    Route::delete('/{id}', [TweetController::class, 'destroy']);
});
