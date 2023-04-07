<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // public function registerStudent(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|confirmed',
    //         'department'=>'required|string'
    //     ]);

    //     $user = new User;
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = bcrypt($request->password);
    //     $user->department=$request->department;
    //     $user->role = 'student';
    //     $user->save();

    //     return response()->json(['message' => 'Successfully registered as a student.'], 201);
    // }

    public function registerTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Only admin can register teacher
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 401);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'teacher';
        $user->save();

        return response()->json(['message' => 'Successfully registered as a teacher.'], 201);
    }

    public function listStudents()
    {
        // Only admin can view all students
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 401);
        }

        $students = User::where('role', 'student')->get();

        return response()->json($students, 200);
    }
    
    
   
}

