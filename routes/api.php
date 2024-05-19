<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\ItemfreeAdsController;
use App\Http\Controllers\API\ItemfreeVideosAdsController;
use App\Http\Controllers\API\ItemsAdsController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    // get User info route 
    Route::get('/getuser', [AuthController::class, 'getInfo']);
    //get user profile details 
    Route::get('/getuser/{id}', [UserController::class, 'settings']);

    // free  Ads Routes  
    Route::post('/freeads', [ItemfreeAdsController::class, 'freeLimitedAds']);
    Route::post('/freeads/{id}', [ItemfreeAdsController::class, 'addimages']);
    Route::post('/vidoesfreeads', [ItemfreeVideosAdsController::class, 'freeLimitedAds']);


    // Paid Ads 
    Route::post('/normalads', [ItemsAdsController::class, 'ItemsAdsStore']);



    //update user information from setting page .............................................
    Route::put('/user/settings/{iduser}', [UserController::class, 'updateuserinfo']);



    /// personalized routes 
});

//   Home-page Public  api and other  public   apis for other pages 
// 1)  Seaarch engine powerfull api ( auto generated word )

// 2) Categiories Api  
Route::get('/categoriesapi', [HomePageController::class, 'categoriesapi']);
Route::get(
    '/categoriesapi/{categoriesapi}/{state}/{local_gov}',
    [HomePageController::class, 'categoriesapiSinglePages']
);
// 3) Personlized Ads Api 

// 4)General  Trending Ads Api 
Route::get('/trendingads', [HomePageController::class, 'generalTrending']);
// get id 
Route::get('/trendingads/{id}',[HomePageController::class, 'generalTrendingPage']);




// 6) Top  Services Api 

// Trending Ads api with Headlines  ( method is hard coded  on the frist time user goes to the site   )
/// 1 ) headlinesApartment
Route::get('/apartment/{state}', [HomePageController::class, 'headlinesApartment']);
// 2) headlinesPhones, Tablets
Route::get('/phones/{state}', [HomePageController::class, 'headlinephones']);
// 3) headlines for Baby products 

// 4) headlines for Fashions 

/// 5 ) headlines for Cars
Route::get('/cars/{state}', [HomePageController::class, 'headlinecars']);

/// 6 ) headlines for Grocerys 

// 7 ) headlines for Health and Beauty 

///test endpoint
Route::get('/test', [ItemfreeAdsController::class, 'showoneimage']);





// Public Api for login and Sighup 
Route::post('/sighup', [AuthController::class, 'sighup']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);
















// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });