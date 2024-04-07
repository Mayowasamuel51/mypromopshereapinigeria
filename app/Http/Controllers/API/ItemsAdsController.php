<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemsAds;
use Illuminate\Http\Request;

class ItemsAdsController extends Controller
{
    //

    public function ItemsAdsStore(Request $request)
    {
        $request->validate([
            'categories' => 'required',
            'description' => 'required',
            'price_range' => 'required|integer',
            'state' => 'required',
            'local_gov' => 'required',
            'headlines' => 'required',
            'itemadsid' => 'required',
            'titleImageurl' => 'required'
        ]);

        if (auth('sanctum')->check()) {
            $items  = ItemsAds::create([
                'categories' => $request->categories,
                'description' => $request->description,
                'price_range' => $request->price,
                'state' => $request->state,
                'local_gov' => $request->local_gov,
                'headlines' => $request->headlines,
                'itemadsid' => $request->itemadsid,
                'usedOrnew' => $request->usedOrnew,
                // 'titleImageurl'=>
            ]);

            if ($items) {
                return response()->json([
                    'status' => 201,
                    'message' => 'items ads created'
                ]);
            }
        }
    }
}
