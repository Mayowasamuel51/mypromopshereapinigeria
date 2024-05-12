<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
     public function __construct(){
        $this->middleware('auth:sanctum')
        ->except(['sighup','login']);
    }
    public function  getInfo(){
        // get user info base on token to show for 
        $user = Auth::user();
        if(!$user){
            return response()->json([
                'status' => 401,
                'message' => 'You are not unauthenticated Procced to login or register '
            ]);
        }
        $info = User::where('id',$user->id)->get();
        if(!$info){
            return response()->json([
                'status' => 401,
                'message' => 'You are not unauthenticated Procced to login or register '
            ]);
        }
        return response()->json([
            'status' => 20,
            'message' => $info
        ]);

    }
    public function sighup(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            throw ValidationException::withMessages([
                'email' => ['Email Exist already procced to login']
            ], 401);
        } else {
            $createuser  =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'current_plan'=>"free_plan", 
                'id_number'=> rand(1222,45543),
                'password' => Hash::make('password', [$request->password] )
            ]);
            $token = $createuser->createToken("API-TOKEN".$createuser->email)->plainTextToken;
            return response()->json([
                'token' => $token,
                'status' => 201,
                'success' => $createuser
            ]);
        }
    }

    public function login(Request $request){
        /// this is not working well .still need to fix need to checking of passwords
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            throw ValidationException::withMessages([
                'email'=>['email not correct']
            ], 401);
    
        }
        // if(!Auth::attempt($request->only(['email',Hash::check($request->password, $user->password)]))){
        //     return  response()->json(['', 
        //     "inviad users or worng password"=> 422]);
        // }
        // $user = User::where('email', $request->email)->first();
        if(Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email'=>['email not correct or password']
            ], 422);
        }
        $token=  $user->createToken("API-TOKEN".$user->email)->plainTextToken;
        return response()->json([
            'token'=>$token,
            'profileImage'=>$user->profileImage,
            'user'=>$user->email,
            'user-name'=>$user->name,
            'id'=>$user->id
        ]);

    }

      public function logout(Request $request)   {
        /** @var User $user */
        $request->user()->tokens()->delete();
        return  response()->json([
            'status' => 200,
            'message' => 'u have logout '
        ]);
    }
}
