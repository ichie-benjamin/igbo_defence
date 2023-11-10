<?php

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

    Route::get('feeds', [FeedsController::class, 'feeds']);
    Route::get('feeds/all', [FeedsController::class, 'feedsAll']);
    Route::get('feeds/all', [FeedsController::class, 'feedsAll']);
    Route::get('feeds/shorts', [FeedsController::class, 'shorts']);
    Route::get('feeds/videos', [FeedsController::class, 'videos']);

    Route::post('shorts/increase/view', [FeedsController::class, 'increaseShortsView']);
    Route::post('videos/increase/view', [FeedsController::class, 'increaseVideoView']);



    Route::get('/', [MainController::class, 'index']);
    Route::get('/admin/add/site', [MainController::class, 'addSite'])->name('add.site');

    Route::post('/check-domain', [MainController::class, 'checkSite'])->name('check.site');
});
