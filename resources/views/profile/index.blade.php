@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    {{-- Nút Quay lại - Đã sửa để trở về trang chủ --}}
    <div class="mb-4">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 flex items-center transition">
            <i class="fa fa-arrow-left mr-2"></i> Quay lại trang chủ
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="bg-blue-600 p-6 flex justify-between items-center">
            <h2 class="text-white text-xl font-bold">Hồ sơ người dùng</h2>
            <i class="fa fa-user-circle text-white text-2xl opacity-80"></i>
        </div>
        
        <div class="p-8">
            {{-- Thông báo thành công --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg flex items-center">
                    <i class="fa fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6" id="profileForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Họ và tên</label>
                        <input type="text" name="name" value="{{ $user->name }}" 
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tên đăng nhập (Không thể sửa)</label>
                        <input type="text" value="{{ $user->username }}" disabled
                               class="w-full border bg-gray-50 rounded-lg px-4 py-2 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" 
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Địa chỉ</label>
                    <textarea name="address" rows="3" 
                              class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">{{ $user->address }}</textarea>
                </div>

                {{-- Nhóm nút điều hướng --}}
                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="reset" class="w-full sm:w-auto px-8 py-2 text-gray-600 font-semibold hover:bg-gray-100 rounded-lg transition">
                        Hủy bỏ
                    </button>
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-8 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-md transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection