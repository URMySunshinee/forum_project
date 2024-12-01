@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách chủ đề</h1>

    <!-- Bộ lọc danh mục -->
    <div class="mb-3">
        <form method="GET" action="{{ route('threads.index') }}">
            <div class="form-group">
                <label for="category">Chọn danh mục:</label>
                <select name="category" class="form-control" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @foreach($threads as $thread)
        <div class="card mb-3">
            <div class="card-header">
                <a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a>
                <span class="badge badge-secondary">{{ $thread->category->name }}</span>
            </div>
            <div class="card-body">
                {{ Str::limit($thread->body, 150) }}
            </div>
            <div class="card-footer">
                Đăng bởi: {{ $thread->user->name }} vào lúc {{ $thread->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
    
         <!-- Hiển thị thẻ -->
        @foreach($thread->tags as $tag)
            <span class="badge badge-primary">{{ $tag->name }}</span>
        @endforeach
    @endforeach
    {{ $threads->appends(request()->query())->links() }}
</div>
@endsection

