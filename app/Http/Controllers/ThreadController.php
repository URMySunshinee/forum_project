<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category; 
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    
    public function index(Request $request)
    {
        $categories = Category::all();

        $threads = Thread::where('approved', true)
            ->when($request->category, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(10);

        return view('threads.index', compact('threads', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('threads.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $thread = new Thread();
        $thread->user_id = Auth::id();
        $thread->category_id = $request->category_id;
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->approved = false; // Chủ đề cần được phê duyệt
        $thread->save();

        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $thread->attachTags($tags);
        }

        return redirect()->route('threads.index')->with('success', 'Chủ đề của bạn đã được gửi và đang chờ phê duyệt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = Thread::findOrFail($id);

        if (!$thread->approved && !Auth::user()->hasRole('admin|moderator')) {
            abort(403, 'Bạn không có quyền truy cập chủ đề này.');
        }
    
        $posts = $thread->posts()->where('approved', true)->get();
    
        return view('threads.show', compact('thread', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thread = Thread::findOrFail($id);

        if ($thread->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa chủ đề này.');
        }

        $categories = Category::all();

        return view('threads.edit', compact('thread', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);

        if ($thread->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền cập nhật chủ đề này.');
        }
    
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
    
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->save();
    
        return redirect()->route('threads.show', $thread->id)->with('success', 'Chủ đề đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);

        if ($thread->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
        abort(403, 'Bạn không có quyền xóa chủ đề này.');
        }

        $thread->delete();

        return redirect()->route('threads.index')->with('success', 'Chủ đề đã được xóa.');
    }
}
