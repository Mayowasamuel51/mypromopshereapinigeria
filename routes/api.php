<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ItemfreeAdsController;
use App\Http\Controllers\API\ItemfreeVideosAdsController;
use App\Http\Controllers\API\ItemsAdsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    // Ads Routes
    Route::post('/freeads',[ItemfreeAdsController::class, 'freeLimitedAds']);
    Route::post('/vidoesfreeads',[ItemfreeVideosAdsController::class, 'freeLimitedAds']);
    Route::post('/normalads', [ItemsAdsController::class, 'ItemsAdsStore']);
});


Route::post('/sighup', [AuthController::class, 'sighup']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);