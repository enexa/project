<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;




class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    public function show(Course $course)
    {
        return response()->json($course);
    }


   
    
   

public function store(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'thumbnail' => 'required|image',
        'video' => 'required|mimes:mp4',
    ]);

    // Get the authenticated user (teacher)
    $teacher = Auth::user();

    // Create a folder for the course using the course title
    $courseFolder = Str::slug($validatedData['title']);
    $coursePath = public_path('storage/courses/' . $courseFolder);

    // Create the course folder if it doesn't exist
    if (!file_exists($coursePath)) {
        mkdir($coursePath, 0777, true);
    }

    // Store the thumbnail image in the course folder with the original file name
    $thumbnail = $request->file('thumbnail');
    $thumbnailName = $thumbnail->getClientOriginalName();
    $thumbnailPath = $thumbnail->move($coursePath . '/thumbnails', $thumbnailName);

    // Store the video in the course folder with the original file name
    $video = $request->file('video');
    $videoName = $video->getClientOriginalName();
    $videoPath = $video->move($coursePath . '/videos', $videoName);
    // Generate the URLs for thumbnail and video
    $thumbnailUrl = asset('storage/courses/' . $courseFolder . '/thumbnails/' . $thumbnailName);
    $videoUrl = asset('storage/courses/' . $courseFolder . '/videos/' . $videoName);
    // Create the course
    
    $course = Course::create([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'thumbnail' => $thumbnailUrl,
        'video' => $videoUrl,
        'teacher_id' => $teacher->id,
    ]);



    // Update the course object with the file URLs
    $course->thumbnail = $thumbnailUrl;
    $course->video = $videoUrl;

    // Return a response with the created course
    return response()->json([
        'message' => 'Course created successfully',
        'course' => $course,
    ]);
}

    
    
    
    

    


    public function enroll(Course $course, Request $request)
    {
        // Perform enrollment logic here
        // Example: Add student to course's students list
        $user = $request->user();
        $course->students()->attach($user->id);

        return response()->json(['message' => 'Enrolled successfully']);
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
