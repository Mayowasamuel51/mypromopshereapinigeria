<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdsImages;
use App\Models\ItemfreeAds;
use App\Models\ItemsAds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemfreeAdsController extends Controller
{
    //

    public function showoneimage()
    {
        $itemfree_ads = ItemfreeAds::where('id', 2)->get();

        //join itemfree and addimages 
        $item  = ItemfreeAds::find(52);
        $item->adsimages()->where('itemfree_ads_id', 52)->get();

        return response()->json([
            'status' => 200,
            'message' => $item
            // $itemfree_ads->first()->titleImageurl
        ]);
    }
    public function  addimages(Request $request, $id)
    {
        $request->validate([
            'itemadsimagesurls' => 'required'
            // image'
        ]);
        $item = ItemfreeAds::find($id);
        $loaditem = $item->adsimages()->create([
            'itemadsimagesurls' => $request->itemadsimagesurls
        ]);
        if (auth('sanctum')->check()) {
            if ($loaditem) { // checking network is okay............................
                return response()->json([
                    'message' => $loaditem
                    // 'info'=>ItemfreeAds::find($id)
                ]);
            }
            return response()->json([
                'status' => 500
                // 'info'=>ItemfreeAds::find($id)
            ]);
        }
        return response()->json([
            'status' => 401,
            'message' => 'You are not unauthenticated Procced to login or register '
        ]);
    }
    public function freeLimitedAds(Request $request, ItemfreeAds  $itemfreeAds)
    {
        // the freelimited ad will only allow 15  per new account to post noramls ads and video ads 
        // we need to count the times it was used 
        // every post == 1 eliter noraml post or videos post 
        $request->validate([
            'categories' => 'required',
            'description' => 'required',
            // 'price_range' => 'required|integer',
            'state' => 'required',
            // 'local_gov' => 'required',
            // 'headlines' => 'required',
            'titleImageurl' => 'required'
        ]);

        // check if free times is more than 20 times 
        // check the current time stage ( meaning how many left)

        if (auth('sanctum')->check()) {
            if (auth()->user()->current_plan  === 'freeplan') {
                if (auth()->user()->freetimes >= 5100) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'sorry you cant post again , please upgrade to paid plan '
                    ]);
                }

                $items  = new  ItemfreeAds;
                $items->user_id = auth()->user()->id;
                $items->categories = $request->categories;
                $items->description = $request->description;
                $items->price_range = $request->price;
                $items->state = $request->state;
                $items->local_gov = $request->local_gov;
                $items->headlines = $request->headlines;
                $items->itemadsid = rand(999297, 45543);
                $items->usedOrnew = $request->usedOrnew;
                $items->user_image =$request->user_image;

                $filetitleimage = $request->file('titleImageurl');
                $folderPath = "public/";
                $fileName =  uniqid() . '.png';
                $file = $folderPath;
                // . $fileName;
             $mainfile =    Storage::put($file, $filetitleimage);
                $items->titleImageurl = $mainfile;


         
                $items->save();
                if (
                    $items
                    // &&
                    // $post
                    // $comment
                ) {

                    if (auth()) {
                        $affected = DB::table('users')->increment('freetimes');
                        //  DB::table('users')
                        //     ->where('id', auth()->user()->id)
                        //     ->update(['freetimes' => $value]);
                        // $comment = new AdsImages(['itemadsimagesurls' => $request->itemadsimagesurls]);
                        // $post =  ItemfreeAds::find($items->id);
                        // $post->adsimages()->save($comment);
                        return response()->json([
                            'status' => 201,
                            'item' => $items->id,
                            'check' =>  $affected,
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
            'message' => 'You are not unauthenticated Procced to login or register '
        ]);
    }
}



                // $file = $request->file('titleImageurl');

                // // Validate the uploaded file (optional, but recommended)
                // $this->validate($request, [
                //     'titleImageurl' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust allowed extensions and size limit as needed
                // ]);

                // // Generate a unique filename with a more secure approach
                // $fileName = time() . uniqid('', true) . '.' . $file->getClientOriginalExtension();
                // $folderPath = "public/titleImages/";
                // // Store the uploaded file using the 'titleImages' disk (assuming you have one configured)
                // // $filePath = Storage::disk('titleImages')->put($fileName, $file->getContent()); // Use getContent() for better performance
                // $file = $folderPath . $fileName; 
                // Storage::put($file, $fileName);

                // // Update the $items->titleImageurl property with the stored filename relative to the disk
                // $items->titleImageurl = $fileName; 

                // $items->titleImageurl =  $request->titleImageurl;
                // $request->file('titleImageurl')->store('avatars');
                // $imageItemfile = $request->file('titleImageurl');
                // $imageName = time() . '.' . $imageItemfile->getClientOriginalExtension();
                // $request->titleImageurl->storeAs('mainimages', $imageName);
                // $imageItemfile->move('mainimages', $imageName);
                // $items->titleImageurl = $imageName;
                 // $items  = ItemfreeAds::create([
                //     "user_id" => auth()->user()->id,
                //     'categories' => $request->categories,
                //     'description' => $request->description,
                //     'price_range' => $request->price,
                //     'state' => $request->state,
                //     'local_gov' => $request->local_gov,
                //     'headlines' => $request->headlines,
                //     'itemadsid' => rand(999297, 45543),
                //     'usedOrnew' => $request->usedOrnew,
                //     'titleImageurl' => $request->titleImageurl,
                //     // 'freetimes'=>$value
                // ]);
                  // 'freetimes'=>$value
                /// load  mutiple images into Ads images  .... try and add timer , like await 
                // $adsimages = AdsImages::create([
                //     'itemfree_ads_id' => $items->id,
                //     'itemadsimagesurls' => $request->itemadsimagesurls
                // ]);
                // $post = AdsImages::find(1);
                // $comment = $post->itemfreeads()->create([
                //     'itemadsimagesurls' => 'A new comment.',
                // ]);
                // $comment = new AdsImages;
                // $comment->itemadsimagesurls =  $request->itemadsimagesurls;
                // $comment->itemfree_ads_id =  $items->id;`
                // $items->adsimages()->save($comment);
                // $post->adsimages()->save($comment);
                // $new_item = new ItemfreeAds::find(1);
                // $user_update_free_times = new User;
                // $user_update_free_times->freetimes = $value;
                // $user_update_free_times->update();
                // $item_post = ItemfreeAds::find(1);
                // $loaditem = $item_post->adsimages()->create([
                //     'itemadsimagesurls' => $request->itemadsimagesurls
                // ]);