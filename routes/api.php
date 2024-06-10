<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\ItemfreeAdsController;
use App\Http\Controllers\API\ItemfreeVideosAdsController;
use App\Http\Controllers\API\ItemsAdsController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;




Route::get('auth', [AuthController::class, 'redirectToAuth']);
Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);



// Public Api for login and Sighup 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/sighup', [AuthController::class, 'sighup']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    // get User info route 
    Route::get('/getuser', [AuthController::class, 'getInfo']);
    
    // free  Ads Routes  
    Route::post('/freeads', [ItemfreeAdsController::class, 'freeLimitedAds']);
    Route::post('/freeads/{id}', [ItemfreeAdsController::class, 'addimages']);
    Route::post('/vidoesfreeads', [ItemfreeVideosAdsController::class, 'freeLimitedAds']);

    //update user information from setting page .............................................
    Route::put('/user/settings/{iduser}', [UserController::class, 'updateuserinfo']);
    Route::put('/user/settings/background/{iduser}', [UserController::class, 'updatebackgroundimage']);
      //get user profile details 
    Route::get('/getuser/{id}', [UserController::class, 'settings']);
   


     // PersonalUploads for a user
     Route::get('/posts/{id}', [UserController::class, 'personalUploads']);
     Route::get('/postsvideos/{id}', [UserController::class, 'personalVideos']);


     
    // Paid Ads 
    Route::post('/normalads', [ItemsAdsController::class, 'ItemsAdsStore']);
});

// Homepage search side 
Route::get('/search/{query}',[HomePageController::class, 'searchapi']);

//  Trending Ads Api 
Route::get('/trendingads', [HomePageController::class, 'generalTrending']);
Route::get('/trendingads/{id}', [HomePageController::class, 'generalTrendingPage']);

// Top level 
Route::get('/toplevel', [HomePageController::class, 'toplevelads']);
// Route::get('/toplevel/{id}', [HomePageController::class, 'toplevelads']);

//Discount Link 
Route::get('/discount', [HomePageController::class, 'Discount']);
// Route::get('/discount/{id}', [HomePageController::class, 'Discount']);

// baby Link
Route::get('/Kids_Baby_dresses',[HomePageController::class , 'baby']);
// Route::get('/Kids_Baby_dresses',[HomePageController::class , 'baby']);

//property Api 
Route::get('/property',[HomePageController::class , 'Property']);
// Route::get('/Kids_Baby_dresses',[HomePageController::class , 'baby']);

// Luxury-apartment api 
Route::get('/luxuryapartment',[HomePageController::class , 'Luxury_apartment']);


// Top videoes Ads 
Route::get('/trendingadsvideos', [HomePageController::class, 'generalTopVideos']);
Route::get('/trendingadsvideos/{id}', [HomePageController::class, 'generalTopVideosPage']);


// User click  profile Api   ..see other this be the users
Route::get('/useruploads/{id}', [UserController::class, 'profileData']);
Route::get('/profile/{id}', [UserController::class, 'Userprofile']);


//   Home-page Public  api and other  public   apis for other pages 
// 1)  Seaarch engine powerfull api ( auto generated word )

// 2) Categiories Api  
Route::get('/categoriesapi', [HomePageController::class, 'categoriesapi']);
Route::get(
    '/categoriesapi/{categoriesapi}/{state}/{local_gov}',
    [HomePageController::class, 'categoriesapiSinglePages']
);
// 3) Personlized Ads Api 





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




















// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });