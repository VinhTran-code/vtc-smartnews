<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use Gemini\Laravel\Facades\Gemini;

// 1. Logic Trang chủ: Kiểm tra đăng nhập
Route::get('/', function (Illuminate\Http\Request $request) { // Thêm $request vào đây
    if (Auth::check()) {
        // Truyền biến $request vào hàm index
        return app(NewsController::class)->index($request); 
    }
    return view('onboard');
})->name('home');

// 2. Trang chào mừng (Có thể dùng lại làm trang giới thiệu riêng biệt)
Route::get('/welcome', function () {
    return view('onboard');
})->name('onboard');

// 3. Nhóm các chức năng bắt buộc phải ĐĂNG NHẬP mới được xem
Route::middleware(['auth'])->group(function () {
    
    // Chi tiết bài viết
    Route::get('/article/{id}', [NewsController::class, 'show'])->name('article.detail');
    
    // Chatbot xử lý qua Controller chuyên biệt
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::post('/ai/summarize', [ChatController::class, 'summarize'])->name('chat.summarize');
    // Quản lý Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// 4. Các Route xác thực (Login/Register/Logout)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Nhóm các Route dành cho Quản trị viên
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Sử dụng Controller Group cho AdminController
    Route::controller(AdminController::class)->group(function () {
        
        // 1. Trang Dashboard tổng quát
        Route::get('/dashboard', 'dashboard')->name('dashboard');

        // 2. Chức năng Quản lý người dùng
        // Hiển thị danh sách: admin.users
        Route::get('/users', 'userIndex')->name('users');
        
        // Xóa người dùng: admin.users.delete
        // Sử dụng DELETE method để đúng chuẩn RESTful
        Route::delete('/users/{id}', 'userDelete')->name('users.delete');

        // (Dự phòng cho tương lai) Quản lý bài báo
        Route::get('/articles', 'articleIndex')->name('articles');
        Route::get('/articles/create', 'articleCreate')->name('articles.create');
        Route::post('/articles/store', 'articleStore')->name('articles.store');
        Route::get('/articles/edit/{id}', 'articleEdit')->name('articles.edit');
        Route::put('/articles/update/{id}', 'articleUpdate')->name('articles.update');
        Route::delete('/articles/delete/{id}', 'articleDelete')->name('articles.delete');
       Route::get('/chats', 'chatHistory')->name('chats');
   }); 
});