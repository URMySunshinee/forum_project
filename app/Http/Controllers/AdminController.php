<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Chỉ cho phép người dùng có vai trò 'admin' truy cập vào các phương thức của controller này
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        // Nội dung trang quản trị viên
        return view('admin.dashboard');
    }

}
