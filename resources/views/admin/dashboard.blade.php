@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trang Dashboard Quản Trị Viên</h1>
    <p>Xin chào, {{ Auth::user()->name }}!</p>
    <!-- Thêm nội dung dashboard tại đây -->
</div>
@endsection
