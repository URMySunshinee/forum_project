<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function __construct()
    {
        // Cho phép 'moderator' và 'admin' truy cập
        $this->middleware(['role:moderator|admin']);
    }

    public function index()
    {
        // Nội dung trang quản trị nội dung
        return view('moderator.dashboard');
    }

}
