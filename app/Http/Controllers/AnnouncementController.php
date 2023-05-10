<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\announcement;
use App\Models\User;


class AnnouncementController extends Controller
{
    //
    public function index()
    {
        return response([
            'announcements' => announcement::withCount('comments', 'likes')->get()
        ], 200);
    }

   
    public function show($id)
    {
        return response([
            'announcements' => announcement::where('id', $id)->withCount('comments', 'likes')->get()
        ], 200);
    }


   
    public function store(Request $request)
    {
       
        $attrs = $request->validate([
            'body' => 'required|string'
        ]);

        $image = $this->saveImage($request->image, 'posts');

        $post = announcement::create([
            'body' => $attrs['body'],
            'user_id' => auth()->user()->id,
            'image' => $image
        ]);

      

        return response([
            'message' => 'Post created.',
            'post' => $post,
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $post = announcement::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if($post->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

      
        $attrs = $request->validate([
            'body' => 'required|string'
        ]);

        $post->update([
            'body' =>  $attrs['body']
        ]);

       

        return response([
            'message' => 'Post updated.',
            'post' => $post
        ], 200);
    }

  
    public function destroy($id)
    {
        $post = announcement::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if($post->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        $post->comments()->delete();
        $post->likes()->delete();
        $post->delete();

        return response([
            'message' => 'Post deleted.'
        ], 200);
    }
}
