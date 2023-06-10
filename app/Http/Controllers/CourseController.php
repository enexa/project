<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;






class CourseController extends Controller
{
    public function index()
{
    $courses = Course::all();

    $courseVideos = [];
    foreach ($courses as $course) {
        if (!isset($courseVideos[$course->title])) {
            $courseVideos[$course->title] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'video' => []
            ];
        }
        $courseVideos[$course->title]['video'][] = $course->video;
    }

    return response()->json(array_values($courseVideos));
}

    

    public function show(Course $course)
    {
        return response()->json($course);
    }


   
    
   

public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'thumbnail' => 'required|image',
        'video' => 'required|mimes:mp4',
    ]);

    
    $teacher = Auth::user();

   
    $courseFolder = Str::slug($validatedData['title']);
    $coursePath = public_path('storage/courses/' . $courseFolder);

   
    if (!file_exists($coursePath)) {
        mkdir($coursePath, 0777, true);
    }

    $thumbnail = $request->file('thumbnail');
    $thumbnailName = $thumbnail->getClientOriginalName();
    $thumbnailPath = $thumbnail->move($coursePath . '/thumbnails', $thumbnailName);

    $video = $request->file('video');
    $videoName = $video->getClientOriginalName();
    $videoPath = $video->move($coursePath . '/videos', $videoName);
    
    $thumbnailUrl = asset('storage/courses/' . $courseFolder . '/thumbnails/' . $thumbnailName);
    $videoUrl = asset('storage/courses/' . $courseFolder . '/videos/' . $videoName);
   
    
    $course = Course::create([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'thumbnail' => $thumbnailUrl,
        'video' => $videoUrl,
        'teacher_id' => $teacher->id,
    ]);



    
    $course->thumbnail = $thumbnailUrl;
    $course->video = $videoUrl;

    
    return response()->json([
        'message' => 'Course created successfully',
        'course' => $course,
    ]);
}

public function enroll(Request $request, $title)
{
    // Validate the request data
    $validatedData = $request->validate([
        'title' => 'required',
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Check if the user is a student
    if ($user->role !== 'student') {
        return response()->json(['message' => 'Only students can enroll in courses'], 403);
    }

    // Find all courses with the given title
    $courses = Course::where('title', $validatedData['title'])->get();

    // Check if any courses with the given title exist
    if ($courses->isEmpty()) {
        return response()->json(['message' => 'No courses found with the given title'], 404);
    }

    // Enroll the student in each course
    foreach ($courses as $course) {
        // Retrieve the enrolled students as an array
        $enrolledStudents = $course->students ?? [];

        // Check if the student is already enrolled in the course
        if (in_array($user->id, $enrolledStudents)) {
            continue; // Skip this course and move to the next one
        }

        // Add the student ID to the course's enrolled students
        $enrolledStudents[] = $user->id;
        $course->students = $enrolledStudents;
        $course->save();
    }

    // Return a response indicating successful enrollment
    return response()->json(['message' => 'Enrollment successful']);
}

public function enrolledStudents($title)
{
    // Get the authenticated user
    $user = Auth::user();

    // Check if the user is a teacher
    if ($user->role !== 'teacher') {
        return response()->json(['message' => 'Only teachers can access enrolled students'], 403);
    }

    // Find the courses with the given title
    $courses = Course::where('title', $title)->get();

    // Check if any courses with the given title exist
    if ($courses->isEmpty()) {
        return response()->json(['message' => 'No courses found with the given title'], 404);
    }

    // Retrieve the enrolled student IDs from all courses
    $enrolledStudents = $courses->pluck('enrolled_students')->flatten()->unique();

    // Retrieve the details of the enrolled students
    $students = User::whereIn('id', $enrolledStudents)->get();

    // Return a response with the enrolled students
    return response()->json(['students' => $students]);
}
    
    
    

    


   
    public function courseVideos($title)
{
    $courses = Course::where('title', $title)->get();

    if ($courses->isEmpty()) {
        return response()->json(['message' => 'Course not found'], 404);
    }

    $videoUrls = $courses->pluck('video')->toArray();

    return response()->json(['video_urls' => $videoUrls]);
}


    

    
    

    

    public function teacherCourses(Request $request)
    {
        $user = $request->user();
        $courses = $user->courses;
        return response()->json($courses);
    }

    public function courseStudents(Course $course)
    {
        $students = $course->students;
        return response()->json($students);
    }
    
}
