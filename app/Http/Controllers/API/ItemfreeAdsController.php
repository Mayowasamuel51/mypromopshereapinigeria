<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemfreeAds;
use App\Models\ItemsAds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemfreeAdsController extends Controller
{
    //
    public function freeLimitedAds(Request $request)
    {
        // the freelimited ad will only allow 15  per new account to post noramls ads and video ads 
        // we need to count the times it was used 
        // every post == 1 eliter noraml post or videos post 
        $request->validate([
            'categories' => 'required',
            'description' => 'required',
            'price_range' => 'required|integer',
            'state' => 'required',
            'local_gov' => 'required',
            'headlines' => 'required',
            'titleImageurl' => 'required'
        ]);

        // check if free times is more than 20 times 
        // check the current time stage ( meaning how many left)

        if (auth('sanctum')->check()) {


            if (auth()->user()->current_plan  === 'freeplan') {

                if (auth()->user()->freetimes >= 5) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'sorry you cant post again , please upgrade to paid plan '
                    ]);
                }

                $value = 1;
                $items  = ItemfreeAds::create([
                    "user_id" => auth()->user()->id,
                    'categories' => $request->categories,
                    'description' => $request->description,
                    'price_range' => $request->price,
                    'state' => $request->state,
                    'local_gov' => $request->local_gov,
                    'headlines' => $request->headlines,
                    'itemadsid' => rand(999297, 45543),
                    'usedOrnew' => $request->usedOrnew,
                    'titleImageurl' => $request->titleImageurl,
                    // 'freetimes'=>$value
                ]);
                // $user_update_free_times = new User;
                // $user_update_free_times->freetimes = $value;
                // $user_update_free_times->update();

                if ($items) {
                    if (auth()) {   
                        $affected = DB::table('users')->increment('freetimes');
                        //  DB::table('users')
                        //     ->where('id', auth()->user()->id)
                        //     ->update(['freetimes' => $value]);
                        return response()->json([
                            'status' => 201,
                            'check' =>  $affected ,
                            'message' => 'items ads created'
                        ]);
                    }
                }
                return response()->json([
                    'status' => 500,
                    'message' => 'something happend while trying to create a ad  '
                ]);
            }
            return response()->json([
                'status' => 500,
                'message' => 'Sorry you have finshed your free ads   '
            ]);
        }
        return response()->json([
            'status' => 401,
            'message' => 'not allowed  '
        ]);
    }
}
