<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumConversation;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
    {
        $forumConversations = Forum::all();
        return response()->json($forumConversations);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $forumConversation = Forum::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return response()->json($forumConversation, 201);
    }
}
