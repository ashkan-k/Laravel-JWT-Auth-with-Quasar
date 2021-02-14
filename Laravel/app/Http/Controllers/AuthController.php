<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected static function UploadImage($img)
    {
        $file = $img;
        $path = 'uploads/users/';
        $name = Str::random(15) . '-' . time() . $file->getClientOriginalName();

        $file->move(public_path($path) , $name);

        return $path . $name;
    }

   public function isLogin()
   {
       return response(['status' => true , 'isLogin' => \auth('api')->check()] , 200);
   }

   public function updateProfile(Request $request)
   {
       $request['img'] == 'null' && $request['img'] = null;

       \auth('api')->user()->update([
           'username' => $request['username'],
           'name' => $request['name'],
           'family' => $request['family'],
           'img' => $request['file'] !== 'null' ? self::UploadImage($request['file']) : $request['img'],
           'password' => $request['password'] !== 'null' ? Hash::make($request['password']) : \auth('api')->user()->password,
       ]);

       return response(['status' => true , 'message' => 'Profile updated successfully'] , 200);
   }

    public function register(Request $request)
    {
        $validators = Validator::make($request->all() , [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validators->fails())
        {
            return response()->json(['status' => false , 'error' => $validators->getMessageBag()->first()] , 200);
        }

        $request['password'] = Hash::make($request->password);

        User::create($request->all());

        return response()->json(['status' => true , 'message' => 'user created successfully'] , 200);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 200);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        if (\auth('api')->check())
        {
            return response()->json(['status' => true , 'user' => auth('api')->user()] , 200);
        }
        else
        {
            return response()->json(['status' => false , 'error' => 'You are Unauthorized'], 200);
        }
    }

    public function logout()
    {
        if (\auth('api')->check())
        {
            auth('api')->logout();
            return response()->json(['status' => true , 'message' => 'Successfully logged out'] , 200);
        }
        else
        {
            return response()->json(['status' => false , 'error' => 'there was an error while trying logout'] , 200);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'user' => \auth('api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 10080
        ]);
    }
}
