<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ThreadController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route trang chủ
Route::get('/', function () {
    return view('welcome'); 
});

// Xác thực người dùng (nếu chưa có)
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['role:admin']], function () {
    // Các route dành cho quản trị viên
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::group(['middleware' => ['role:moderator|admin']], function () {
    // Các route dành cho quản trị nội dung
    Route::get('/moderator', [ModeratorController::class, 'index'])->name('moderator.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Các route khác cho admin

    // Routes cho quản lý danh mục
    Route::resource('categories', CategoryController::class);
});

// Các route yêu cầu người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {

    Route::resource('threads', ThreadController::class);
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Route dành cho tất cả người dùng đã đăng nhập
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Routes dành cho Quản trị viên
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        // Các route khác dành cho quản trị viên
    });

    // Routes dành cho Quản trị nội dung
    Route::middleware(['role:moderator|admin'])->group(function () {
        Route::get('/moderator', [ModeratorController::class, 'index'])->name('moderator.dashboard');
        // Các route khác dành cho quản trị nội dung
    });

    // Routes dành cho Người dùng thông thường
    // Thêm các route khác nếu cần
});