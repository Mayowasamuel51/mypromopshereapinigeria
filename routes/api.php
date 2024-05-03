<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\ItemfreeAdsController;
use App\Http\Controllers\API\ItemfreeVideosAdsController;
use App\Http\Controllers\API\ItemsAdsController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    // get User info route 
    Route::get('/getuser', [AuthController::class, 'getInfo']);
    // free  Ads Routes
    Route::post('/freeads', [ItemfreeAdsController::class, 'freeLimitedAds']);
    Route::post('/freeads/{id}', [ItemfreeAdsController::class, 'addimages']);
    Route::post('/vidoesfreeads', [ItemfreeVideosAdsController::class, 'freeLimitedAds']);
    // Paid Ads 
    Route::post('/normalads', [ItemsAdsController::class, 'ItemsAdsStore']);
});

//   Home-page Public  api and other  public   apis for other pages 
// 1)  Seaarch engine powerfull api ( auto generated word )

// 2) Categiories Api  
Route::get('/categoriesapi', [HomePageController::class, 'categoriesapi']);
Route::get('/categoriesapi/{categoriesapi}/{state}/{local_gov}', [HomePageController::class, 'categoriesapiSinglePages']);
// 3) Personlized Ads Api 

// 4) Trending Ads Api 

// 6) Top  Services Api 








// Public Api for login and Sighup 
Route::post('/sighup', [AuthController::class, 'sighup']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);
















// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });