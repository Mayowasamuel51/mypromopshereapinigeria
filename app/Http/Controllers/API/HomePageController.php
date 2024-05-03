<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\categories;
use App\Models\ItemfreeAds;

class HomePageController extends Controller
{
    public function categoriesapi()
    {
        // display all categories api in database and make query to one when they click one 
        $categories = \App\Http\Resources\categoriesResource::collection(categories::all());
        if ($categories) {
            return response()->json([
                'status' => 200,
                'message' => $categories
            ]);
        }
        return response()->json([
            'status' => 500,
            'message' => "Network Problem!!"
        ]);
    }

    public function categoriesapiSinglePages($categories, $state, $local_gov, Request $request)
    {
        $database_table_one = ItemfreeAds::where('categories', $categories)
            ->where('state', $state)->where('local_gov', $local_gov)->get();
        // what if the user did not allow to access location  or  third party cookies   what do we do 
        // we need to ask user for thire location to get better result for them 

        // Build a function to show ads base on user location  
        // Use recommendation Algortim  .... show people who as paid compared to people using freeplan 
        // Table to be used === 
        // Itemfree table , Itemvideo table , Service providers table , Itemtable , Itemvideo table 
        // IP geolocation vs. user-provided location vs. browsing behavior  vs user not proving there location 
        // headlines Api   ..........................................
        $homepagerender_state = DB::table('itemfree_ads')
            ->join('itemfree_videos_ads', 'itemfree_ads.state', 
            '=', 'itemfree_videos_ads.state')

            ->where('itemfree_ads.state', $state)
            ->where('itemfree_ads.categories', $categories)
            // ->inRandomOrder()
            ->get();

        $homepagerender_local_gov = DB::table('itemfree_ads')
            ->join('itemfree_videos_ads', 'itemfree_ads.local_gov', '=', 'itemfree_videos_ads.local_gov')
            ->where('itemfree_ads.categories', $categories)
            ->where('itemfree_ads.local_gov', $local_gov)
            ->inRandomOrder()->get();

        // $homepage_general

        if ($state === "" || $local_gov  === "") { 
            return response()->json([
                'message' => 'not workign well '
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => $homepagerender_state,
            // 'local_gov' => $homepagerender_local_gov
        ]);
    }



    public function trendingads()
    {
    }
}






// note the categoriesapi will return a response , it the repsonse we are gonna use  in this categoriesapiSinglePage   !!!!!
        // listing all  service or trending under each categories clicked upon 
        // combine trending Ads +  Service  Ads ===== +  
        // Table to be used === 
        // Itemfree table , Itemvideo table , Service providers table , Ttem table , Itemvideo table 
        // Use recommendation Algortim  .... show people who as paid compared to people using freeplan 
        //also fetch base on headlines ----- this is important   most of them used they same headlines 
        // also fetch base on location of the person seraching for something  this is very important becos of privacy iisues
        // crucial to prioritize user privacy and ensure accurate results.
        // include random result fetch from the databse 



        // DB::table('users')
        // ->join('contacts', 'users.id', '=', 'contacts.user_id')
        // ->join('orders', 'users.id', '=', 'orders.user_id')
        // ->select('users.*', 'contacts.phone', 'orders.price')
        // ->get();