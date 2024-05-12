<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function updateuserinfo(Request $request, $iduser)
    {
        $validator = Validator::make($request->all(), [
            // 'profileImage' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $all_data = $request->all();
            if (auth('sanctum')->check()) {
                $user_infomation = User::findOrFail($iduser);
                if ($user_infomation) {
                    // $user_infomation->name = $request->names;
                    $user_infomation->profileImage =   $request->profileImage;
                    // $user_infomation->id = auth()->user()->id;
                    // $user_infomation->websiteName = $request->websiteName;
                    $user_infomation->messageCompany = $request->messageCompany;
                    // $user_infomation->aboutMe = $request->aboutMe;
                    $user_infomation->save();
                    // return response()->json([
                    //     'status'=>200,
                    //     'updated' => $user_infomation
                    // ]);
                    return response()->json([
                        'status' => 200,
                        'updated' => $user_infomation
                    ]);
                }

            }
        }
    }


    public function settings($id){
        $user  = User::where('id',$id)->get();
        // findOrFail($id);
        if (auth('sanctum')->check()) {
            if($user){
                return response()->json([
                    'status' => 200,
                    'data' => $user
                ]);
            }
        }
    }
}











 // $user_auth =  Auth::user()->id;
                // $user_infomation->profileImage = $request->profi
                // $user_infomation->password
                // $user_infomation->id = $user_auth;