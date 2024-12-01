@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo chủ đề mới</h1>

    <form action="{{ route('threads.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category_id">Danh mục</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="body">Nội dung</label>
            <textarea name="body" class="form-control" rows="5">{{ old('body') }}</textarea>
            @error('body')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tags">Thẻ</label>
            <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="Nhập các thẻ, cách nhau bằng dấu phẩy">
        </div>

        <button type="submit" class="btn btn-primary">Gửi</button>
    </form>
</div>
@endsection
