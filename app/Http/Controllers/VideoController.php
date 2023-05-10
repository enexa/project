<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;
use App\Models\Course;
use App\Models\Teacher;


class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all(['url']);
        return response()->json($videos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:mp4|max:2048',
            'teacher_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);
    
        // TODO: Get the teacher by ID from the database
        $teacher = Teacher::findOrFail($request->teacher_id);

        // TODO: Get the course by ID from the database
        $course = Course::findOrFail($request->course_id);

        // TODO: Store the video in a folder named after the course ID inside a folder named after the teacher ID
        $path = $request->file('file')->store('videos/' . $teacher->id . '/' . $course->id);
    
        // TODO: Save the video URL, teacher ID, and course ID to the database
        $video = new Video();
        $video->url = $path;
        $video->teacher_id = $teacher->id;
        $video->course_id = $course->id;
        $video->save();
    
        return response()->json(['success' => true]);
    }

}
