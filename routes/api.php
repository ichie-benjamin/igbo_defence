<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FeedsController;
use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1/'], function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('delete/account', [AuthController::class, 'delete']);
        Route::post('register', [AuthController::class, 'register']);

        Route::post('user', [AuthController::class, 'user']);
        Route::post('change/password', [AuthController::class, 'changePassword']);

        Route::post('update/online', [AuthController::class, 'setOnline']);

        Route::post('resend/otp', [AuthController::class, 'resendOTP']);

        Route::post('user/update', [AuthController::class, 'update']);

        Route::post('verify/phone', [AuthController::class, 'verifyPhone']);

        Route::post('forgot/pass', [AuthController::class, 'forgotPass']);
        Route::post('check/phone', [AuthController::class, 'checkPhone']);
        Route::post('user/update_token', [AuthController::class, 'updateToken']);
        Route::post('forgot/pass/verify', [AuthController::class, 'verifyResetCode']);
        Route::post('reset/pass', [AuthController::class, 'resetPass']);
        Route::post('send/email/verify', [AuthController::class, 'sendVerifyEmail']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('toggle/like', [FeedsController::class, 'toggleLike']);
    });



    Route::get('feeds', [FeedsController::class, 'feeds']);
    Route::get('feeds/all', [FeedsController::class, 'feedsAll']);
    Route::get('feeds/all', [FeedsController::class, 'feedsAll']);
    Route::get('feeds/shorts', [FeedsController::class, 'shorts']);
    Route::get('feeds/videos', [FeedsController::class, 'videos']);
    Route::get('lives', [FeedsController::class, 'lives']);

    Route::post('increase/view', [FeedsController::class, 'increaseView']);
    Route::post('shorts/increase/view', [FeedsController::class, 'increaseShortsView']);
    Route::post('videos/increase/view', [FeedsController::class, 'increaseVideoView']);



    Route::get('/', [MainController::class, 'index']);
    Route::get('/admin/add/site', [MainController::class, 'addSite'])->name('add.site');

    Route::post('/check-domain', [MainController::class, 'checkSite'])->name('check.site');
});
