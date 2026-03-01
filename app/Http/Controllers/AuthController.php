<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị trang đăng ký
    public function showRegister() {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Hãy đăng nhập.');
    }

    // Hiển thị trang đăng nhập
    public function showLogin() {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors(['login_error' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
    }

    // Đăng xuất
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}