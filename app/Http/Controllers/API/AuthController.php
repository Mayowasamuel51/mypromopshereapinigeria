<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use App\Traits\HttpResponse;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Illuminate\Http\JsonResponse;
class AuthController extends Controller{
  
    //
    //  public function __construct(){
    //     $this->middleware('auth:sanctum')
    //     ->except(['sighup','login']);
    // }
    use HttpResponse;
    public function redirectToAuth(): JsonResponse  {
        return response()->json([
            'url' => Socialite::driver('google')
                         ->stateless()
                         ->redirect()
                         ->getTargetUrl(),
        ]);
    }
    public function handleAuthCallback(): JsonResponse  {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        /** @var User $user */
        $user = User::query()
        ->firstOrCreate(
                [
                    'email' => $socialiteUser->email,
                ],
                [
                    'email_verified_at' => now(),
                    'name' => $socialiteUser->name,
                    'google_id' => $socialiteUser->id,
                    'avatar' => $socialiteUser->avatar,
                    'current_plan'=>"free_plan", 
                    'id_number'=> rand(1222,45543),
                    'password' => $socialiteUser->password,
                ]
            );
            // Auth::login($user);
            $token=$user->createToken('google-token'.$user->name)->plainTextToken;
        return response()->json([
            'token'=>$token,
            'profileImage'=>$user->profileImage,
            'user'=>$user->email,
            'user-name'=>$user->name,
            'id'=>$user->id,
            'users' => $user,
            // 'token' => $user->createToken('google-token'.$user->name)->plainTextToken,
            // 'token_type' => 'Bearer',
        ]);
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
