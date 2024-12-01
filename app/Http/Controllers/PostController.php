<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'thread_id' => 'required|exists:threads,id',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->thread_id = $request->thread_id;
        $post->body = $request->body;
        $post->approved = false; // Bài viết cần được phê duyệt
        $post->save();

        return redirect()->route('threads.show', $request->thread_id)->with('success', 'Bài viết của bạn đã được gửi và đang chờ phê duyệt.');
    }
}
