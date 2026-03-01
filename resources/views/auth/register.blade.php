@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-12 p-8 bg-white rounded-2xl shadow-lg border">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Đăng ký tài khoản</h2>
        <p class="text-gray-500 mt-2">Trở thành độc giả của VTC SmartNews để trải nghiệm AI</p>
    </div>

    <form action="{{ route('register') }}" method="POST" class="space-y-5">
        @csrf

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Họ và tên</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-user"></i>
                </span>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition" 
                    placeholder="Nhập tên của bạn">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tên đăng nhập</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-at"></i>
                </span>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition" 
                    placeholder="nhập tài khoản muốn đăng ký">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition" 
                    placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Số điện thoại</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition" 
                    placeholder="nhập số điện thoại của bạn">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ</label>
            <textarea name="address" rows="2"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition" 
                placeholder="Số nhà, tên đường, thành phố...">{{ old('address') }}</textarea>
        </div>

        <button type="submit" 
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-blue-700 shadow-lg transition">
            Tạo tài khoản ngay
        </button>
    </form>

    <div class="text-center mt-6 text-sm text-gray-600">
        Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Đăng nhập</a>
    </div>
</div>
@endsection