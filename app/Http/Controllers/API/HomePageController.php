<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageControllerResource;
use App\Http\Resources\HomePageResource;
use App\Models\AdsImages;
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

    public function headlinesApartment($state)
    {
        //  Headlines for apartment , limit the result  
        // we need to change this all the time , for paid users, benefits 
        $fetch_images =   HomePageControllerResource::collection(DB::table('itemfree_ads')
            ->where('itemfree_ads.categories', 'Apartment')
            ->where('itemfree_ads.state', $state)
            // ->join('itemfree_videos_ads', 'itemfree_ads.state', '=', 'itemfree_videos_ads.state')
            ->inRandomOrder()
            ->get());
        $test = AdsImages::where('itemfree_ads_id', 2)->first();;

        $fetch_videos = HomePageResource::collection(DB::table('itemfree_videos_ads')
            ->where('itemfree_videos_ads.categories', 'Apartment')
            ->where('itemfree_videos_ads.state', $state)->inRandomOrder()
            ->get());;

        // check if the person does not allow their location to be turned on 


        return response()->json([
            'status' => 200,
            'test' => $test,
            'normalads' => $fetch_images,
            'videos' => $fetch_videos
        ]);
    }
    public function headlinephones($state)
    {
        $fetch_images =   HomePageControllerResource::collection(DB::table('itemfree_ads')
            ->where('itemfree_ads.categories', 'Phones, Tablets')
            ->where('itemfree_ads.state', $state)
            // ->join('itemfree_videos_ads', 'itemfree_ads.state', '=', 'itemfree_videos_ads.state')
            ->inRandomOrder()
            ->get());

        $fetch_videos = HomePageResource::collection(DB::table('itemfree_videos_ads')
            ->where('itemfree_videos_ads.categories', 'Phones, Tablets')
            ->where('itemfree_videos_ads.state', $state)->inRandomOrder()
            ->get());;


        return response()->json([
            'status' => 200,
            'normalads' => $fetch_images,
            'videos' => $fetch_videos
        ]);
    }


    public function headlinecars($state)
    {
        $fetch_images =   HomePageControllerResource::collection(DB::table('itemfree_ads')
            ->where('itemfree_ads.categories', 'Automotive , Vehicles')
            ->where('itemfree_ads.state', $state)
            // ->join('itemfree_videos_ads', 'itemfree_ads.state', '=', 'itemfree_videos_ads.state')
            ->inRandomOrder()
            ->get());

        $fetch_videos = HomePageResource::collection(DB::table('itemfree_videos_ads')
            ->where('itemfree_videos_ads.categories', 'Automotive , Vehicles')
            ->where('itemfree_videos_ads.state', $state)->inRandomOrder()
            ->get());;

        // do a error handing on them 
        return response()->json([
            'status' => 200,
            'normalads' => $fetch_images,
            'videos' => $fetch_videos
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
        // also work with the plan ==== Basic Benefit , Standard Benefit , Premium   Benefit 
        // also add eager loading!!!!!! important one
        // Alos be to make to get popluar in a state when they load site
        $homepagerender_state = DB::table('itemfree_ads')
            ->join(
                'itemfree_videos_ads',
                'itemfree_ads.state',
                '=',
                'itemfree_videos_ads.state'
            )
            ->where('itemfree_ads.state', $state)
            ->where('itemfree_ads.categories', $categories)
            ->inRandomOrder()
            ->get();

        $homepagerender_local_gov = DB::table('itemfree_ads')
            ->join(
                'itemfree_videos_ads',
                'itemfree_ads.local_gov',
                '=',
                'itemfree_videos_ads.local_gov'
            )
            ->where('itemfree_ads.categories', $categories)
            ->where('itemfree_ads.local_gov', $local_gov)
            ->inRandomOrder()->get();

        // $homepage_general
        //General headline api  
        $headline_categories_ =  DB::table('itemfree_ads')
            ->join('itemfree_videos_ads', 'itemfree_ads.state',  '=', 'itemfree_videos_ads.state')
            ->where('itemfree_ads.headlines', 'Get best women wares')
            ->where('itemfree_ads.state', $state)
            ->where('itemfree_ads.categories', $categories)

            // ->inRandomOrder()
            ->get();

        if ($state === "" || $local_gov  === "") {
            return response()->json([
                'message' => 'not workign well '
            ]);
        }
        if ($homepagerender_state) {
            return response()->json([
                'status' => 200,
                'message' => $headline_categories_,
                // 'local_gov' => $homepagerender_local_gov
            ]);
        }
    }




    public function generalTrending()
    {
        // this function will produce all ads base on location of the user or other wise , which will just be videos alone 
        /// note will be changing it to images sometimes 
        // Ads to present , Automotive , Womens, phones , baby product ,House , Apartment 

        $categories = [
            "Laptops",
        
            "Property", 
        
            "Phones, Tablets", 
        
            "Fragrances",
        
            "Skincare",
        
            "Groceries",
        
            "home-decoration",
        
            "Furniture ,Home ",
           
            "Womens bikins",
        
            "Kids , Baby dresses", 
        
            "Womens under waress",
        
            "womens-dresses",
        
            "womens-shoes",
        
            "Pets",
        
            "Mens-shirts",
        
            "Mens-shoes",
        
            "Mens-watches",
        
            "Womens-watches",
        
            "Womens-bags",
        
            "Womens-jewellery",
           
            "Automotive , Vehicles",
        
            "Motorcycle",
        
            "Apartment",
        
            "Fashion",
        
            "Sport Dresses"];

        // $state = ['Lagos']

        $fetch_images = HomePageControllerResource::collection(
            // symlink(storage_path('/app/public'), public_path('storage/'))
            DB::table('itemfree_ads')
            ->whereIn('itemfree_ads.categories', $categories)
            ->inRandomOrder()
            ->get());
            
        if ($fetch_images) {
            return response()->json([
                'status' => 200,
                'normalads' => $fetch_images
            ]);
        }
        return response()->json([
            'status' => 500,
            'messages' => 'something went worng',
            // 'local_gov' => $homepagerender_local_gov
        ]);
    }

    public function generalTrendingPage($id)
    {
        // join the itemfreead and adimages , so when user clicks on one post it show remaining information of that post 
        $fetch_details  = ItemfreeAds::find($id);
        $fetch_details->adsimages()->where('itemfree_ads_id', $id)->get();

        $fetch_details_others  = ItemfreeAds::find($id)->adsimages()->where('itemfree_ads_id', $id)->inRandomOrder()->get();
        if ($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                'other_data' => $fetch_details_others
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'data' => "no data found"
            ]);
        }
    }
    public function simlairAds()
    {
        // showing other items 
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











