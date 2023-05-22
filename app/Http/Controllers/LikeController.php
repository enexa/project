<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    //
    public function likeOrUnlike($id)
    {
        $post = Forum::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        $like = $post->likes()->where('user_id', auth()->user()->id)->first();

        // if not liked then like
        if(!$like)
        {
            Like::create([
                'forum_id' => $id,
                'user_id' => auth()->user()->id
            ]);

            return response([
                'message' => 'Liked'
            ], 200);
        }
        // else dislike it
        $like->delete();

        return response([
            'message' => 'Disliked'
        ], 200);
    }
}
