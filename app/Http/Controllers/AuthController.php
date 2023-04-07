<?php

namespace App\Http\Controllers;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
   
    public function registerStudent(Request $request)
    {
       
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->department = $request->department;
        $user->password = bcrypt($request->password);
        $user->role = 'student';
        $user->save();

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }


   
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'department'=>'required',
           
        ]);

        $credentials = $request->only('email', 'password','department');

        if (!auth()->attempt($credentials)) {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        $user = auth()->user();

        if ($user->role !== 'student') {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 401);
        }

        $token = $user->createToken('student')->accessToken;

        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }
    public function teacherLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
           
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $user = auth()->user();

        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 401);
        }

        $token = $user->createToken('teacher')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }


    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }


    public function update(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string'
        ]);

        $image = $this->saveImage($request->image, 'profiles');

        $user = auth()->user();
        $user->name = $attrs['name'];
        $user->image = $image;
        $user->save();
        

        return response([
            'message' => 'User updated.',
            'user' => auth()->user()
        ], 200);
    }

}
 