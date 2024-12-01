<!-- create.blade.php và edit.blade.php có thể tương tự nhau -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($category) ? 'Chỉnh sửa' : 'Thêm' }} danh mục</h1>

    <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', isset($category) ? $category->name : '') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Cập nhật' : 'Thêm mới' }}</button>
    </form>
</div>
@endsection
