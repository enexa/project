<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumConversation;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
    {
        return response([
            'forums' => Forum::orderBy('created_at', 'desc')->with('user:id,name')->withCount('comments', 'likes')
            ->with('likes', function($like){
                return $like->where('user_id', auth()->user()->id)
                    ->select('id', 'user_id', 'Forum_id')->get();
            })
            ->get()
        ], 200);
    }
    public function show($id)
    {
        return response([
            'announcements' => Forum::where('id', $id)->withCount('comments', 'likes')->get()
        ], 200);
    }
    public function store(Request $request)
    {
       
        $attrs = $request->validate([
            'body' => 'required|string'
        ]);


        $forum = Forum::create([
            'body' => $attrs['body'],
            'user_id' => auth()->user()->id,
         
        ]);

      

        return response([
            'message' => 'Post created.',
            'post' => $forum,
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $forum = Forum::find($id);

        if(!$forum)
        {
            return response([
                'message' => 'Forum not found.'
            ], 403);
        }

        if($forum->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

      
        $attrs = $request->validate([
            'body' => 'required|string'
        ]);

        $forum->update([
            'body' =>  $attrs['body']
        ]);

       

        return response([
            'message' => 'forum updated.',
            'post' => $forum
        ], 200);
    }
    public function destroy($id)
    {
        $forum = Forum::find($id);

        if(!$forum)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if($forum->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        $forum->comments()->delete();
        $forum->likes()->delete();
        $forum->delete();

        return response([
            'message' => 'Post deleted.'
        ], 200);
    }
}
