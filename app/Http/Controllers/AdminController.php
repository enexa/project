<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function logout(Request $request)
{
    $this->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    Cache::flush(); // added to clear cache after logout

    // add this line to prevent user from navigating back to home page
    return redirect()->route('login')->with('logout', 'You have been logged out.');
}

    public function dashboard()
    {
        // Only admin can access the dashboard
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.dashboard', compact('students', 'teachers'));
    }
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('index');
    }

    public function createTeacher()
    {
        return view('admin.create-teacher');
    }

    public function storeTeacher(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'teacher';
        $user->save();

        return redirect()->route('admin.index')->with('success', 'Teacher registered successfully.');
    }

    public function listStudents()
    {
        $students = User::where('role', 'student')->get();

        return view('admin.list-students', compact('students'));
    }
    public function listTeachers()
{
    $teachers = User::where('role', 'teacher')->get();
    return view('admin.list-teachers', compact('teachers'));
}

    public function destroyStudent(User $student)
{
    // Only admin can delete students
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'You are not authorized to perform this action.'], 401);
    }

    $student->delete();
    return redirect()->route('admin.list.students');
}
public function searchStudents(Request $request)
{
    $students = User::where('role', 'student')->where('name', 'like', '%' . $request->search . '%')->get();

    return view('admin.list-students', compact('students'));
}



}

