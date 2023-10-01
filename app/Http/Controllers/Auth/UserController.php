<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function sigin(Request $request)
    {
        try {
            //Validated
            $rules = Validator::make($request->all(), [
                "email" => "required|email|regex:/(.+)@(.+)\.(.+)/i|indisposable",
                "password" => [
                    "required",
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(3),
                ],
            ]);

            //Validate cheack
            if ($rules->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $rules->errors()
                ], 401);
            }

            //Authenticate
            if (!Auth::attempt($request->only(['email', 'password']), $request->remember)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function signup(Request $request)
    {
        try {
            //Validated
            $rules = Validator::make($request->all(), [
                "first_name" => "required|string",
                "last_name" => "required|string",
                "user_name" => "required|unique:users,user_name",
                "email" => "required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i|indisposable",
                "password" => [
                    "required",
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(3),
                ],
                "confirm_password" => [
                    "required",
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(3),
                    "same:password"
                ],
            ]);

            if ($rules->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $rules->errors()
                ], 401);
            }

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if (!$user->save()) {
                return response()->json([
                    'status' => false,
                    'message' => 'User create faild',
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAll()
    {
        $users = User::all();
        if (count($users) > 0) {
            return response()->json([
                'status' => true,
                'message' => 'User list.',
                'data' => $users,
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'User Not avilable this time.',
            'data' => $users,
        ], 500);
    }

    public function signout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User logout',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
