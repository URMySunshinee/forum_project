@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $thread->title }}</h1>
    <p><strong>Danh mục:</strong> {{ $thread->category->name }}</p>
    <p>{{ $thread->body }}</p>
    <p>Đăng bởi: {{ $thread->user->name }} vào lúc {{ $thread->created_at->format('d/m/Y H:i') }}</p>

    <!-- Nút chỉnh sửa và xóa (nếu có quyền) -->
    @if($thread->user_id == Auth::id())
        <a href="{{ route('threads.edit', $thread->id) }}" class="btn btn-warning">Chỉnh sửa</a>

        <form action="{{ route('threads.destroy', $thread->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa</button>
        </form>
    @endif

    <hr>

    <!-- Danh sách bài viết trong chủ đề -->
    <h3>Bài viết</h3>
    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                {{ $post->body }}
            </div>
            <div class="card-footer">
                Đăng bởi: {{ $post->user->name }} vào lúc {{ $post->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
        
    @endforeach

    <!-- Form thêm bài viết mới -->
    <h4>Thêm bình luận</h4>
    @auth
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
        <div class="form-group">
            <textarea name="body" class="form-control" rows="3"></textarea>
            @error('body')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Gửi</button>
    </form>
    @endauth
</div>
@endsection
