@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-16 p-8 bg-white rounded-2xl shadow-lg border">
    <h2 class="text-2xl font-bold text-center mb-6">Đăng nhập tài khoản</h2>
    
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        @if($errors->has('login_error'))
            <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm mb-4">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Tên đăng nhập</label>
            <input type="text" name="username" value="{{ old('username') }}" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Mật khẩu</label>
            <input type="password" name="password" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">
            Đăng nhập ngay
        </button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-4">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Đăng ký ngay</a></p>
</div>
@endsection